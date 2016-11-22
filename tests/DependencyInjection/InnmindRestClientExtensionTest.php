<?php
declare(strict_types = 1);

namespace Tests\Innmind\Rest\ClientBundle\DependencyInjection;

use Innmind\Rest\ClientBundle\DependencyInjection\InnmindRestClientExtension;
use Innmind\Rest\Client\Definition\TypeInterface;
use Symfony\Component\{
    HttpKernel\DependencyInjection\Extension,
    DependencyInjection\ContainerBuilder,
    DependencyInjection\Definition,
    Serializer\Serializer
};
use Psr\Log\NullLogger;

class InnmindRestClientExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Extension::class,
            new InnmindRestClientExtension
        );
    }

    public function testLoad()
    {
        $type = get_class($this->createMock(TypeInterface::class));
        $container = new ContainerBuilder;
        (new InnmindRestClientExtension)->load(
            [[
                'types' => [$type],
                'content_type' => $contentType = [
                    'json' => [
                        'priority' => 42,
                        'media_types' => [
                            'application/json' => 0,
                        ],
                    ],
                ],
            ]],
            $container
        );

        $this->assertSame(
            [['register', [$type]]],
            $container
                ->getDefinition('innmind_rest_client.definition.types')
                ->getMethodCalls()
        );
        $this->assertSame(
            $contentType,
            $container
                ->getDefinition('innmind_rest_client.formats.content_type')
                ->getArgument(0)
        );
    }

    public function testOverwriteLogLevel()
    {
        $container = new ContainerBuilder;
        (new InnmindRestClientExtension)->load(
            [[
                'log_level' => 'emergency',
                'content_type' => [
                    'json' => [
                        'priority' => 42,
                        'media_types' => [
                            'application/json' => 0,
                        ],
                    ],
                ],
            ]],
            $container
        );

        $this->assertSame(
            'emergency',
            $container
                ->getDefinition('innmind_rest_client.transport.logger')
                ->getArgument(2)
        );
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid configuration for path "innmind_rest_client.log_level": Invalid log level (check Psr\Log\LogLevel)
     */
    public function testThrowWhenInvalidLogLevel()
    {
        $container = new ContainerBuilder;
        (new InnmindRestClientExtension)->load(
            [[
                'log_level' => 'whatever',
                'content_type' => [
                    'json' => [
                        'priority' => 42,
                        'media_types' => [
                            'application/json' => 0,
                        ],
                    ],
                ],
            ]],
            $container
        );
    }

    public function testOverwriteCacheDirectory()
    {
        $container = new ContainerBuilder;
        (new InnmindRestClientExtension)->load(
            [[
                'cache_directory' => '/somewhere',
                'content_type' => [
                    'json' => [
                        'priority' => 42,
                        'media_types' => [
                            'application/json' => 0,
                        ],
                    ],
                ],
            ]],
            $container
        );

        $this->assertSame(
            '/somewhere',
            $container
                ->getDefinition('innmind_rest_client.filesystem')
                ->getArgument(0)
        );
    }

    public function testCompile()
    {
        $container = new ContainerBuilder;
        $container->setDefinition('logger', new Definition(NullLogger::class));
        $container->setDefinition('serializer', new Definition(Serializer::class));
        (new InnmindRestClientExtension)->load(
            [],
            $container
        );

        $container->compile();
        $this->assertTrue(true);
    }
}
