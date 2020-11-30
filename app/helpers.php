<?php

use App\Serializers\ApiSerializer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

function closest_range_value(int $search, array $array)
{
    $match = null;

    foreach ($array as $key => $value) {
        if ($search <= $value) {
            $match = $key;

            break;
        }
    }

    return $match;
}

function default_divisions()
{
    $defaults = [
        [
            'absolute' => true,
            'name' => 'ri-3',
            'threshold' => 3,
        ],
        [
            'absolute' => true,
            'name' => 'ri-2',
            'threshold' => 10,
        ],
        [
            'absolute' => false,
            'name' => 'diamond-3',
            'threshold' => 0.019,
        ],
        [
            'absolute' => false,
            'name' => 'diamond-2',
            'threshold' => 0.029,
        ],
        [
            'absolute' => false,
            'name' => 'platinum-3',
            'threshold' => 0.064,
        ],
        [
            'absolute' => false,
            'name' => 'platinum-2',
            'threshold' => 0.099,
        ],
        [
            'absolute' => false,
            'name' => 'gold-3',
            'threshold' => 0.174,
        ],
        [
            'absolute' => false,
            'name' => 'gold-2',
            'threshold' => 0.249,
        ],
        [
            'absolute' => false,
            'name' => 'silver-3',
            'threshold' => 0.374,
        ],
        [
            'absolute' => false,
            'name' => 'silver-2',
            'threshold' => 0.499,
        ],
        [
            'absolute' => false,
            'name' => 'bronze-3',
            'threshold' => 0.59,
        ],
        [
            'absolute' => false,
            'name' => 'bronze-2',
            'threshold' => 0.699,
        ],
        [
            'absolute' => false,
            'name' => 'copper-3',
            'threshold' => 0.824,
        ],
        [
            'absolute' => false,
            'name' => 'copper-2',
            'threshold' => 0.949,
        ],
        [
            'absolute' => false,
            'name' => 'iron-3',
            'threshold' => 0.974,
        ],
        [
            'absolute' => false,
            'name' => 'iron-2',
            'threshold' => 1,
        ],
    ];

    return $defaults;
}

function format_date(string $date, bool $hour = false) : string
{
    $formatted = substr($date, 0, $hour ? -3 : -9);

    return $formatted;
}

function fractal_item($entry, string $transformer, array $includes = null) : array
{
    return fractal_transform($entry, $transformer, $includes, true);
}

function fractal_transform($entries, string $transformer, array $includes = null, bool $item = false) : array
{
    $fractal = new Manager;
    $fractal->setSerializer(new ApiSerializer);

    if ($includes) {
        $fractal->parseIncludes($includes);
    }

    $transformer = 'App\\Transformers\\' . $transformer;
    $transformer = new $transformer;

    if ($item) {
        $collection = new Item($entries, $transformer);
    } else {
        $collection = new Collection($entries, $transformer);
    }

    return $fractal->createData($collection)->toArray();
}

function gamemode(string $abbreviation) : string
{
    $abbreviation === 'osu'
        ? $name = 'osu!'
        : $name = "osu!{$abbreviation}";

    return $name;
}

function json_error(string $error)
{
    return json_encode(['error', $error]);
}

function navbar_permission_check(array $route) : bool
{
    $permission = $route['permission'];

    return auth()->user()->$permission();
}

function navbar_sections() : array
{
    $sections = [
        'Home' => 'home',
        'Apply now!' => 'app-form',
        'Spotlights' => ['route' => 'spotlights', 'permission' => 'isMember'],
        'Spotlights Results' => 'spotlights-results',
        'User List' => 'user.list',
    ];

    return $sections;
}

function navbar_welcome_sections() : array
{
    $sections = [
        'Home' => 'home',
        'Spotlights Results' => 'spotlights-results',
    ];

    return $sections;
}

function section_url(string $route) : ?string
{
    $routeMappings = [
        'Application Evaluation' => 'admin.app-eval',
        'Home' => 'home',
        'Manage' => 'admin.manage',
        'Manage leaderboards' => 'admin.seasons',
        'Manage usergroups' => 'admin.user-groups',
        'Spotlights' => 'spotlights',
        'spotlights results' => 'spotlights-results',
        'Users' => 'user.list'
    ];

    if (array_key_exists($route, $routeMappings)) {
        return route($routeMappings[$route]);
    }

    return null;
}

function truncate_text(string $text, int $count) : string
{
    return strlen($text) > $count
        ? substr($text, 0, $count) . '…'
        : $text;
}
