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

        $this->configureFilesystem($container, $config);
        $this->configureThumbnailer($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param $config
     */
    private function configureFilesystem(ContainerBuilder $container, $config)
    {
        if ($config['filesystem_type'] == 'flysystem') {
            $filesystemDefinition = new Reference($config['filesystem_service']);
            $adapter = $container
                ->getDefinition('xaben_media.filesystem.adapter.flysystem')
                ->replaceArgument(0, $filesystemDefinition);
        } elseif ($config['filesystem_type'] == 'gaufrette') {
            $filesystemDefinition = new Reference($config['filesystem_service']);
            $adapter = $container
                ->getDefinition('xaben_media.filesystem.adapter.gaufrette')
                ->replaceArgument(0, $filesystemDefinition);
        } else {
            $adapter = $container->getDefinition('xaben_media.filesystem.adapter.default');
        }

        $container->getDefinition('xaben_media.manager.image')
            ->replaceArgument(0, $adapter);

        $container->getDefinition('xaben_media.manager.thumbnail')
            ->replaceArgument(2, $adapter);
    }

    private function configureThumbnailer(ContainerBuilder $container, $config)
    {
        $container->getDefinition('xaben_media.manager.thumbnail')
            ->replaceArgument(0, $config['contexts']);
    }
}
