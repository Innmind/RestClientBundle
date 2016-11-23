<?php
declare(strict_types = 1);

namespace Innmind\Rest\ClientBundle;

use Innmind\Http\{
    Translator\Response\Psr7Translator,
    Factory\HeaderFactoryInterface,
    Factory\Header\DefaultFactory
};
use Innmind\Immutable\Map;

final class Psr7TranslatorFactory
{
    public function make(array $classes): Psr7Translator
    {
        $factories = new Map('string', HeaderFactoryInterface::class);

        foreach ($classes as $class => $header) {
            $factories = $factories->put(
                $header,
                new $class
            );
        }

        return new Psr7Translator(
            new DefaultFactory($factories)
        );
    }
}
