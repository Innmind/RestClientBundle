<?php
declare(strict_types = 1);

namespace Innmind\Rest\ClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\{
    Builder\TreeBuilder,
    ConfigurationInterface
};
use Psr\Log\LogLevel;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $root = $treeBuilder->root('innmind_rest_client');

        $root
            ->children()
                ->arrayNode('types')
                    ->defaultValue([])
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('log_level')
                    ->info('Log level to be used to log all request sent')
                    ->validate()
                    ->ifNotInArray([
                        LogLevel::EMERGENCY,
                        LogLevel::ALERT,
                        LogLevel::CRITICAL,
                        LogLevel::ERROR,
                        LogLevel::WARNING,
                        LogLevel::NOTICE,
                        LogLevel::INFO,
                        LogLevel::DEBUG,
                    ])
                        ->thenInvalid('Invalid log level (check Psr\Log\LogLevel)')
                    ->end()
                ->end()
                ->arrayNode('content_type')
                    ->info('The list of formats you accept in the "Content-Type" response header')
                    ->useAttributeAsKey('name')
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->integerNode('priority')->end()
                            ->arrayNode('media_types')
                                ->useAttributeAsKey('name')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
