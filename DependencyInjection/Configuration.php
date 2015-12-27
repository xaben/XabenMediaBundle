<?php

namespace Xaben\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('xaben_media');

        $this->addFilesystemSection($node);
        $this->addContextsSection($node);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addFilesystemSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('filesystem_type')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray(array('default', 'gaufrette', 'flysystem'))
                        ->thenInvalid('Invalid filesystem adapter "%s"')
                    ->end()
                ->end()
                ->scalarNode('filesystem_service')->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addContextsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('contexts')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('formats')
                                ->isRequired()
                                ->useAttributeAsKey('id')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('width')->defaultValue(false)->end()
                                        ->scalarNode('height')->defaultValue(false)->end()
                                        ->scalarNode('upscale')->defaultValue(false)->end()
                                        ->scalarNode('resizer')->defaultValue('inset')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
