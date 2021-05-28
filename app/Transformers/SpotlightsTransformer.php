<?php

namespace App\Transformers;

use App\Models\Spotlights;
use League\Fractal\TransformerAbstract;

class SpotlightsTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'nominations',
    ];

    public function transform(Spotlights $spotlights)
    {
        return [
            'id' => $spotlights->id,
            'is_legacy' => $spotlights->isLegacy(),
            'threshold' => $spotlights->threshold,
        ];
    }

    public function includeNominations(Spotlights $spotlights)
    {
        $nominations = $spotlights->nominations;

        return $this->collection($nominations, new NominationTransformer);
    }
}
