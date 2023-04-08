<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request): string
    {
        $file = $request->file("picture");

        $file->storePubliclyAs("pictures", $file->getClientOriginalName(), "public");

        return "OK : " . $file->getClientOriginalName();
    }
}
