<?php

namespace App\Http\Controllers;

use App\Models\UserFavourites;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function create(UserProfile $user_profile) {

        $users = $user_profile->getUsersActiveProfiles();
        
        if(Auth::check()) {
            $favourites = UserFavourites::query()->where('user_id', '=', Auth::user()->id)->get();
        }

        return view('index', [
            'users' => $users,
            'users_total' => $users->count(),
            'favourites' => $favourites ?? null
        ]);
    }
}
