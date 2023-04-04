<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get("/input/hello?name=Mizz")
            ->assertSeeText("Hello Mizz");

        $this->post("/input/hello", [
            "name" => "Mizz"
        ])
            ->assertSeeText("Hello Mizz");
    }

    public function testInputNested()
    {
        $this->post("/input/hello/first", [
            "name" => [
                "first" => "Mizz",
                "last" => "Kun",
            ]
        ])
            ->assertSeeText("Hello Mizz");
    }

    public function testInputAll()
    {
        $this->post("/input/hello/input", [
            "name" => [
                "first" => "Mizz",
                "last" => "Kun",
            ]
        ])->assertSeeText("name")
            ->assertSeeText("first")
            ->assertSeeText("last")
            ->assertSeeText("Mizz")
            ->assertSeeText("Kun");
    }

    public function testInputArray()
    {
        $this->post("/input/hello/array", [
            "product" => [
                [
                    "name" => "Jam",
                    "price" => 15000
                ],
                [
                    "name" => "Thinkpad",
                    "price" => 4500000
                ]
            ]
        ])->assertSeeText("Jam")
            ->assertSeeText("Thinkpad");
    }
}
