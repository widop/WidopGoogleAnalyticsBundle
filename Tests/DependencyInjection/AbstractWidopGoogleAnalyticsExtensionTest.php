<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Widop\HttpAdapterBundle\DependencyInjection\WidopHttpAdapterExtension;
use Widop\GoogleAnalyticsBundle\DependencyInjection\WidopGoogleAnalyticsExtension;

/**
 * Abstract Wid'pop google analytics extension test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractWidopGoogleAnalyticsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Symfony\Component\DependencyInjection\ContainerBuilder */
    protected $container;

    /**
     * {@ineritdoc}
     */
    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->container->setParameter('bundle.dir', realpath(__DIR__.'/../../'));
        $this->container->registerExtension($extension = new WidopHttpAdapterExtension());
        $this->container->loadFromExtension($extension->getAlias());
        $this->container->registerExtension(new WidopGoogleAnalyticsExtension());
    }

    /**
     * {@ineritdoc}
     */
    protected function tearDown()
    {
        unset($this->container);
    }

    /**
     * Loads a configuration.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container     The container builder.
     * @param string                                                  $configuration The configuration name.
     */
    abstract protected function loadConfiguration(ContainerBuilder $container, $configuration);

    public function testGoogleAnalyticsService()
    {
        $this->loadConfiguration($this->container, 'google_analytics');
        $this->container->compile();

        $googleAnalytics = $this->container->get('widop_google_analytics');

        $this->assertInstanceOf('Widop\GoogleAnalytics\Service', $googleAnalytics);
        $this->assertSame('https://accounts.google.com/o/oauth2/token', $googleAnalytics->getClient()->getUrl());
        $this->assertSame('client_id', $googleAnalytics->getClient()->getClientId());
        $this->assertSame('certificate.p12', substr($googleAnalytics->getClient()->getPrivateKeyFile(), -15));
        $this->assertSame('curl', $googleAnalytics->getClient()->getHttpAdapter()->getName());
    }

    public function testQueryService()
    {
        $this->loadConfiguration($this->container, 'google_analytics');
        $this->container->compile();

        $query = $this->container->get('widop_google_analytics.query');

        $this->assertInstanceOf('Widop\GoogleAnalytics\Query', $query);
        $this->assertSame('profile_id', $query->getIds());
    }

    public function testServiceUrl()
    {
        $this->loadConfiguration($this->container, 'service_url');
        $this->container->compile();

        $googleAnalytics = $this->container->get('widop_google_analytics');

        $this->assertInstanceOf('Widop\GoogleAnalytics\Service', $googleAnalytics);
        $this->assertSame('https://foo', $googleAnalytics->getClient()->getUrl());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testClientIdRequired()
    {
        $this->loadConfiguration($this->container, 'client_id');
        $this->container->compile();
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testProfilIdRequired()
    {
        $this->loadConfiguration($this->container, 'profile_id');
        $this->container->compile();
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testPrivateKeyFileRequired()
    {
        $this->loadConfiguration($this->container, 'private_key_file');
        $this->container->compile();
    }

    /**
     * @expectedException Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function testInvalidHttpAdapter()
    {
        $this->loadConfiguration($this->container, 'http_adapter');
        $this->container->compile();
    }
}
