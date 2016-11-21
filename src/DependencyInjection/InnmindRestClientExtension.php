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
            ->registerTypes($config['types'], $container)
            ->registerContentTypeFormats($config['content_type'], $container);
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
