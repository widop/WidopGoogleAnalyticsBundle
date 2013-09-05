<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Tests\Model;

use Widop\GoogleAnalyticsBundle\Model\Client;

/**
 * Google analytics client test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\GoogleAnalyticsBundle\Model\Client */
    protected $client;

    /** @var string */
    protected $clientId;

    /** @var string */
    protected $privateKeyFile;

    /** @var string */
    protected $url;

    /** @var \Widop\HttpAdapterBundle\Model\HttpAdapterInterface */
    protected $httpAdapterMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->clientId = 'client_id';
        $this->privateKeyFile = __DIR__.'/../Fixtures/certificate.p12';
        $this->httpAdapterMock = $this->getMock('Widop\HttpAdapterBundle\Model\HttpAdapterInterface');
        $this->url = 'https://foo';

        $this->client = new Client($this->clientId, $this->privateKeyFile, $this->httpAdapterMock, $this->url);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->client);
        unset($this->clientId);
        unset($this->privateKeyFile);
        unset($this->httpAdapterMock);
        unset($this->url);
    }

    public function testDefaultState()
    {
        $this->assertSame($this->clientId, $this->client->getClientId());
        $this->assertSame($this->privateKeyFile, $this->client->getPrivateKeyFile());
        $this->assertSame($this->httpAdapterMock, $this->client->getHttpAdapter());
        $this->assertSame($this->url, $this->client->getUrl());
    }

    public function testAccessToken()
    {
        if (!function_exists('openssl_x509_read')) {
            $this->markTestSkipped('The "openssl_x509_read" function is not available.');
        }

        $this->httpAdapterMock
            ->expects($this->once())
            ->method('postContent')
            ->with(
                $this->equalTo($this->url),
                $this->equalTo(array('Content-Type' => 'application/x-www-form-urlencoded'))
            )
            ->will($this->returnValue(json_encode(array('access_token' => 'token'))));

        $this->assertSame('token', $this->client->getAccessToken());
    }

    public function testAccessTokenError()
    {
        if (!function_exists('openssl_x509_read')) {
            $this->markTestSkipped('The "openssl_x509_read" function is not available.');
        } else {
            $this->setExpectedException('Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException');
        }

        $this->httpAdapterMock
            ->expects($this->once())
            ->method('postContent')
            ->will($this->returnValue(json_encode(array('error' => 'error'))));

        $this->client->getAccessToken();
    }

    /**
     * @expectedException Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException
     */
    public function testInvalidPrivateKeyFile()
    {
        $this->client->setPrivateKeyFile('/foo.p12');
        $this->client->getAccessToken();
    }

    /**
     * @expectedException Widop\GoogleAnalyticsBundle\Exception\GoogleAnalyticsException
     */
    public function testInvalidPkcs12Format()
    {
        $this->client->setPrivateKeyFile(__DIR__.'/../Fixtures/invalid_format.p12');
        $this->client->getAccessToken();
    }
}
