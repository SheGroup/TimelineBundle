<?php
declare(strict_types=1);

namespace Damecode\TimelineBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Finder\Finder;

final class DamecodeTimelineExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        foreach ($config as $parameter => $name) {
            $container->setParameter('damecode_timeline.'.$parameter, $name);
        }

        $servicesDirectory = __DIR__.'/../Resources/config/services';
        $finder = new Finder();
        $loader = new YamlFileLoader($container, new FileLocator($servicesDirectory));
        $finder->in($servicesDirectory);
        $files = $finder->name('*.yaml')->files();
        foreach ($files as $file) {
            $loader->load($file->getFilename());
        }
    }
}