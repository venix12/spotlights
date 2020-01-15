<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class GuzzleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('guzzle', function () {
            return new Client();
        });
    }
}
