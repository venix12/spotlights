<?php

use App\Serializers\ApiSerializer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

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
        // 'Application Form' => 'app-form',
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

function truncate_text(string $text, int $count) : string
{
    return strlen($text) > $count
        ? substr($text, 0, $count) . '…'
        : $text;
}
