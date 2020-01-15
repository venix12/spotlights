<?php

namespace App\Providers;

use App\Libraries\OsuApi;
use Illuminate\Support\ServiceProvider;

class OsuApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('osu_api', function () {
            return new OsuApi(env('OSU_API_KEY'));
        });
    }
}
