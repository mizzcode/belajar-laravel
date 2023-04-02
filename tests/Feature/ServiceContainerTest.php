<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\Hello;
use App\Services\HelloIndo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        $foo1 = $this->app->make(Foo::class); // new Foo()
        $foo2 = $this->app->make(Foo::class); // new Foo()

        self::assertEquals("Foo", $foo1->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
        $this->app->bind(Person::class, function ($app) {
            return new Person("Mizz", "Kun");
        });

        $person1 = $this->app->make(Person::class); // call closure() // new Person("Mizz", "Kun"); 
        $person2 = $this->app->make(Person::class); // call closure() // new Person("Mizz", "Kun");

        // self::assertNotNull($person1);
        self::assertEquals("Mizz", $person1->firstName);
        self::assertEquals("Mizz", $person2->firstName);

        self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function () {
            return new Person("Mizz", "Kun");
        });

        $person1 = $this->app->make(Person::class); // new Person("Mizz", "Kun"); / if not exists 
        $person2 = $this->app->make(Person::class); // return existing

        self::assertEquals("Mizz", $person1->firstName);
        self::assertEquals("Mizz", $person2->firstName);

        self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person("Mizz", "Kun");
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // $person 
        $person2 = $this->app->make(Person::class); // $person

        self::assertEquals("Mizz", $person1->firstName);
        self::assertEquals("Mizz", $person2->firstName);

        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function () {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);

        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        // jika tidak kompleks. kalau kompleks menggunakan closure
        $this->app->singleton(Hello::class, HelloIndo::class);

        $halloIndo = $this->app->make(Hello::class);

        self::assertEquals("Hallo Mizz", $halloIndo->hello("Mizz"));
    }
}
