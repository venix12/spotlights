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
