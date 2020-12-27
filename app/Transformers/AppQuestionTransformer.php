<?php

namespace App\Transformers;

use App\Models\AppQuestion;
use League\Fractal\TransformerAbstract;

class AppQuestionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'children',
    ];

    public function transform(AppQuestion $question)
    {
        return [
            'char_limit' => $question->char_limit,
            'description' => $question->description,
            'id' => $question->id,
            'order' => $question->order,
            'question' => $question->question,
            'required' => $question->required,
            'relation' => AppQuestion::RELATION_TYPES[$question->relation_type],
            'type' => $question->type,
        ];
    }

    public function includeChildren(AppQuestion $question)
    {
        $children = $question->children;

        if ($children->count() > 0) {
            return $this->collection($children, new static);
        }

        return;
    }
}
