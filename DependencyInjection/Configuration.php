<?php

namespace Zenstruck\Bundle\MobileBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('zenstruck_mobile');

        $rootNode
            ->children()
                ->booleanNode('mobile')->defaultFalse()->end()
                ->booleanNode('use_listener')->defaultTrue()->end()
                ->booleanNode('use_helper')->defaultTrue()->end()
                ->scalarNode('full_host')->isRequired()->end()
                ->scalarNode('mobile_host')->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
