<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Services\Hello;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', function () {
    return 'Mizz Code';
});
Route::redirect('/pzn', '/about');

// custom 404
// Route::fallback(function () {
//     return "CARI APA MASBRO 404";
// });

Route::get('/hello', function () {
    return view('hello', ['name' => 'Mizz']);
});
Route::get('/hello-world', function () {
    return view('hello.world', ['name' => 'World']);
});

Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
})->name("product.detail");

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Name Product $productId, Location $itemId";
})->name("product.item.detail");

Route::get("/category/{id}", function ($id) {
    return "Category $id";
})->where("id", "[0-9]+")->name("category.detail");

Route::get("/user/{id?}", function ($id = "404") {
    return "User $id";
})->name("user.detail");

// laravel tidak akan throw eror jika terjadi conflict. tetapi hanya memprioritaskan yang pertama di buat route nya
Route::get("/conflict/{name}", function ($name) {
    return "Conflict $name";
});

Route::get("/conflict/mizz", function () {
    return "Conflict Mizz Kun";
});
// url generation
Route::get('/produk/{id}', function ($id) {
    $link = route("product.detail", ["id" => $id]);
    return "Link $link";
});

Route::get("/produk-redirect/{id}", function ($id) {
    return redirect()->route("product.detail", ["id" => $id]);
});

Route::get("controller/hello/{name}", [HelloController::class, "hello"]);

Route::get("/controller/request", [HelloController::class, "request"]);

Route::get("/input/hello", [InputController::class, "hello"]);
Route::post("/input/hello", [InputController::class, "hello"]);

Route::post("/input/hello/first", [InputController::class, "helloFirstName"]);
Route::post("/input/hello/input", [InputController::class, "helloInput"]);
Route::post("/input/hello/array", [InputController::class, "helloArray"]);
