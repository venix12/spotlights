<?php

namespace App\Events;

use App\Models\Application;

class ApplicationSubmitted
{
    /**
     * Create a new event instance.
     *
     * @param  Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
