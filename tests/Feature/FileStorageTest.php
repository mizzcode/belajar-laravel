<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageTest extends TestCase
{
    public function testStorage()
    {
        // ambil disk local dari filesystem / lihat config -> filesystem untuk configuration nya
        $fileSystem = Storage::disk("local");
        $fileSystem->put("file.txt", "Mizz Kun");

        $content = $fileSystem->get("file.txt");

        self::assertEquals("Mizz Kun", $content);
    }

    public function testStoragePublic()
    {
        // disk public, jika kita buat symbolic link / storage:link maka akan terhubung ke folder public storage nya
        $fileSystem = Storage::disk("public");
        $fileSystem->put("file.txt", "Mizz Kun");

        $content = $fileSystem->get("file.txt");

        self::assertEquals("Mizz Kun", $content);
    }
}
