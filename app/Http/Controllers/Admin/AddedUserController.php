<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use App\User;

class AddedUserController extends Controller
{
    public function index()
    {
        if(!Auth::check() || !Auth::user()->isAdmin())
        {
           return redirect('/'); 
        }
        
        $registeredUsername = session('registeredUsername');
        $token = session('passwordToken');

        return view('admin.addeduser')
            ->with('registeredUsername', $registeredUsername)
            ->with('token', $token);
    }
}
