<?php

/*
 * This file is part of the Widop package.
 *
 * (c) Widop <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Model;

use Symfony\Component\DependencyInjection\ContainerAware,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Widop\HttpAdapterBundle\Model\HttpAdapterInterface;

/**
 * Client.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Client extends ContainerAware
{
    /**
     * @const The google OAuth Rest URL.
     */
    const URL = 'https://accounts.google.com/o/oauth2/token';

    /**
     * @const The google OAuth scope.
     */
    const SCOPE = 'https://www.googleapis.com/auth/analytics.readonly';

    /**
     * @var string The client ID.
     */
    private $clientId;

    /**
     * @var string The absolute private key file path.
     */
    private $privateKeyFile;

    /**
     * @var \Widop\HttpAdapterBundle\Model\HttpAdapterInterface The http adapter used by the client.
     */
    private $httpAdapter;

    /**
     * @var string The google OAuth acces token.
     */
    private $accessToken;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);

        $this->setClientId($this->container->getParameter('widop_google_analytics.client_id'));
        $this->setPrivateKeyFile($this->container->getParameter('widop_google_analytics.private_key_file'));
        $this->setHttpAdapter($this->container->get($this->container->getParameter('widop_google_analytics.http_adapter')));
    }

    /**
     * Gets the client ID.
     *
     * @return string
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
     * @return \Widop\GoogleAnalyticsBundle\Model\Client
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Gets the absolute private key file path.
     *
     * @return string
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
     * @return \Widop\GoogleAnalyticsBundle\Model\Client
     */
    public function setPrivateKeyFile($privateKeyFile)
    {
        $this->privateKeyFile = $privateKeyFile;

        return $this;
    }

    /**
     * Gets the Http Adapter used by the client.
     *
     * @return \Widop\HttpAdapterBundle\Model\HttpAdapterInterface
     */
    public function getHttpAdapter()
    {
        return $this->httpAdapter;
    }

    /**
     * Sets the Http Adapter used by the client.
     *
     * @param \Widop\HttpAdapterBundle\Model\HttpAdapterInterface $httpAdapter The Http Adapter used by the client.
     *
     * @return \Widop\GoogleAnalyticsBundle\Model\Client
     */
    public function setHttpAdapter(HttpAdapterInterface $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;

        return $this;
    }

    /**
     * Gets the google OAuth access token.
     *
     * @return string
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

			if(isset($response->error))
				throw new \ErrorException("Failed to retrieve access token, google responsed: " .$response->error);

            $this->accessToken = $response->access_token;
        }

        return $this->accessToken;
    }

    /**
     * Generates the JWT in order to get the access token.
     *
     * @return string
     */
    private function generateJsonWebToken()
    {
        $exp = new \DateTime('+1 hours');
        $iat = new \DateTime();

        $jwtHeader = base64_encode(json_encode(array(
            'alg' => 'RS256',
            'typ' => 'JWT',
        )));

        $jwtClaimSet = base64_encode(json_encode(array(
            'iss'   => $this->clientId,
            'scope' => self::SCOPE,
            'aud'   => self::URL,
            'exp'   => $exp->getTimestamp(),
            'iat'   => $iat->getTimestamp(),
        )));

        $jwtSignature = base64_encode($this->generateSignature($jwtHeader.'.'.$jwtClaimSet));

        return $jwtHeader.'.'.$jwtClaimSet.'.'.$jwtSignature;
    }

    /**
     * Generated the jwt signature according to the private key file and the jwt content.
     *
     * @param string $jwt The JWT content.
     *
     * @return string
     */
    private function generateSignature($jwt)
    {
        if (!function_exists('openssl_x509_read')) {
            throw new \Exception();
        }

        $certificate = file_get_contents($this->privateKeyFile);

        $certificates = array();
        if (!openssl_pkcs12_read($certificate, $certificates, 'notasecret')) {
            throw new \Exception();
        }

        if (!isset($certificates['pkey']) || !$certificates['pkey']) {
            throw new \Exception();
        }

        $ressource = openssl_pkey_get_private($certificates['pkey']);

        if (!$ressource) {
            throw new \Exception();
        }

        $signature = null;

        if (!openssl_sign($jwt, $signature, $ressource, 'sha256')) {
            throw new \Exception();
        }

        openssl_pkey_free($ressource);

        return $signature;
    }
}
