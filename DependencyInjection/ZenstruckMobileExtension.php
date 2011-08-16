<?php

namespace Zenstruck\Bundle\MobileBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ZenstruckMobileExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('manager.xml');

        if ($config['use_helper']) {
            $loader->load('helper.xml');
        }

        if ($config['use_listener']) {
            $loader->load('listener.xml');
        }

        if ($config['use_twig_engine']) {
            $loader->load('twig.xml');
        }

        $container->getDefinition('zenstruck_mobile.manager')
                ->replaceArgument(0, $config['mobile_host'])
                ->replaceArgument(1, $config['full_host'])
                ->replaceArgument(2, $config['mobile']);
    }
}
