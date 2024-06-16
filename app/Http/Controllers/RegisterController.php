<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create() {
        return view('register');
    }

    /**
     * 
     * Create user account
     * 
     */
    public function store(UserStoreRequest $request, UserService $userService) {

        try {
            if($userService->registration($request)) {
                return redirect()->route('login')->with('msg-success', 'Регистрация прошла успешно.');
            }
        } catch (\Exception $e) {
            return redirect()->route('register')->withErrors(['msg-error' => $e->getMessage()]);
        }

        return redirect()->route('register')->with('is_sms_code', true);
        
    }
}
