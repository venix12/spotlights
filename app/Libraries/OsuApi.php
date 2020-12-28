<?php

namespace App\Libraries;

use Guzzle;

class OsuApi
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getBeatmap(int $id)
    {
        return $this->request('get_beatmaps', ['b' => $id]);
    }

    public function getBeatmapset(int $id)
    {
        return $this->request('get_beatmaps', ['s' => $id]);
    }

    public function getUser(int $id)
    {
        return $this->request('get_user', ['u' => $id]);
    }

    public function request(string $target, array $query)
    {
        $query['k'] = $this->apiKey;

        $response = Guzzle::get("osu.ppy.sh/api/{$target}", ['query' => $query]);

        return json_decode($response->getBody(), true);
    }

}
