<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'is_admin',
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'osu_id' => $user->osu_user_id,
            'username' => $user->username,
        ];
    }

    public function includeIsAdmin(User $user)
    {
        return $this->primitive($user->isAdmin());
    }
}
