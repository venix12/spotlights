<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index()
    {
        return view('admin.resetpassword');
    }
}
