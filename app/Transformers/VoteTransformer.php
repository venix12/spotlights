<?php

namespace App\Transformers;

use App\SpotlightsNominationVote;
use League\Fractal\TransformerAbstract;

class VoteTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'voter',
    ];

    public function transform(SpotlightsNominationVote $vote)
    {
        return [
            'comment' => $vote->comment,
            'comment_updated_at' => $vote->comment_updated_at !== null ? format_date($vote->comment_updated_at, true) : null,
            'created_at' => format_date($vote->created_at, true),
            'id' => $vote->id,
            'value' => $vote->value,
        ];
    }

    public function includeVoter(SpotlightsNominationVote $vote)
    {
        $nominator = $vote->user;

        return $this->item($nominator, new UserTransformer);
    }
}
