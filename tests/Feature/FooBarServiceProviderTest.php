<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\Hello;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FooBarServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $foo1 = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertSame($foo1, $foo2);

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($bar1, $bar2);
    }

    public function testPropertySingletons()
    {
        $helloIndo1 =  $this->app->make(Hello::class);
        $helloIndo2 =  $this->app->make(Hello::class);

        self::assertSame($helloIndo1, $helloIndo2);

        self::assertEquals("Hallo Mizz", $helloIndo1->hello("Mizz"));
    }

    public function testEmpty()
    {
        self::assertTrue(true);
    }
}
