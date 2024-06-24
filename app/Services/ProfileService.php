<?php

namespace App\Services;

use App\Http\Requests\UserProfileStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileHobby;
use App\Models\ProfilePreference;
use App\Models\UserProfile;
use App\Models\UserViewProfile;
use Intervention\Image\Colors\Profile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileService {

    public function edit(UserProfileStoreRequest $request) {
        
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
            $time = time();
            $imageName = $time.'.'.$request->file('image')->getClientOriginalExtension();
            $imageNameBlur = 'blur_'.$time.'.'.$request->file('image')->getClientOriginalExtension();

            $this->saveOriginalImage($request->file('image'), $imageName);
            $this->saveBlurImage($request->file('image'), $imageNameBlur);
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

    }

    public function openProfileInfo($profile_id) {
        $user_id = Auth::user()->id;

        $user_open_profile = UserViewProfile::query()
            ->where('profile_id', '=', $profile_id)
            ->where('user_id', '=', $user_id)
            ->first();

        if($user_open_profile) {
            dd("OK");
        }

        dd("ERROR");
        
    }

    protected function saveOriginalImage($image, $imageName) {
        $image->storeAs('public/images', $imageName);
    }

    protected function saveBlurImage($image, $imageName) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($image);
        $img = $image->blur(10);
        $img = $image->pixelate(10);

        $img->save(base_path('public/storage/images/' . $imageName));
    }

}