<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    public function testConfig()
    {
        $name = config("contoh.author.name");

        self::assertEquals("Misbahudin", $name);
    }
}
