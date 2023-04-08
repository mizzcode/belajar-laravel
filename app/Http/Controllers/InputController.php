<?php

namespace App\Http\Controllers;

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

    public function helloArray(Request $request): string
    {
        $input = $request->input("product.*.name");
        return json_encode($input);
    }

    public function inputType(Request $request): string
    {
        $name = $request->input("name");
        $isMarried = $request->boolean("married");
        $birth_date = $request->date("birth_date", "Y-m-d");

        return json_encode([
            "name" => $name,
            "married" => $isMarried,
            "birth_date" => $birth_date
        ]);
    }
    // ambil input atau key tertentu
    public function filterOnly(Request $request): string
    {
        $name = $request->only("name.first", "name.last");
        return json_encode($name);
    }

    // except untuk kecuali // jadi kita gak mau ambil key admin
    public function filterExcept(Request $request): string
    {
        $user = $request->except("admin");
        return json_encode($user);
    }

    public function filterMerge(Request $request): string
    {
        $request->merge(["admin" => false]);
        $user = $request->input();
        return json_encode($user);
    }
}
