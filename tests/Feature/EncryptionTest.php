<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\VarDumper\VarDumper;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $encrypt = Crypt::encrypt("Mizz Kun");
        var_dump($encrypt);

        $decrypt = Crypt::decrypt($encrypt);
        self::assertEquals("Mizz Kun", $decrypt);
    }
}
