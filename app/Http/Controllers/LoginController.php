<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create() {
        return view('login');
    }

    /**
     * 
     * User auth
     * 
     */
    public function store(UserLoginRequest $request, UserService $userService) {

        try {
            if($userService->login($request)) {
                return redirect()->route('profile');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg-error' => $e->getMessage()]);
        }

        return redirect()->route('login')->with('is_sms_code', true);

    }

    /**
     * 
     * User logout
     * 
     */
    public function logout(Request $request) {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('index');
    }
}
