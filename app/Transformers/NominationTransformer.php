<?php

namespace App\Transformers;

use App\Models\SpotlightsNomination;
use League\Fractal\TransformerAbstract;

class NominationTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'nominator',
        'votes',
    ];

    public function transform(SpotlightsNomination $nomination)
    {
        return [
            'artist' => $nomination->beatmap_artist,
            'beatmap_id' => $nomination->beatmap_id,
            'creator' => $nomination->beatmap_creator,
            'creator_osu_id' => $nomination->beatmap_creator_osu_id,
            'id' => $nomination->id,
            'score' => $nomination->score(),
            'spots_id' => $nomination->spots_id,
            'title' => $nomination->beatmap_title,
        ];
    }

    public function includeVotes(SpotlightsNomination $nomination)
    {
        $nominations = $nomination->votes;

        return $this->collection($nominations, new VoteTransformer);
    }

    public function includeNominator(SpotlightsNomination $nomination)
    {
        $nominator = $nomination->user;

        return $this->item($nominator, new UserTransformer);
    }
}
