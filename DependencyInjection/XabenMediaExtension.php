<?php

namespace Xaben\MediaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class XabenMediaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('admin.xml');
        $loader->load('services.xml');
        $loader->load('filesystem.xml');
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function configureServices(ContainerBuilder $container, $config)
    {
        $this->configureFilesystem($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param $config
     */
    private function configureFilesystem(ContainerBuilder $container, $config)
    {
        if ($config['filesystem_type'] == 'flysystem') {
            $filesystemDefinition = $container->getDefinition($config['filesystem_service']);
            $adapter = $container
                ->getDefinition($config['xaben.filesystem.adapter.flysystem'])
                ->replaceArgument(1, $filesystemDefinition);
        } elseif ($config['filesystem_type'] == 'gaufrette') {
            $filesystemDefinition = $container->getDefinition($config['filesystem_service']);
            $adapter = $container
                ->getDefinition($config['xaben.filesystem.adapter.gaufrette'])
                ->replaceArgument(1, $filesystemDefinition);
        } else {
            $adapter = $container->getDefinition($config['xaben.filesystem.adapter.default']);
        }

        $container->getDefinition('xaben.manager.image')
            ->replaceArgument(1, $adapter);
    }
}
