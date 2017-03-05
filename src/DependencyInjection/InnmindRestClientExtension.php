<?php
declare(strict_types = 1);

namespace Innmind\Rest\ClientBundle\DependencyInjection;

use Symfony\Component\{
    HttpKernel\DependencyInjection\Extension,
    DependencyInjection\ContainerBuilder,
    DependencyInjection\Loader,
    Config\FileLocator
};

final class InnmindRestClientExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');
        $config = $this->processConfiguration(
            new Configuration,
            $configs
        );

        $this
            ->configureLogLevel($config, $container)
            ->configureCacheDirectory($config, $container)
            ->registerTypes($config['types'], $container)
            ->registerContentTypeFormats($config['content_type'], $container);
    }

    private function configureLogLevel(
        array $config,
        ContainerBuilder $container
    ): self {
        if (isset($config['log_level'])) {
            $container
                ->getDefinition('innmind_rest_client.transport.logger')
                ->replaceArgument(2, $config['log_level']);
        }

        return $this;
    }

    private function configureCacheDirectory(
        array $config,
        ContainerBuilder $container
    ): self {
        if (isset($config['cache_directory'])) {
            $container
                ->getDefinition('innmind_rest_client.filesystem.default')
                ->replaceArgument(0, $config['cache_directory']);
        }

        return $this;
    }

    private function registerTypes(array $types, ContainerBuilder $container): self
    {
        $definition = $container->getDefinition(
            'innmind_rest_client.definition.types'
        );

        foreach ($types as $type) {
            $definition->addMethodCall(
                'register',
                [$type]
            );
        }

        return $this;
    }

    private function registerContentTypeFormats(
        array $formats,
        ContainerBuilder $container
    ): self {
        $container
            ->getDefinition('innmind_rest_client.formats.content_type')
            ->replaceArgument(0, $formats);

        return $this;
    }
}
