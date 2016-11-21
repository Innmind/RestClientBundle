<?php
declare(strict_types = 1);

namespace Tests\Innmind\Rest\ClientBundle\DependencyInjection;

use Innmind\Rest\ClientBundle\DependencyInjection\InnmindRestClientExtension;
use Innmind\Rest\Client\Definition\TypeInterface;
use Symfony\Component\{
    HttpKernel\DependencyInjection\Extension,
    DependencyInjection\ContainerBuilder
};

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
}
