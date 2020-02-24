<?php

namespace App\Libraries;

use Guzzle;
use Illuminate\Support\Str;

class OsuOauth
{
    public function authorize()
    {
        request()->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => env('CLIENT_ID'),
            'redirect_uri' => env('CLIENT_CALLBACK'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        return redirect("http://osu.ppy.sh/oauth/authorize?{$query}");
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

        return $token;
    }

    public function getUserData(string $token) {
        $userApiRequest = Guzzle::request('GET', 'https://osu.ppy.sh/api/v2/me', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
        ]);

        $userData = json_decode((string) $userApiRequest->getBody(), true);

        return $userData;
    }
}
