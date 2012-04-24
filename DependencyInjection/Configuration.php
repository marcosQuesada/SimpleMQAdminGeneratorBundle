<?php

namespace SimpleMQ\AdminGeneratorBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('simple_mq_admin_generator');

        $rootNode
            ->children()
                ->scalarNode('title')->end()
            ->end()
            ->children()
                ->scalarNode('base_route')->end()
            ->end()                         
            ->children()
                ->arrayNode('actions')
                    ->useAttributeAsKey('id')
                    ->prototype('scalar')                                                       
                ->end()
            ->end()             
            ;
                
        return $treeBuilder;
    }
}
