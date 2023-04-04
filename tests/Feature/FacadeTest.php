<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    public function testConfig()
    {
        $name1 = config("contoh.author.name");
        $name2 = Config::get("contoh.author.name");

        self::assertSame($name1, $name2);

        var_dump(Config::all());
    }

    public function testConfigDependency()
    {
        // sebenarnya facade akan meneruskan ke app, dependency container 
        $config = $this->app->make("config");
        $name3 = $config->get("contoh.author.name");
        // helper function
        $name1 = config("contoh.author.name");
        // facade
        $name2 = Config::get("contoh.author.name");

        self::assertSame($name1, $name2);
        self::assertSame($name2, $name3);

        // var_dump(Config::all());
        var_dump($config->all());
    }

    public function testFacadeMock()
    {
        Config::shouldReceive("get")
            ->with("contoh.author.name")
            ->andReturn("Mizz Kun");

        $name = Config::get("contoh.author.name");

        self::assertEquals("Mizz Kun", $name);
    }
}
