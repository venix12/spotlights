<?php

namespace App\Transformers;

use App\AppAnswer;
use League\Fractal\TransformerAbstract;

class AppAnswerTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'question'
    ];

    public function transform(AppAnswer $answer)
    {
        return [
            'answer' => $answer->answer,
        ];
    }

    public function includeQuestion(AppAnswer $answer)
    {
        $question = $answer->question;

        return $this->item($question, new AppQuestionTransformer);
    }
}
