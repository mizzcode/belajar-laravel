<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SampleMiddlewareTest extends TestCase
{
    public function testValid()
    {
        $this->withHeader("X-API-KEY", "MIZZ")
            ->get("/middleware/api")
            ->assertStatus(200)
            ->assertSeeText("OK");
    }

    public function testInvalid()
    {
        $this->get("/middleware/api")
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }

    public function testValidGroup()
    {
        $this->withHeader("X-API-KEY", "MIZZ")
            ->get("/middleware/group")
            ->assertStatus(200)
            ->assertSeeText("GROUP");
    }

    public function testInvalidGroup()
    {
        $this->get("/middleware/group")
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }
}
