<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloControllerTest extends TestCase
{
    public function testHelloController()
    {
        $this->get("/controller/hello/mizz")
            ->assertSeeText("Hallo mizz");
    }

    public function testRequest()
    {
        $this->get("/controller/request", ["accept" => "plain/text"])
            ->assertStatus(200)
            ->assertSeeText("GET")
            ->assertSeeText("http://localhost/controller/request")
            ->assertSeeText("plain/text");
    }
}
