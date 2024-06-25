<?php

namespace App\Services;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Models\UserCode;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserService {

    public function login(UserLoginRequest $request) {

        $SMSCService = new SMSCService();

        /**
         * 
         * Validation an sms code
         * 
         */
        if($request['sms-code'] != null) {
            
            $user = User::find(session('user_id'));

            if(!$user) {
                throw new \Exception('Ошибка при проверке подлинности.');
            }

            if($user['code'] != $request['sms-code']) {
                throw new \Exception("Ошибка при авторизации. Неверный код.");
            }

            $user->update([
                'code' => null
            ]);

            if (!Auth::login($user, $remember = true)) {
                throw new \Exception("Ошибка при авторизации.");
            }

            $request->session()->flush();
            $request->session()->regenerate();

            return true;
        }

        /**
         * 
         * Checking the user exist and sending an sms code
         * 
         */
        $numeric_telephone = preg_replace('/\D/', '', $request['telephone']);
        $user = User::query()->where('telephone', '=', $numeric_telephone)->first();

        if(!$user) {
            throw new \Exception("Пользователь с данным номером телефона не зарегистрирован.");
        }

        $code = mt_rand(1000, 9999);

        $user->update([
            'code' => $code
        ]);
        $resp = $SMSCService->sendSMS($numeric_telephone, "Ваш код: " . $code);

        /**
         * Временно
         */
        // $request->session()->put('sms-code', $code);

        $request->session()->put('user_id', $user['id']);
    }

    public function registration(UserStoreRequest $request) {

        $SMSCService = new SMSCService();

        /**
         * 
         * Validation an sms code
         * 
         */
        if($request['sms-code'] != null) {
            
            $user = UserCode::query()->where('hash', '=', session('user_hash'))->first();

            if(!$user) {
                throw new \Exception('Ошибка при проверке подлинности.');
            }

            if($user['code'] != $request['sms-code']) {
                throw new \Exception("Ошибка при регистрации. Неверный код.");
            }

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

            if (!Auth::login($user, $remember = true)) {
                throw new \Exception("Ошибка при авторизации.");
            }

            $request->session()->flush();
            $request->session()->regenerate();

            return true;
        }

        /**
         * 
         * Checking the user exist and sending an sms code
         * 
         */
        $numeric_telephone = preg_replace('/\D/', '', $request['telephone']);
        $user = User::query()->where('telephone', '=', $numeric_telephone)->first();

        if($user) {
            throw new \Exception("Пользователь с данным номером телефона уже зарегистрирован.");
        }

        $request['telephone'] = preg_replace('/\D/', '', $request['telephone']);
        $user_hash = Str::uuid();
        $code = mt_rand(1000, 9999);

        UserCode::createCode($user_hash, $code);

        /**
         * Отправка сообщения на номер телефона
         */
        // $resp = $SMSCService->sendSMS($request['telephone'], "Ваш код: " . $code, 0, 0, 0, 0, false, "imgcode=".$request["code"]."&userip=".$_SERVER["REMOTE_ADDR"]);
        $resp = $SMSCService->sendSMS($request['telephone'], "Ваш код: " . $code);

        /**
         * Временно
         */
        // $request->session()->put('sms-code', $code);
        
        $request->session()->put('user_hash', $user_hash);
        $request->session()->put('user_data', $request->all());
    }

    /**
     * 
     * Generate user profile ID
     * 
     */
    private function generateRandomUserProfileID() {
        do {
            $randomId = mt_rand(100000, 999999);
        } while (UserProfile::where('id', $randomId)->exists());

        return $randomId;
    }

} 