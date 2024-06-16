<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function create(UserProfile $user_profile) {

        $users = $user_profile->getUsersActiveProfiles();

        return view('index', [
            'users' => $users,
            'users_total' => $users->count()
        ]);
    }
}
