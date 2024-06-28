<?php

namespace App\Services;

use App\Http\Requests\UserProfileStoreRequest;
use App\Models\Hobby;
use App\Models\Parents;
use App\Models\Preferences;
use App\Models\ProfileAbout;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileHobby;
use App\Models\ProfileParents;
use App\Models\ProfilePreference;
use App\Models\UserProfile;
use App\Models\UserViewProfile;
use App\Models\UserViewSocial;
use App\Models\UserViewTelephone;
use Intervention\Image\Colors\Profile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileService {

    public function edit(UserProfileStoreRequest $request) {
        
        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->get();
        $profile_id = $user[0]['profile']['id'];

        if(isset($request['hobbies'])) {

            ProfileHobby::where('profile_id', $profile_id)->delete();

            $newPreferenceIds = [];
            if(isset($request['hobbies']['new'])) {
                foreach ($request['hobbies']['new'] as $preference) {
                
                    $newPreference = Hobby::create([
                        'name' => $preference
                    ]);
    
                    $newPreferenceIds[] = $newPreference->id;
                }

                $allPreferenceIds = array_merge($request['hobbies'], $newPreferenceIds);
                $request['hobbies'] = $allPreferenceIds;
            }

            foreach ($request['hobbies'] as $key => $hobby) {
                
                if($key !== "new") {
                    ProfileHobby::create([
                        'profile_id' => $profile_id,
                        'hobby_id' => $hobby,
                    ]);
                }

            }
        }

        if(isset($request['preferences'])) {

            ProfilePreference::where('profile_id', $profile_id)->delete();

            $newPreferenceIds = [];
            if(isset($request['preferences']['new'])) {
                foreach ($request['preferences']['new'] as $preference) {
                
                    $newPreference = Preferences::create([
                        'name' => $preference
                    ]);
    
                    $newPreferenceIds[] = $newPreference->id;
                }

                $allPreferenceIds = array_merge($request['preferences'], $newPreferenceIds);
                $request['preferences'] = $allPreferenceIds;
            }

            foreach ($request['preferences'] as $key => $preference) {
                
                if($key !== "new") {
                    ProfilePreference::create([
                        'profile_id' => $profile_id,
                        'preference_id' => $preference,
                    ]);
                }

            }

        }


        if(isset($request['preferencesabot'])) {

            ProfileAbout::where('profile_id', $profile_id)->delete();

            $newPreferenceIds = [];
            if(isset($request['preferencesabot']['new'])) {
                foreach ($request['preferencesabot']['new'] as $preference) {
                
                    $newPreference = Preferences::create([
                        'name' => $preference
                    ]);
    
                    $newPreferenceIds[] = $newPreference->id;
                }

                $allPreferenceIds = array_merge($request['preferencesabot'], $newPreferenceIds);
                $request['preferencesabot'] = $allPreferenceIds;
            }

            foreach ($request['preferencesabot'] as $key => $preference) {
                
                if($key !== "new") {
                    ProfileAbout::create([
                        'profile_id' => $profile_id,
                        'preference_id' => $preference,
                    ]);
                }

            }

        }

        if(isset($request['parents'])) {

            ProfileParents::where('profile_id', $profile_id)->delete();

            foreach ($request['parents'] as $key => $preference) {
                
                ProfileParents::create([
                    'profile_id' => $profile_id,
                    'parent_id' => $preference,
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
        $user = User::find($user_id);

        $user_open_profile = UserViewProfile::query()
            ->where('profile_id', '=', $profile_id)
            ->where('user_id', '=', $user_id)
            ->first();

        if($user_open_profile) {
            throw new \Exception("Вы уже открывали ФИО и фото данной анкеты.");
        }

        if($user['profiles_views'] <= 0) {
            throw new \Exception("У вас нет возможности просматривать ФИО и фото анкеты.");
        }

        $user->profiles_views -= 1;
        $user->save();

        UserViewProfile::create([
            'user_id' => $user_id,
            'profile_id' => $profile_id,
        ]);

        return [
            "message" => "Вы успешно открыли ФИО и фото анкеты."
        ];
        
    }

    public function openSocialInfo($profile_id) {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $user_open_social = UserViewSocial::query()
            ->where('profile_id', '=', $profile_id)
            ->where('user_id', '=', $user_id)
            ->first();

        if($user_open_social) {
            throw new \Exception("Вы уже открывали закрытую информацию данной анкеты.");
        }

        if($user['social_views'] <= 0) {
            throw new \Exception("У вас нет возможности просматривать закрытую информацию анкеты.");
        }

        $user->social_views -= 1;
        $user->save();
        
        UserViewSocial::create([
            'user_id' => $user_id,
            'profile_id' => $profile_id,
        ]);

        return [
            "message" => "Вы успешно открыли закрытую информацию анкеты."
        ];
    }

    public function openTelephoneInfo($profile_id) {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $user_open_telephone = UserViewTelephone::query()
            ->where('profile_id', '=', $profile_id)
            ->where('user_id', '=', $user_id)
            ->first();

        if($user_open_telephone) {
            throw new \Exception("Вы уже открывали номер телефона данной анкеты.");
        }

        if($user['telephone_views'] <= 0) {
            throw new \Exception("У вас нет возможности просматривать номер телефона анкеты.");
        }

        $user->telephone_views -= 1;
        $user->save();
        
        UserViewTelephone::create([
            'user_id' => $user_id,
            'profile_id' => $profile_id,
        ]);

        return [
            "message" => "Вы успешно открыли номер телефона анкеты."
        ];
    }

    protected function saveOriginalImage($image, $imageName) {
        $image->storeAs('public/images', $imageName);
    }

    protected function saveBlurImage($image, $imageName) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($image);
        $img = $image->blur(20);
        $img = $image->pixelate(15);

        $img->save(base_path('public/storage/images/' . $imageName));
    }

}