<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    const GROUPS = [
        0 => 'Member',
        1 => 'Administrator',
        2 => 'Leader',
        3 => 'Manager',
    ];

    const GROUP_COLOURS = [
        0 => '#000000',
        1 => '#6eed1f',
    ];
}
