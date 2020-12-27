<?php

namespace App\Transformers;

use App\Models\Application;
use League\Fractal\TransformerAbstract;

class ApplicationTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'answers',
        'feedback_author',
        'user',
    ];

    public function transform(Application $app)
    {
        return [
            'approved' => $app->approved,
            'created_at' => format_date($app->created_at),
            'feedback' => $app->feedback,
            'id' => $app->id,
            'gamemode' => gamemode($app->gamemode),
            'verdict' => $app->verdict,
        ];
    }

    public function includeAnswers(Application $app)
    {
        $answers = $app->answers;

        return $this->collection($answers, new AppAnswerTransformer);
    }

    public function includeFeedbackAuthor(Application $app)
    {
        $author = $app->feedbackAuthor;

        if ($author !== null) {
            return $this->item($author, new UserTransformer);
        }

        return;
    }

    public function includeUser(Application $app)
    {
        $user = $app->user;

        return $this->item($user, new UserTransformer);
    }
}
