<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\Event;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index()
    {
        return view('auth.changepassword');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'passwordCurrent' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::user()->password;

        if(Hash::check($request->passwordCurrent, $hashedPassword))
        {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();

            Event::log("Changed the password");

            return redirect()->route('home')->with('success', 'Password has been changed successfully!');
        }
        else
        {
            return redirect()->back()->with('error', 'Current password is invaild!');
        }
    }
}
