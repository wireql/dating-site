<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Models\UserCode;
use App\Models\UserProfile;
use Illuminate\Support\Str;
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
    public function store(UserStoreRequest $request) {

        if($request['sms-code'] != null) {
            
            $user = UserCode::query()->where('hash', '=', session('user_hash'))->first();

            if(!$user) {
                return redirect()->route('register')->withErrors(['msg-error' => 'Ошибка при проверке подлинности.']);
            }

            if($user['code'] == $request['sms-code']) {

                $user = User::create([
                    'gender' => session('user_data')['gender'],
                    'username' => session('user_data')['username'],
                    'birthday' => session('user_data')['birthday'],
                    'telephone' => session('user_data')['telephone'],
                ]);

                UserProfile::create([
                    'id' => $this->generateRandomUserProfileID(),
                    'user_id' => $user->id
                ]);

                $request->session()->flush();

                return redirect()->route('login')->with('msg-success', 'Регистрация прошла успешно.');
            }

            $request->session()->flush();
            
            return redirect()->route('register')->withErrors(['msg-error' => "Ошибка при регистрации. Неверный код."]);
        }

        $pattern = '/^\+7 \d{3} \d{3} \d{2} \d{2}$/';

        if (!preg_match($pattern, $request['telephone'])) {
            return redirect()->route('register')->withErrors(['telephone' => 'Некорректный формат номера телефона.']);
        }

        $request['telephone'] = preg_replace('/\D/', '', $request['telephone']);

        $user_hash = Str::uuid();
        $code = mt_rand(1000, 9999);

        try {
            UserCode::createCode($user_hash, $code);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('register')->withErrors(['msg-error' => 'Ошибка при генерации кода. Повторите попытку или обратитесь к администрации.']);
        }

        /**
         * Временно
         */
        $request->session()->put('sms-code', $code);
        
        $request->session()->put('user_hash', $user_hash);
        $request->session()->put('user_data', $request->all());

        return redirect()->route('register')->with('is_sms_code', true);
        
    }

    /**
     * 
     * Generate user profile ID
     * 
     */
    private function generateRandomUserProfileID()
    {
        do {
            $randomId = mt_rand(100000, 999999);
        } while (UserProfile::where('id', $randomId)->exists());

        return $randomId;
    }
}
