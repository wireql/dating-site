<?php

namespace App\Http\Controllers;

use App\Models\UserFavourites;
use App\Models\UserProfile;
use App\Models\UserViewProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function create(Request $request, UserProfile $user_profile) {

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
            ->whereNotNull('image');
        
        $favourites = UserFavourites::query()->where('user_id', '=', Auth::user()->id)->get();
        $opened_profiles = UserViewProfile::query()->where('user_id', '=', Auth::user()->id)->get();

        $filter_data = config('filter_data');

        if($request->has('country')) {
            $cities = $filter_data['countries'][$request['country']];

            $users->where('country', 'LIKE', "%{$request['country']}%");
        }

        if($request->has('city')) {
            $users->where('city', 'LIKE', "%{$request['city']}%");
        }

        if($request->has('nationality')) {
            $users->where('nationality', 'LIKE', "%{$request['nationality']}%");
        }

        if($request->has('gender')) {
            switch ($request['gender']) {
                case 'Мужской':
                    $users->whereHas('user', function ($query) {
                        $query->where('gender', 1);
                    });
                    break;
                case 'Женский':
                    $users->whereHas('user', function ($query) {
                        $query->where('gender', 2);
                    });
                    break;
                
                default:
                    $users->whereHas('user', function ($query) {
                        $query->where('gender', 1);
                    });
                    break;
            }
        }

        $users = $users->get();

        return view('index', [
            'users' => $users,
            'users_total' => $users->count(),
            'favourites' => $favourites ?? null,
            'opened_profiles' => $opened_profiles ?? null,
            'filter_data' => $filter_data,
            'cities' => $cities ?? null
        ]);
    }
}
