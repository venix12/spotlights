<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AddedUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index()
    {
        $registeredUsername = session('registeredUsername');
        $token = session('passwordToken');

        return view('admin.addeduser')
            ->with('registeredUsername', $registeredUsername)
            ->with('token', $token)
            ->with('value', 'Added user!');
    }
}
