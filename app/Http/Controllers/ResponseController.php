<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response
    {
        return response("Hello Response");
    }

    public function header(Request $request): Response
    {
        $body = ["firstName" => "Mizz", "lastName" => "Kun"];

        return response(json_encode($body), 200)
            ->header("Content-Type", "application/json")
            ->withHeaders([
                "Author" => "Mizz",
                "Version" => "1.0.0",
                "App" => "Belajar Laravel"
            ]);
    }

    public function responseView(Request $request): Response
    {
        return response()
            ->view("hello", [
                "name" => "Mizz"
            ]);
    }

    public function responseJson(Request $request): JsonResponse
    {
        return response()
            ->json([
                "firstName" => "Mizz",
                "lastName" => "Kun"
            ]);
    }

    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()
            ->file(storage_path("app/public/pictures/pemrograman.jpeg"));
    }

    public function responseFileDownload(Request $request): BinaryFileResponse
    {
        return response()
            ->download(storage_path("app/public/pictures/pemrograman.jpeg"));
    }
}
