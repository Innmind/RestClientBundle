<?php
declare(strict_types = 1);

namespace Tests\Innmind\Rest\ClientBundle;

use Innmind\Rest\ClientBundle\TypesConfigurator;
use Innmind\Rest\Client\Definition\{
    Types,
    TypeInterface
};
use PHPUnit\Framework\TestCase;

class TypesConfiguratorTest extends TestCase
{
    public function testConfigure()
    {
        $types = new Types;
        $this->assertNull(
            (new TypesConfigurator)->configure($types)
        );
        $this->assertInstanceOf(
            TypeInterface::class,
            $types->build('string')
        );
        $this->assertInstanceOf(
            TypeInterface::class,
            $types->build('float')
        );
        $this->assertInstanceOf(
            TypeInterface::class,
            $types->build('int')
        );
        $this->assertInstanceOf(
            TypeInterface::class,
            $types->build('bool')
        );
        $this->assertInstanceOf(
            TypeInterface::class,
            $types->build('date<c>')
        );
        $this->assertInstanceOf(
            TypeInterface::class,
            $types->build('set<string>')
        );
        $this->assertInstanceOf(
            TypeInterface::class,
            $types->build('map<int, int>')
        );
    }
}
