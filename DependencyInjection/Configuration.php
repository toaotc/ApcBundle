<?php

namespace Toa\Bundle\ApcBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('toa_apc');

        $rootNode
            ->children()
                ->scalarNode('cache_dir')->cannotBeOverwritten(false)->defaultValue('%kernel.cache_dir%/toa_apc')->end()
                ->arrayNode('auto_clear')
                    ->treatFalseLike(array('user' => false, 'opcode' => false))
                    ->treatTrueLike(array('user' => true, 'opcode' => true))
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('user')->treatNullLike(false)->defaultFalse()->end()
                        ->booleanNode('opcode')->treatNullLike(false)->defaultFalse()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
