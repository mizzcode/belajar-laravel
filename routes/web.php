<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Services\Hello;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
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

// prefix itu misal kita ada url awalan yang sama. jadi pakai prefix agar tidak menulis url awalan yang sama
// berulang kali. dan juga misal controller nya semua sama yah pakai method controller
// kalo mau tambah middleware juga tinggal panggil method middleware
// kalo udah yakin semua tinggal di group saja

Route::controller(HelloController::class)->prefix("/controller")->group(function () {
    Route::get("/hello/{name}", "hello");
    Route::get("/request", "request");
});

Route::controller(InputController::class)->prefix("/input")->group(function () {
    Route::get("/hello", "hello");
    Route::post("/hello", "hello");
    Route::post("/hello/first", "helloFirstName");
    Route::post("/hello/input", "helloInput");
    Route::post("/hello/array", "helloArray");
    Route::post("/type", "inputType");
    Route::post("/filter/only", "filterOnly");
    Route::post("/filter/except", "filterExcept");
    Route::post("/filter/merge", "filterMerge");
});

Route::post("/file/upload", [FileController::class, "upload"])->withoutMiddleware(VerifyCsrfToken::class);

Route::get("/response/hello", [ResponseController::class, "response"]);
Route::get("/response/header", [ResponseController::class, "header"]);

Route::prefix("/response/type")->controller(ResponseController::class)->group(function () {
    Route::get("/view", "responseView");
    Route::get("/json", "responseJson");
    Route::get("/file", "responseFile");
    Route::get("/download", "responseFileDownload");
});

Route::controller(CookieController::class)->prefix("/cookie")->group(function () {
    Route::get("/set", "createCookie");
    Route::get("/get", "getCookie");
    Route::get("/clear", "clearCookie");
});

Route::controller(RedirectController::class)->prefix("/redirect")->group(function () {
    Route::get("/from", "redirectFrom");
    Route::get("/to", "redirectTo");

    Route::get("/name", "redirectName");
    Route::get("/name/{name}", "redirectHello")->name("redirect-hello");
    Route::get("/action", "redirectAction");
    Route::get("/away", "redirectAway");
});
// url generation
Route::get("/redirect/named", function () {
    return URL::route("redirect-hello", [
        "name" => "Mizz"
    ]);
});

Route::middleware("sample:MIZZ, 401")->prefix("/middleware")->group(function () {
    Route::get("/api", function () {
        return "OK";
    });

    Route::get("/group", function () {
        return "GROUP";
    });
});

Route::controller(FormController::class)->group(function () {
    Route::get("/form", "form");
    Route::post("/form", "submitForm");
});
// url generation
Route::get("/url/action", function () {
    return action([FormController::class, "form"]);
});

// URL Generation
Route::get("/url/current", function () {
    // get current url tanpa query param
    // return URL::current();

    // get current url full dengan query param nya
    return URL::full();
});

Route::get("/session/create", [SessionController::class, "createSession"]);
Route::get("/session/get", [SessionController::class, "getSession"]);

Route::get("/error/sample", function () {
    throw new Exception("Sample Error");
});
// error handler agar tidak memunculkan pesan error nya tapi reportable tetap di eksekusi
Route::get("/error/sample/manual", function () {
    report(new Exception("Sample Error"));
    return "OK";
});
Route::get("/error/sample/validation", function () {
    throw new ValidationException("Validation Error");
});

Route::get("/abort/400", function () {
    abort(400);
});
Route::get("/abort/401", function () {
    abort(401);
});
Route::get("/abort/500", function () {
    abort(500);
});
