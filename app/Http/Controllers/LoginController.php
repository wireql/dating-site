<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Models\UserCode;
use Illuminate\Support\Str;
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
    public function store(UserLoginRequest $request) {

        if($request['sms-code'] != null) {
            
            $user = User::find(session('user_id'));

            if(!$user) {
                return redirect()->route('register')->withErrors(['msg-error' => 'Ошибка при проверке подлинности.']);
            }

            if($user['code'] == $request['sms-code']) {
                $user->update([
                    'code' => null
                ]);
                
                if (!Auth::login($user, $remember = true)) {
                    return back()->withErrors(['msg-error' => "Ошибка при авторизации."]);
                }

                $request->session()->flush();
                $request->session()->regenerate();

                return redirect()->route('profile');
            }

            $request->session()->flush();
            
            return redirect()->route('login')->withErrors(['msg-error' => "Ошибка при авторизации. Неверный код."]);
        }
        
        $pattern = '/^\+7 \d{3} \d{3} \d{2} \d{2}$/';

        if (!preg_match($pattern, $request['telephone'])) {
            return redirect()->route('login')->withErrors(['telephone' => 'Некорректный формат номера телефона.']);
        }

        $numeric_telephone = preg_replace('/\D/', '', $request['telephone']);
        $user = User::query()->where('telephone', '=', $numeric_telephone)->first();

        if(!$user) {
            return redirect()->route('login')->withErrors(['msg-error' => 'Пользователь с данным номером телефона не зарегистрирован.']);
        }

        $request['telephone'] = $numeric_telephone;

        $code = mt_rand(1000, 9999);

        try {
            $user->update([
                'code' => $code
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('login')->withErrors(['msg-error' => 'Ошибка при генерации кода. Повторите попытку или обратитесь к администрации.']);
        }

        /**
         * Временно
         */
        $request->session()->put('sms-code', $code);
        $request->session()->put('user_id', $user['id']);

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
