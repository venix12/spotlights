<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function getToken(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => env('CLIENT_ID'),
            'redirect_uri' => 'http://spotlights.team/callback',
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        return redirect('http://osu.ppy.sh/oauth/authorize?'.$query);
    }

    public function getUserData(Request $request)
    {
        $state = $request->session()->pull('state');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );

        $http = new \GuzzleHttp\Client;

        $response = $http->post('http://osu.ppy.sh/oauth/token', [  
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'redirect_uri' => 'http://spotlights.team/callback',
                'code' => $request->code,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        $token = $data['access_token'];

        $user = $http->request('GET', 'https://osu.ppy.sh/api/v2/me', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode((string) $user->getBody(), true);
    }

}
