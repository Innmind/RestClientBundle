<?php
declare(strict_types = 1);

namespace Tests\Innmind\Rest\ClientBundle;

use Innmind\Rest\ClientBundle\TypesConfigurator;
use Innmind\Rest\Client\Definition\{
    Types,
    Type
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
            Type::class,
            $types->build('string')
        );
        $this->assertInstanceOf(
            Type::class,
            $types->build('float')
        );
        $this->assertInstanceOf(
            Type::class,
            $types->build('int')
        );
        $this->assertInstanceOf(
            Type::class,
            $types->build('bool')
        );
        $this->assertInstanceOf(
            Type::class,
            $types->build('date<c>')
        );
        $this->assertInstanceOf(
            Type::class,
            $types->build('set<string>')
        );
        $this->assertInstanceOf(
            Type::class,
            $types->build('map<int, int>')
        );
    }
}
