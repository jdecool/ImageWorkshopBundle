<?php

namespace JDecool\Bundle\ImageWorkshopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ImageWorkshopExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('image_workshop.cache_lifetime', $config['cache']['lifetime']);
        $container->setParameter('image_workshop.cache_prefix', $config['cache']['prefix']);

        if ($container->has('image_workshop.manager')) {
            $imageManagerDefinition = $container->getDefinition('image_workshop.manager');
            $imageManagerDefinition->replaceArgument(1, $config['formats']);
        }
    }
}
