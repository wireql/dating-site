<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    
    public function create($id) {

        $profile = UserProfile::query()->where('id', '=', $id)->with('hobbies')->with('preferences')->with('user')->get();

        if($profile->isEmpty()) {
            return redirect()->route('index');
        }

        return view('user', [
            'profile' => $profile
        ]);
    }

}