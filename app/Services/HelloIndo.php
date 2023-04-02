<?php

namespace App\Services;

class HelloIndo implements Hello
{
    function hello(string $name): string
    {
        return "Hallo $name";
    }
}
