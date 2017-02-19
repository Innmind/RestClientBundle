<?php
declare(strict_types = 1);

namespace Tests\Innmind\Rest\ClientBundle;

use Innmind\Rest\ClientBundle\InnmindRestClientBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use PHPUnit\Framework\TestCase;

class InnmindRestServerBundleTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Bundle::class,
            new InnmindRestClientBundle
        );
    }
}
