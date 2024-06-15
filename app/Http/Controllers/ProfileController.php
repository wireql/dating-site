<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileStoreRequest;
use App\Models\ProfileHobby;
use App\Models\ProfilePreference;
use App\Models\User;
use App\Models\UserProfile;
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

    public function store(UserProfileStoreRequest $request) {

        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->get();
        $profile_id = $user[0]['profile']['id'];

        if(isset($request['hobbies'])) {

            ProfileHobby::where('profile_id', $profile_id)->delete();

            foreach ($request['hobbies'] as $hobby) {
                
                ProfileHobby::create([
                    'profile_id' => $profile_id,
                    'name' => $hobby,
                ]);

            }
        }

        if(isset($request['preferences'])) {

            ProfilePreference::where('profile_id', $profile_id)->delete();

            foreach ($request['preferences'] as $preference) {
                
                ProfilePreference::create([
                    'profile_id' => $profile_id,
                    'name' => $preference,
                ]);

            }

        }

        $user_profile = UserProfile::query()->where('user_id', '=', Auth::user()->id);

        $imageName = $user[0]['profile']['image'];

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
        }

        $user_profile->update([
            'country' => $request['country'],
            'city' => $request['city'],
            'nationality' => $request['nationality'],
            'profession' => $request['profession'],
            'work_place' => $request['work_place'],
            'weight' => $request['weight'],
            'height' => $request['height'],
            'status' => $request['status'],
            'education' => $request['education'],
            'instagram' => $request['instagram'],
            'telegram' => $request['telegram'],
            'facebook' => $request['facebook'],
            'message' => $request['facebook'],
            'image' => $imageName,
        ]);


        
        return redirect()->route('profile')->with('msg-success', 'Вы успешно изменили свою анкету!');

    }
}
