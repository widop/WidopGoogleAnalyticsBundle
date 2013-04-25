<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GoogleAnalyticsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Wid'op google analytics bundle extension.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class WidopGoogleAnalyticsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('widop_google_analytics.client_id', $config['client_id']);
        $container->setParameter('widop_google_analytics.profile_id', $config['profile_id']);
        $container->setParameter('widop_google_analytics.private_key_file', $config['private_key_file']);

        $container
            ->getDefinition('widop_google_analytics.client')
            ->addArgument(new Reference($config['http_adapter']));
    }
}
