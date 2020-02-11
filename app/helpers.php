<?php

use App\Serializers\ApiSerializer;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

function format_date(string $date, bool $hour = false) : string
{
    $formatted = substr($date, 0, $hour ? -3 : -9);

    return $formatted;
}

function fractal_transform(EloquentCollection $entries, string $transformer) : array
{
    $fractal = new Manager;
    $fractal->setSerializer(new ApiSerializer);

    $transformer = 'App\\Transformers\\' . $transformer;
    $transformer = new $transformer;

    $collection = new Collection($entries, $transformer);

    return $fractal->createData($collection)->toArray();
}
