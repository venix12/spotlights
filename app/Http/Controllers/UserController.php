<?php

namespace App\Http\Controllers;

use Auth;
use App\Event;
use App\User;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function activate(Request $request)
    {
        $user = User::find($request->userID);
        $user->active = true;
        $user->save();

        Event::log('Activated user '. $user->username);

        return redirect()->back()->with('success', 'Successfully activated an user!');
    }

    public function deactivate(Request $request)
    {
        if($request->userID != Auth::user()->id)
        {
            $user = User::find($request->userID);

            if(Auth::user()->isManager() && ($user->group_id == 1 || $user->group_id == 2 || $user->group_id == 3))
            {
                return redirect()->back()->with('error', "You can't deactivate administrators and managers!");
            }

            if($user->group_id != 0)
            {
                $user->group_id = 0;
            }
            $user->active = false;
            $user->save();

            Event::log('Deactivated user '. $user->username);

            return redirect()->back()->with('success', 'Successfully deactivated an user!');
        }
        else
        {
            return redirect()->back()->with('error', "You can't deactivate yourself!");
        }
    }

    public function change_usergroup(Request $request)
    {
        $user = User::find($request->userID);

        $user->active = true;
        $user->group_id = $request->group_id;

        $user->save();

        Event::log("Moved ".$user->username." to ".User::GROUPS[$request->group_id]."s");

        return redirect()->back()->with('success', 'Successfully changed the usergroup!');
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if(!$user)
        {
            return redirect()->back()->with('error', 'User not found!');
        }

        $user = User::find($user->id);

        $registeredUsername = $request->username;

        $newPassword = bin2hex(random_bytes(15));

        $user->password = Hash::make($newPassword);
        $user->save();

        Event::log('Resetted password for user '.$request->username);

        return view('admin.addedUser')
            ->with('registeredUsername', $registeredUsername)
            ->with('token', $newPassword)
            ->with('value', 'Password resetted!');
    }

    public function destroy(Request $request)
    {
        //TODO: remove all votes of deleted nomination
        if($request->userID != Auth::user()->id)
        {
            $user = User::find($request->userID);
            $userNominations = SpotlightsNomination::where('user_id', $request->userID);
            $userNominationVotes = SpotlightsNominationVote::where('user_id', $request->userID);

            $userNominationVotes->delete();
            $userNominations->delete();
            $user->delete();

            return redirect()->back()->with('success', 'Successfully removed an user!');
        }
        else
        {
            return redirect()->back()->with('error', "You can't remove yourself!");
        }
    }
}
