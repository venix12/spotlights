<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class OsuApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'osu_api';
    }
}
