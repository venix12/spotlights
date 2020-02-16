<?php

namespace App\Transformers;

use App\AppAnswer;
use League\Fractal\TransformerAbstract;

class AppAnswerTransformer extends TransformerAbstract
{
    public function transform(AppAnswer $answer)
    {
        return [
            'answer' => $answer->answer,
            'question' => $answer->question->question,
        ];
    }
}
