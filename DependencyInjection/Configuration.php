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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Wid'op google analytics bundle configuration.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('widop_google_analytics');

        $rootNode
            ->children()
                ->scalarNode('client_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('profile_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('private_key_file')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('http_adapter')
                    ->defaultValue('widop_http_adapter.curl')
                ->end()
                ->scalarNode('service_url')
                    ->defaultValue('https://accounts.google.com/o/oauth2/token')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
