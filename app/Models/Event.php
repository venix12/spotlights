<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public static function log($action, $user_id = null)
    {
        $event = new self;
        $event->action = $action;
        $event->user_id = $user_id ?? auth()->id();
        $event->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
