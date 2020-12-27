<?php

/**
 * int $app_id
 * int $question_id
 * string $answer
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppAnswer extends Model
{
    protected $fillable = [
        'answer',
        'app_id',
        'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(AppQuestion::class, 'question_id');
    }
}
