<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\Parents;
use App\Models\Preferences;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDatasController extends Controller
{
    public function index() {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        $user = User::query()->where('id', '=', Auth::user()->id)->with('profile')->first();
        $hobbies = Hobby::query()->get();
        $preferences = Preferences::query()->get();
        $parents = Parents::query()->get();

        return view('admin/datas', [
            'user' => $user,
            'hobbies' => $hobbies,
            'preferences' => $preferences,
            'parents' => $parents
        ]); 
    }

    public function create_parents(Request $request) {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        $request->validate([
            'new_parents' => ['required', 'string']
        ]);

        Parents::create([
            'name' => $request['new_parents']
        ]);

        return redirect()->route('admin.datas');
    }

    public function action_parents(Request $request, $id) {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        switch ($request['act']) {
            case 'update':

                $parents = Parents::find($id);
                $parents->name = $request['parents'];
                $parents->save();

                break;
            case 'delete':
                $parents = Parents::find($id);
                $parents->delete();
                break;
        }

        return redirect()->route('admin.datas');
    }

    public function create_preferences(Request $request) {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        $request->validate([
            'new_preferences' => ['required', 'string']
        ]);

        Preferences::create([
            'name' => $request['new_preferences']
        ]);

        return redirect()->route('admin.datas');
    }

    public function action_preferences(Request $request, $id) {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        switch ($request['act']) {
            case 'update':

                $preferences = Preferences::find($id);
                $preferences->name = $request['preference'];
                $preferences->save();

                break;
            case 'delete':
                $preferences = Preferences::find($id);
                $preferences->delete();
                break;
        }

        return redirect()->route('admin.datas');
    }

    public function create_hobby(Request $request) {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        $request->validate([
            'new_hobby' => ['required', 'string']
        ]);

        Hobby::create([
            'name' => $request['new_hobby']
        ]);

        return redirect()->route('admin.datas');
    }

    public function action_hobby(Request $request, $id) {
        if (Gate::denies('access')) {
            return redirect()->route('index');
        }

        switch ($request['act']) {
            case 'update':

                $hobby = Hobby::find($id);
                $hobby->name = $request['hobby'];
                $hobby->save();

                break;
            case 'delete':
                $hobby = Hobby::find($id);
                $hobby->delete();
                break;
        }

        return redirect()->route('admin.datas');
    }
}
