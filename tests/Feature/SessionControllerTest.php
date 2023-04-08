<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testSession()
    {

        $this->get("/session/create")
            ->assertSessionHas("UserId", "Mizz")
            ->assertSessionHas("IsMember", "true");
    }

    public function testGetSession()
    {

        $this->withSession([
            "UserId" => "Mizz",
            "IsMember" => "true",
        ])->get("/session/get")
            ->assertSeeText("Mizz")
            ->assertSeeText("true")
            ->assertSeeText("User Id : Mizz, Is Member : true");
    }

    public function testGetSessionFailed()
    {

        $this->get("/session/get")
            ->assertSeeText("guest")
            ->assertSeeText("false")
            ->assertSeeText("User Id : guest, Is Member : false");
    }
}
