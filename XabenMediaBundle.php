<?php

namespace Xaben\MediaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Xaben\MediaBundle\DependencyInjection\Compiler\ResizerCompilerPass;

class XabenMediaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ResizerCompilerPass());
    }
}
