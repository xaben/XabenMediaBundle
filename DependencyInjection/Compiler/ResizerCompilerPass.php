<?php

namespace Xaben\MediaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ResizerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('xaben_media.manager.thumbnail')) {
            return;
        }

        $definition = $container->findDefinition(
            'xaben_media.manager.thumbnail'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'xaben_media.resizer'
        );
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'addResizer',
                    array(new Reference($id), $attributes["alias"])
                );
            }
        }
    }
}
