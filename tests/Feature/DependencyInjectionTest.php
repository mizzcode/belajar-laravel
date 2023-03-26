<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DependencyInjectionTest extends TestCase
{
    public function testDependencyInjection()
    {
        // dependency injection adalah sebuah object membutuhkan object lain
        $foo = new Foo;
        $bar = new Bar($foo);

        self::assertEquals("Foo and Bar", $bar->bar());
    }
}
