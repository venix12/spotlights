<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use Auth;

class ManageController extends Controller
{
    public function index()
    {
        if(!Auth::check() || !(Auth::user()->isAdmin() || Auth::user()->isManager()))
        {
            return redirect('/');
        }

        return view('admin.manage');
    }
}
