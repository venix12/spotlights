<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Event;
use App\Models\User;
use App\Models\SpotlightsNomination;
use App\Models\SpotlightsNominationVote;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin_or_manager');

        $this->middleware('is_admin')->only([
            'destroy', 'resetPassword'
        ]);
    }

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

            if(Auth::user()->isManager() && $user->isAdminOrManager())
            {
                return redirect()->back()->with('error', "You can't deactivate administrators and managers!");
            }

            $user->group_id = 0;
            $user->active = false;
            $user->save();

            Event::log("Deactivated user {$user->username}");

            return redirect()->back()->with('success', 'Successfully deactivated an user!');
        }

        return redirect()->back()->with('error', "You can't deactivate yourself!");
    }

    public function destroy(Request $request)
    {
        //TODO: remove all votes of deleted nomination
        if($request->userID !== Auth::user()->id)
        {
            $user = User::find($request->userID);
            $userNominations = SpotlightsNomination::where('user_id', $request->userID);
            $userNominationVotes = SpotlightsNominationVote::where('user_id', $request->userID);

            $userNominationVotes->delete();
            $userNominations->delete();
            $user->delete();

            return redirect()->back()->with('success', 'Successfully removed an user!');
        }

        return redirect()->back()->with('error', "You can't remove yourself!");
    }
}
