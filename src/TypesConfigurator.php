<?php
declare(strict_types = 1);

namespace Innmind\Rest\ClientBundle;

use Innmind\Rest\Client\Definition\Types;

final class TypesConfigurator
{
    public function configure(Types $types)
    {
        Types::defaults()->foreach(function(string $class) use ($types) {
            $types->register($class);
        });
    }
}
