<?php

namespace App\Http\Controllers;

use App\Services\Hello;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    private Hello $helloIndo;

    public function __construct(Hello $hello)
    {
        $this->helloIndo = $hello;
    }

    public function hello(Request $request, string $name): string
    {
        // $request->method();
        // $request->fullUrl();
        return $this->helloIndo->hello($name);
    }

    public function request(Request $request)
    {
        return $request->path() . $request->url() . $request->method() . $request->header("accept");
    }
}
