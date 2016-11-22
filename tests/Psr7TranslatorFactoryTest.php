<?php
declare(strict_types = 1);

namespace Tests\Innmind\Rest\ClientBundle;

use Innmind\Rest\ClientBundle\Psr7TranslatorFactory;
use Innmind\Http\{
    Translator\Response\Psr7Translator,
    Factory\Header\AgeFactory,
    Header\Age,
    Header\Link
};
use Innmind\Immutable\StringPrimitive as Str;
use Psr\Http\Message\ResponseInterface;

class Psr7TranslatorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $factory = (new Psr7TranslatorFactory)->make([
            AgeFactory::class => 'age',
        ]);

        $this->assertInstanceOf(Psr7Translator::class, $factory);
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects($this->once())
            ->method('getHeaders')
            ->willReturn([
                'Age' => ['42'],
                'Link' => ['</foo>; rel="related"'],
            ]);
        $response
            ->method('getProtocolVersion')
            ->willReturn('1.1');
        $response
            ->method('getStatusCode')
            ->willReturn(200);
        $response = $factory->translate($response);

        $this->assertInstanceOf(
            Age::class,
            $response->headers()->get('age')
        );
        $this->assertNotInstanceOf(
            Link::class,
            $response->headers()->get('link')
        );
    }
}
