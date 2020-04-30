<?php


namespace App\Helpers;

use App\Models\User;
use Illuminate\Http\Request;
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
            $user = User::query()->where('login', @$request->session()->get('login'))->get()->first();
            if(!$user)
                return null;

            if(!Hash::check(@$request->session()->get('password'), $user->password))
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
        $request->session()->put('passphrase', CryptoHelper::DecryptPassphrase($request['password'], $user->passphrase));
        $request->session()->put('login', $request['login']);
        $request->session()->put('password', $request['password']);
    }
}
