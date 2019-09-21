<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/added-user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function showRegistrationForm()
    {
        if(!Auth::check() || !Auth::user()->isAdmin())
        {
            return redirect('/');
        }
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'osu_user_id' => ['required', 'integer', 'unique:users'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    
    protected function create(array $data)
    {
        $user_id = $data['osu_user_id'];

        //get api string
        $key = env('OSU_API_KEY');
        $url = 'osu.ppy.sh/api/get_user?k='.$key.'&u='.$user_id;
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $userData = json_decode((string) $response->getBody(), true);

        //get user data from api
        foreach($userData as $key => $item)
        {
            $username = $item['username'];
        }

        session(['registeredUsername' => $username]);
        return User::create([
            'username' => $username,
            'password' => Hash::make(session('passwordToken')),
            'osu_user_id' => $user_id
        ]);
    }
}
