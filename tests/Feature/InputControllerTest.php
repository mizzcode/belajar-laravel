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

    public function testInputType()
    {
        $this->post("/input/type", [
            "name" => "Mizz",
            "married" => true,
            "birth_date" => "2023-12-03"
        ])->assertSeeText("Mizz")->assertSeeText(true)->assertSeeText("2023-12-03");
    }

    // input yang lebih spesifik // filter untuk mengambil beberapa key/input aja 
    public function testFilterOnly()
    {
        $this->post("/input/filter/only", [
            "name" => [
                "first" => "Mizz",
                "middle" => "Udin",
                "last" => "Kun"
            ]
        ])->assertSeeText("Mizz")->assertSeeText("Kun")->assertDontSeeText("Udin");
    }

    // input yang kecuali // lihat controller
    public function testFilterExcept()
    {
        $this->post("/input/filter/except", [
            "username" => "Mizz",
            "admin" => "true",
            "password" => "rahasia"
        ])->assertSeeText("Mizz")->assertSeeText("rahasia")->assertDontSeeText("admin");
    }

    public function testFilterMerge()
    {
        $this->post("/input/filter/merge", [
            "username" => "Mizz",
            "password" => "rahasia",
            "admin" => "true",
        ])->assertSeeText("Mizz")->assertSeeText("rahasia")->assertSeeText("admin")->assertSeeText("false");
    }
}
