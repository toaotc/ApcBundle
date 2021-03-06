<?php

namespace Toa\Bundle\ApcBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ToaApcExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $autoClear = $container->getParameterBag()->resolveValue($config['auto_clear']);

        if (true == $autoClear['user'] || true == $autoClear['opcode']) {
            $cacheDir = $container->getParameterBag()->resolveValue($config['cache_dir']);
            if (!is_dir($cacheDir)) {
                if (false === @mkdir($cacheDir, 0777, true)) {
                    throw new \RuntimeException(sprintf('Could not create cache directory "%s".', $cacheDir));
                }
            }
            $container->setParameter('toa_apc.cache_dir', $cacheDir);
            $container->setParameter('toa_apc.auto_clear.user', $config['auto_clear']['user']);
            $container->setParameter('toa_apc.auto_clear.opcode', $config['auto_clear']['opcode']);

            $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
            $loader->load('listeners.xml');
        }
    }
}
