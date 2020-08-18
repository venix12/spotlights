<?php

namespace App\Libraries;

use Guzzle;
use Illuminate\Support\Str;

class OsuOauth
{
    public function apiRequest(string $url)
    {
        $token = request()->session()->get('token');

        $apiRequest = Guzzle::request('GET', $url, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
        ]);

        $data = json_decode((string) $apiRequest->getBody(), true);

        return $data;
    }

    public function authorize()
    {
        request()->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => env('CLIENT_ID'),
            'redirect_uri' => env('CLIENT_CALLBACK'),
            'response_type' => 'code',
            'scope' => 'public',
            'state' => $state,
        ]);

        return redirect("http://osu.ppy.sh/oauth/authorize?{$query}");
    }

    public function getRoomInfo(int $room)
    {
        return $this->apiRequest("https://osu.ppy.sh/api/v2/rooms/{$room}");
    }

    public function getRoomLeaderboard(int $room, int $page)
    {
        return $this->apiRequest("https://osu.ppy.sh/api/v2/rooms/{$room}/leaderboard?page={$page}");
    }

    public function getToken()
    {
        $state = request()->session()->pull('state');

        if(!isset($state) && $state === request()->state)
        {
            return redirect('/')->with('error', 'Something went wrong...');
        }

        try {
            $response = Guzzle::post('http://osu.ppy.sh/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => env('CLIENT_ID'),
                    'client_secret' => env('CLIENT_SECRET'),
                    'redirect_uri' => env('CLIENT_CALLBACK'),
                    'code' => request()->code,
                ],
            ]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Something went wrong...');
        }

        $data = json_decode((string) $response->getBody(), true);
        $token = $data['access_token'];

        request()->session()->put('token', $token);

        return $token;
    }

    public function getUserData(string $token) {
        return $this->apiRequest('https://osu.ppy.sh/api/v2/me', $token);
    }
}
