<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Model;

use Widop\HttpAdapterBundle\Model\HttpAdapterInterface;

/**
 * Google analytics client.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Client
{
    /** @const The google OAuth Rest URL. */
    const URL = 'https://accounts.google.com/o/oauth2/token';

    /** @const The google OAuth scope. */
    const SCOPE = 'https://www.googleapis.com/auth/analytics.readonly';

    /** @var string */
    protected $clientId;

    /** @var string */
    protected $privateKeyFile;

    /** @var \Widop\HttpAdapterBundle\Model\HttpAdapterInterface */
    protected $httpAdapter;

    /** @var string */
    protected $accessToken;

    /**
     * Creates a client.
     *
     * @param string                                              $clientId       The client ID.
     * @param string                                              $privateKeyFile The absolute private key file path.
     * @param \Widop\HttpAdapterBundle\Model\HttpAdapterInterface $httpAdapter    The http adapter.
     */
    public function __construct($clientId, $privateKeyFile, HttpAdapterInterface $httpAdapter)
    {
        $this->setClientId($clientId);
        $this->setPrivateKeyFile($privateKeyFile);
        $this->setHttpAdapter($httpAdapter);
    }

    /**
     * Gets the client ID.
     *
     * @return string The client ID.
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Sets the client ID.
     *
     * @param string $clientId The client ID.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\Client The client.
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        
        return $this;
    }

    /**
     * Gets the absolute private key file path.
     *
     * @return string The absolute private key file path.
     */
    public function getPrivateKeyFile()
    {
        return $this->privateKeyFile;
    }

    /**
     * Sets the absolute private key file path.
     *
     * @param string $privateKeyFile The absolute private key file path.
     *
     * @throws \InvalidArgumentException If the private key file does not exist.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\Client The client.
     */
    public function setPrivateKeyFile($privateKeyFile)
    {
        if (!file_exists($privateKeyFile)) {
            throw new \InvalidArgumentException(
                sprintf('The PKCS 12 certificate "%s" does not exist.', $privateKeyFile)
            );
        }

        $this->privateKeyFile = $privateKeyFile;
        
        return $this;
    }

    /**
     * Gets the http adapter.
     *
     * @return \Widop\HttpAdapterBundle\Model\HttpAdapterInterface The http adapter.
     */
    public function getHttpAdapter()
    {
        return $this->httpAdapter;
    }

    /**
     * Sets the http adapter.
     *
     * @param \Widop\HttpAdapterBundle\Model\HttpAdapterInterface $httpAdapter The http adapter.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\Client The client.
     */
    public function setHttpAdapter(HttpAdapterInterface $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
        
        return $this;
    }

    /**
     * Gets the google OAuth access token.
     *
     * @throws \Exception If the access token can not be retrieved.
     *
     * @return string The access token.
     */
    public function getAccessToken()
    {
        if ($this->accessToken === null) {
            $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
            $content = array(
                'grant_type'     => 'assertion',
                'assertion_type' => 'http://oauth.net/grant_type/jwt/1.0/bearer',
                'assertion'      => $this->generateJsonWebToken(),
            );

            $response = json_decode($this->httpAdapter->postContent(self::URL, $headers, $content));

            if (isset($response->error)) {
                throw new \Exception(sprintf('Failed to retrieve access token (%s).', $response->error));
            }

            $this->accessToken = $response->access_token;
        }

        return $this->accessToken;
    }

    /**
     * Generates the JWT in order to get the access token.
     *
     * @return string The Json Web Token (JWT).
     */
    protected function generateJsonWebToken()
    {
        $exp = new \DateTime('+1 hours');
        $iat = new \DateTime();

        $jwtHeader = base64_encode(json_encode(array('alg' => 'RS256', 'typ' => 'JWT')));

        $jwtClaimSet = base64_encode(
            json_encode(
                array(
                    'iss'   => $this->clientId,
                    'scope' => self::SCOPE,
                    'aud'   => self::URL,
                    'exp'   => $exp->getTimestamp(),
                    'iat'   => $iat->getTimestamp(),
                )
            )
        );

        $jwtSignature = base64_encode($this->generateSignature($jwtHeader.'.'.$jwtClaimSet));

        return sprintf('%s.%s.%s', $jwtHeader, $jwtClaimSet, $jwtSignature);
    }

    /**
     * Generates the JWT signature according to the private key file and the JWT content.
     *
     * @param string $jsonWebToken The JWT content.
     *
     * @throws \Exception If an error occured when generating the signature.
     *
     * @return string The JWT signature.
     */
    protected function generateSignature($jsonWebToken)
    {
        if (!function_exists('openssl_x509_read')) {
            throw new \Exception('The openssl extension is required.');
        }

        $certificate = file_get_contents($this->privateKeyFile);

        $certificates = array();
        if (!openssl_pkcs12_read($certificate, $certificates, 'notasecret')) {
            throw new \Exception('An error occured when parsing the PKCS 12 certificate.');
        }

        if (!isset($certificates['pkey']) || !$certificates['pkey']) {
            throw new \Exception('The PKCS 12 certificate is not valid.');
        }

        $ressource = openssl_pkey_get_private($certificates['pkey']);

        if (!$ressource) {
            throw new \Exception('An error occurend when fetching the PKCS 12 private key.');
        }

        $signature = null;
        if (!openssl_sign($jsonWebToken, $signature, $ressource, 'sha256')) {
            throw new \Exception('An error occurend when validating the PKCS 12 certificate.');
        }

        openssl_pkey_free($ressource);

        return $signature;
    }
}
