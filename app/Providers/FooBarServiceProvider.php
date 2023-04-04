<?php

namespace App\Providers;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\Hello;
use App\Services\HelloIndo;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FooBarServiceProvider extends ServiceProvider implements DeferrableProvider
{
    // property singletons untuk binding interface misalnya, bisa seperti ini jika sederhana
    public array $singletons = [
        Hello::class => HelloIndo::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // echo "FooBar Service Provider" . PHP_EOL;
        $this->app->singleton(Foo::class, function () {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    // lazy atau dipanggil jika memang di gunakan, kalau tidak, jangan di pakai
    public function provides()
    {
        return [Hello::class, Foo::class, Bar::class];
    }
}
