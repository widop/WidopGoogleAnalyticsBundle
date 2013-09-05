<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Exception;

/**
 * Google Analytics exception.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class GoogleAnalyticsException extends \Exception
{
    /**
     * Gets the "INVALID ACCESS TOKEN" exception.
     *
     * @param string $error The error message.
     *
     * @return \Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException The "INVALID ACCESS TOKEN" exception.
     */
    public static function invalidAccessToken($error)
    {
        return new self(sprintf('Failed to retrieve access token (%s).', $error));
    }

    /**
     * Gets the "INVALID PRIVATE KEY FILE" exception.
     *
     * @param string $path The private key file path.
     *
     * @return \Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException The "INVALID PRIVATE KEY FILE" exception.
     */
    public static function invalidPrivateKeyFile($path)
    {
        return new self(sprintf('The PKCS 12 certificate "%s" does not exist.', $path));
    }

    /**
     * Gets the "INVALID OPEN SSL EXTENSION" exception.
     *
     * @return \Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException The "INVALID OPEN SSL EXTENSION" exception.
     */
    public static function invalidOpenSslExtension()
    {
        return new self('The openssl extension is required.');
    }

    /**
     * Gets the "INVALID PKCS 12 FILE" exception.
     *
     * @return \Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException The "INVALID PKCS 12 FILE" exception.
     */
    public static function invalidPKCS12File()
    {
        return new self('An error occured when parsing the PKCS 12 certificate.');
    }

    /**
     * Gets the "INVALID PKCS 12 FORMAT" exception.
     *
     * @return \Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException The "INVALID PKCS 12 FORMAT" exception.
     */
    public static function invalidPKCS12Format()
    {
        return new self('The PKCS 12 certificate is not valid.');
    }

    /**
     * Gets the "INVALID PKCS 12 PKEY" exception.
     *
     * @return \Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException The "INVALID PKCS 12 PKEY" exception.
     */
    public static function invalidPKCS12PKey()
    {
        return new self('An error occurend when fetching the PKCS 12 private key.');
    }

    /**
     * Gets the "INVALID PKCS 12 SIGNATURE" exception.
     *
     * @return \Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException The "INVALID PKCS 12 SIGNATURE" exception.
     */
    public static function invalidPKCS12Signature()
    {
        return new self('An error occurend when validating the PKCS 12 certificate.');
    }

    /**
     * Gets the "INVALID QUERY" exception.
     *
     * @param string $error The error message.
     *
     * @return \Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException The "INVALID QUERY" exception.
     */
    public static function invalidQuery($error)
    {
        return new self(sprintf('An error occured when querying the google analytics service (%s).', $error));
    }
}
