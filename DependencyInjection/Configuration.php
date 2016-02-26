<?php

namespace JDecool\Bundle\ImageWorkshopBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('image_workshop');

        $rootNode
            ->children()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('prefix')->defaultValue('media/cache')->end()
                        ->scalarNode('lifetime')->defaultValue(86400)->end()
                    ->end()
                ->end()
                ->arrayNode('formats')
                    ->prototype('array')
                        ->treatNullLike([])
                        ->treatFalseLike([])
                        ->children()
                            ->scalarNode('width')->defaultNull()->end()
                            ->scalarNode('height')->defaultNull()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
