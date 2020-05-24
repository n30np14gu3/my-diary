<?php

namespace App\Http\Controllers;

use App\Helpers\CryptoHelper;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(){
        return view('pages.settings')->with([
            'logged' => true
        ]);
    }

    public function change_password(Request $request){
        $validator = Validator::make($request->all(), [
            'old-password' => 'required|in:'.$request->session()->get('password'),
            'new-password' => 'required|min:8|same:new-password-2',
            'new-password-2' => 'required'
        ], [
            'required' => 'All fields required!',
            'min' => 'Min password length = 8',
            'same' => 'Passwords mismatch!',
            'in' => 'Invalid old password'
        ]);

        if($validator->fails()){
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response);
        }

        $user = UserHelper::GetUser($request);
        $session = UserHelper::GetUserSession($request);

        $user->password = Hash::make($request['new-password']);
        $user->passphrase = CryptoHelper::EncryptPassphrase($request['new-password'], $request->session()->get('passphrase'));
        $user->save();

        $session->password = $request['new-password'];
        $session->save($request);

        $this->response['status'] = 'OK';
        return  $this->response;
    }
}
