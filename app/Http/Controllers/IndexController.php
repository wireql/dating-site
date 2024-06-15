<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function create() {

        $users = UserProfile::query()
        ->with('user')
        ->whereNotNull('country')
        ->whereNotNull('city')
        ->whereNotNull('nationality')
        ->whereNotNull('profession')
        ->whereNotNull('work_place')
        ->whereNotNull('status')
        ->whereNotNull('height')
        ->whereNotNull('weight')
        ->whereNotNull('education')
        ->whereNotNull('image')
        ->get();

        return view('index', [
            'users' => $users,
            'users_total' => $users->count()
        ]);
    }
}
