<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public static function log($action)
    {
        $event = new self;
        $event->action = $action;
        $event->user_id = Auth::id();
        $event->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
