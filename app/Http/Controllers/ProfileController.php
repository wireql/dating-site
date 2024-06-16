<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileStoreRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create() {
        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->with('profile.hobbies')->with('profile.preferences')->get();

        return view('profile', [
            'user' => $user
        ]);
    }

    public function store(UserProfileStoreRequest $request, ProfileService $profileService) {

        try {
            $profileService->edit($request);
        } catch (\Exception $e) {
            return redirect()->route('profile')->withErrors([
                'msg-error' => 'При редактировании анкеты произошла ошибка.'
            ]);
        }
        
        return redirect()->route('profile')->with('msg-success', 'Вы успешно изменили свою анкету!');

    }
}
