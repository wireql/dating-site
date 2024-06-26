<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileStoreRequest;
use App\Models\User;
use App\Models\UserFavourites;
use App\Models\UserProfile;
use App\Models\UserViewProfile;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function create() {
        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->with('profile.hobbies')->with('profile.preferences')->get();

        return view('profile', [
            'user' => $user,
        ]);
    }

    public function favourites() {

        $user = User::query()->where('id', '=', Auth::user()->id)->get();
        $favourites = UserFavourites::query()->where('user_id', '=', Auth::user()->id)->with('profile')->with('profile.user')->get();
        $favourites_list = UserFavourites::query()->where('user_id', '=', Auth::user()->id)->get();
        $opened_profiles = UserViewProfile::query()->where('user_id', '=', Auth::user()->id)->get();

        return view('profile', [
            'user' => $user,
            'favourites' => 1,
            'favourites_data' => $favourites,
            'favourites_list' => $favourites_list,
            'opened_profiles' => $opened_profiles
        ]);
    }

    public function recomendations() {
        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->get();

        $targetDate = Carbon::createFromFormat('Y-m-d', $user[0]['birthday']);
        $startDate = $targetDate->copy()->subYears(2);
        $endDate = $targetDate->copy()->addYears(2);

        $userProfile = UserProfile::with('preferences')->find($user[0]['profile']['id']);
        $preferences = $userProfile->preferences->pluck('name')->toArray();

        $recommendations = User::query()
            ->whereBetween('birthday', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->where('id', '!=', Auth::user()->id)
            ->with('profile')
            ->whereHas('profile.preferences', function($query) use ($preferences) {
                $query->whereIn('name', $preferences);
            })
            ->get();

        $opened_profiles = UserViewProfile::query()->where('user_id', '=', Auth::user()->id)->get();
        $favourites_list = UserFavourites::query()->where('user_id', '=', Auth::user()->id)->get();

        return view('profile', [
            'user' => $user,
            'recomendations' => 1,
            'recommendations_data' => $recommendations,
            'favourites_list' => $favourites_list,
            'opened_profiles' => $opened_profiles
        ]);
    }

    public function addFavourites(Request $request) {

        $profile = UserProfile::query()->where('id', '=', $request['profile_id'])->with('user')->first();

        if(!$profile) {
            return response()->json([
                "message" => "Пользователь не найден."
            ], 400);
        }

        if($profile['user']['id'] == Auth::user()->id) {
            return response()->json([
                "message" => "Вы не можете добавить в избранное себя."
            ], 400);
        }

        $user_favourite = UserFavourites::query()->where('user_id', '=', Auth::user()->id)->where('profile_id', '=', $request['profile_id'])->first();

        if($user_favourite) {
            $user_favourite->delete();

            return response()->json([
                "status" => "101",
                "message" => "Анкета убрана из избранного.",
                "profile_id" => $request['profile_id']
            ]);
        }

        UserFavourites::create([
            "user_id" => Auth::user()->id,
            "profile_id" => $request['profile_id'],
        ]);

        return response()->json([
            "status" => "100",
            "message" => "Вы добавили анкету в избранное",
            "profile_id" => $request['profile_id']
        ]);

    }

    public function store(UserProfileStoreRequest $request, ProfileService $profileService) {

        try {
            $profileService->edit($request);
        } catch (\Exception $e) {
            return redirect()->route('profile')->withErrors([
                'msg-error' => $e->getMessage()
            ]);
        }
        
        return redirect()->route('profile')->with('msg-success', 'Вы успешно изменили свою анкету!');

    }
}
