<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\UserViewProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    
    public function create($id) {

        $profile = UserProfile::query()->where('id', '=', $id)->with('hobbies')->with('preferences')->with('user')->get();
        $opened_profile = UserViewProfile::query()->where('user_id', '=', Auth::user()->id)->where('profile_id', '=', $id)->first();

        if($profile->isEmpty()) {
            return redirect()->route('index');
        }

        if($profile[0]['user']['id'] == Auth::user()->id) {
            return redirect()->route('profile');
        }

        return view('user', [
            'profile' => $profile,
            'opened_profile' => $opened_profile
        ]);
    }

}