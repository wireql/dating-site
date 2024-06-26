<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index() {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->first();
        $total_users = User::query()->count();

        return view('admin/index', [
            'user' => $user,
            'total_users' => $total_users
        ]);
    }
}
