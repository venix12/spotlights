<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GuzzleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'guzzle';
    }
}
