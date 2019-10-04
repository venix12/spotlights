<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
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

        if(!(strlen($state) > 0 && $state === $request->state))
        {
            return redirect('/');
        }

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

        $userData = $http->request('GET', 'https://osu.ppy.sh/api/v2/me', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);
        
        $userApi = json_decode((string) $userData->getBody(), true);
        
        $userId = $userApi['id'];
        
        $user = User::where('id', $userId)->first();

        dd($user);

        if($user === null || $user->active == 0)
        {
            return redirect('/');
        }

        Auth::login($user);

        return redirect(route('home'));
    }

}
