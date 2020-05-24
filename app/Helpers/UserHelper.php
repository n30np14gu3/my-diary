<?php


namespace App\Helpers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserHelper
{
    /**
     * @param Request $request
     * @return User|null
     */
    public static function GetUser(Request $request){
        try{
            $session = self::GetUserSession($request);
            if(!$session)
                return null;

            if($session->expire_in < time())
                return null;

            $user = User::query()->where('login', $session->login)->get()->first();
            if(!$user)
                return null;

            if(!Hash::check(@$session->password, $user->password))
                return null;

            return $user;
        }catch(\Exception $ex){
            return null;
        }
    }

    /**
     * @param Request $request
     * @return bool|integer
     */
    public static function CreateNewUser(Request $request){
        try{
            $passphrase = Str::random(64);
            $user = new User();
            $keys = CryptoHelper::GetKeyPair($passphrase);

            $user->login = $request['login'];
            $user->password = Hash::make($request['password']);
            $user->passphrase = CryptoHelper::EncryptPassphrase($request['password'], $passphrase);
            $user->public_key = $keys['pub'];
            $user->private_key = $keys['sec'];
            $user->save();

            if(env('SEC_DEBUG')){
                Log::debug('---NEW USER CREATED---');
                Log::debug('Passphrase: '.$passphrase);
                Log::debug('Private key:\r\n'.$user->private_key);
                Log::debug('Public key:\r\n'.$user->public_key);
                Log::debug('---------------');
            }
            return $user->id;
        }catch(\Exception $ex){
            Log::error('Registration fail:'.$ex->getMessage());
            return false;
        }
    }

    public static function CompleteAuth(User $user, Request $request){
        $path = storage_path("app/secure_sessions/".Str::random(32));

        $session = new UserSession($path);
        $session->expire_in = time() + 60 * 60;
        $session->id = $user->id;
        $session->login = $user->login;
        $session->password = $request['password'];
        $session->passphrase =  CryptoHelper::DecryptPassphrase($request['password'], $user->passphrase);

        $request->session()->put('session_path', $path);

        $cookie = [
            'path' => $path
        ];

        $cookie = json_encode($cookie);
        Cookie::queue(\cookie('secure_sid', CryptoHelper::CompressCookie($cookie), 60));
        $session->save($request);
    }

    /**
     * @param Request $request
     * @return UserSession|null
     */
    public static function GetUserSession(Request $request){
        $path = @$request->session()->get('session_path');
        $session = null;
        if(!$path){
            $cookie = @json_decode(CryptoHelper::DecompressCookie(@Cookie::get('secure_sid')), true);
            if(!$cookie)
                return null;

            $path = @$cookie['path'];
            $request->session()->put('session_path', $path);
        }

        if(!$path)
            return null;

        return new UserSession($path);
    }


}
