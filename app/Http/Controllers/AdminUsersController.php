<?php

namespace App\Http\Controllers;

use App\Models\ProfilePreference;
use App\Models\User;
use App\Models\UserFavourites;
use App\Models\UserProfile;
use App\Models\UserViewProfile;
use App\Models\UserViewSocial;
use App\Models\UserViewTelephone;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUsersController extends Controller
{
    public function index(Request $request) {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->first();
        $users = UserProfile::query()->with('user');

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

        return view('admin/users', [
            'user' => $user,
            'users' => $users,
            'filter_data' => $filter_data,
            'cities' => $cities ?? null
        ]);
    }

    public function show($id) {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->first();
        $user_data = User::query()->where('id', '=', $id)->with('profile')->with('profile.hobbies')->with('profile.preferences')->first();

        return view('admin/user', [
            'user' => $user,
            'user_data' => $user_data
        ]);
    }

    public function delete($id) {

        $user = User::query()->where('id', '=', $id)->first();

        if(!$user) {
            abort(404);
        }

        /**
         * User favourites
         */
        $user_f = UserFavourites::query()->where('profile_id', '=', $user->profile['id'])->get();
        if($user_f->isNotEmpty()) {
            foreach ($user_f as $item) {
                $item->delete();
            }
        }

        $user->delete();

        return "OK";
    }

    public function update($id) {
        $user = User::query()->where('id', '=', $id)->with('profile')->first();

        if(!$user) {
            abort(404);
        }

        $user->profile()->update([
            'is_active' => ($user['profile']['is_active'] == 1) ? 0 : 1
        ]);

        return "OK";
    }

    public function add(Request $request, $id) {
        $user = User::query()->where('id', '=', $id)->with('profile')->first();

        if(!$user) {
            abort(404);
        }

        $user->profiles_views = $request['profiles_views'];
        $user->telephone_views = $request['telephone_views'];
        $user->social_views = $request['social_views'];

        $user->save();

        return redirect()->route('admin.user.add', $id);
    }
}
