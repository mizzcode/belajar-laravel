<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Http\Request;

class InputController extends Controller
{
    public function hello(Request $request): string
    {
        $name = $request->input("name");
        return "Hello $name";
    }

    public function helloFirstName(Request $request): string
    {
        $firstName = $request->input("name.first");
        $lastName = $request->input("name.last");
        return "Hello $firstName $lastName";
    }

    public function helloInput(Request $request): string
    {
        $input = $request->input();
        return json_encode($input);
    }

    public function helloArray(Request $request)
    {
        $input = $request->input("product.*.name");
        return json_encode($input);
    }
}
