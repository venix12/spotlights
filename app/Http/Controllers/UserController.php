<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function destroy(Request $request)
    {
        if($request->userID != Auth::user()->id)
        {
            $user = User::find($request->userID);
            $user->delete();
            return redirect()->back()->with('success', 'Successfully removed an user!');
        }
        else
        {
            return redirect()->back()->with('error', "You can't remove yourself!");
        }
    }

    public function deactivate(Request $request)
    {
        if($request->userID != Auth::user()->id)
        {
            $user = User::find($request->userID);
            $user->active = 0;
            return redirect()->back()->with('success', 'Successfully deactivate an user!');
        }
        else
        {
            return redirect()->back()->with('error', "You can't deactivate yourself!");
        }
    }
}
