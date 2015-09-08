<?php

namespace blackknight467\SmartyStreetsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('smarty_streets');

        $rootNode
            ->children()
                ->scalarNode('auth_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('your SmartyStreets auth id')
                ->end()
                ->scalarNode('auth_token')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('your SmartyStreets auth token')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
