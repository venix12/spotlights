<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function index()
    {
        if(!Auth::check() || !Auth::user()->isAdmin())
        {
            return redirect('/'); 
        }

        return view('admin.resetpassword');
    }
}
