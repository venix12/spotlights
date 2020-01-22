<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Event;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use OsuApi;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/admin/added-user';

    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

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

    protected function create(array $data)
    {
        $user_id = $data['osu_user_id'];

        $response = OsuApi::getUser($user_id);

        if ($response === [])
        {
            return redirect()->back()
                ->with('error', 'no username found!');
        }

        $username = $response[0]['username'];

        Event::log("Added new user {$username}");

        session(['registeredUsername' => $username]);

        return User::create([
            'osu_user_id' => $user_id,
            'password' => Hash::make(session('passwordToken')),
            'username' => $username,
            $data['mode'] => true,
        ]);
    }
}
