<?php

namespace Xaben\MediaBundle\DependencyInjection;

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

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
