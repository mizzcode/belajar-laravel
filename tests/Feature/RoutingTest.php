<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get("/about")
            ->assertStatus(200)
            ->assertSeeText("Mizz Code");
    }

    public function testRedirect()
    {
        $this->get("/pzn")
            ->assertRedirect("/about");
    }

    public function testFallback()
    {
        $this->get("/masbro")
            ->assertSeeText("404");
    }

    // route parameter
    public function testRouteParameter()
    {
        $this->get("/products/5")
            ->assertSeeText('Product 5');
        $this->get("/products/6")
            ->assertSeeText('Product 6');

        $this->get("/products/baju/location/bekasi")
            ->assertSeeText("Name Product baju, Location bekasi");
    }

    public function testRouteParameterRegex()
    {
        $this->get("/category/900")
            ->assertSeeText("Category 900");

        $this->get("/category/mizz")
            ->assertSeeText("404");
    }

    public function testRouteParameterOptional()
    {
        $this->get("/user/mizz")
            ->assertSeeText("User mizz");

        $this->get("/user/")
            ->assertSeeText("User 404");
    }

    public function testRouteConflict()
    {
        $this->get("/conflict/jani")
            ->assertSeeText("Conflict jani");

        $this->get("/conflict/  mizz")
            ->assertSeeText("Conflict Mizz Kun");
    }

    public function testNamedRoute()
    {
        $this->get("/produk/123")
            ->assertSeeText("Link http://localhost/products/123");

        $this->get("/produk-redirect/123")
            ->assertSeeText("products/123");
    }
}
