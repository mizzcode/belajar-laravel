<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('hello')
            ->assertStatus(200)
            ->assertSeeText('Hello Mizz');
    }

    public function testNestedView()
    {
        $this->get('hello-world')
            ->assertStatus(200)
            ->assertSeeText('Hello World');
    }

    public function testBladeTanpaRouting()
    {
        $this->view('hello', ['name' => 'Mizz'])
            ->assertSeeText('Hello Mizz');

        $this->view('hello.world', ['name' => 'World'])
            ->assertSeeText('Hello World');
    }
}
