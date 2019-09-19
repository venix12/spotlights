<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    const GROUPS = [
        0 => 'Member',
        1 => 'Administrator',
        2 => 'Project Leader',
        3 => 'Manager',
    ];

    const GROUP_COLOURS = [
        0 => '',
        1 => '#6eed1f',
        2 => '',
        3 => '',
    ];
}
