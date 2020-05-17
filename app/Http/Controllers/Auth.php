<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Auth extends Controller
{
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }

    public  function login(Request $request){
        $validator = Validator::make($request->all(), [
            'login' => 'required|exists:users,login',
            'password' => 'required'
        ], [
            'required' => 'All fields required',
            'exists' => 'User not exists!'
        ]);

        if($validator->fails()){
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response);
        }

        $user = User::query()->where('login', $request['login'])->get()->first();

        if(!Hash::check($request['password'], $user->password)){
            $this->response['message'] = 'Invalid login or password!';
            return response()->json($this->response);
        }

        UserHelper::CompleteAuth($user, $request);
        $this->response['status'] = 'OK';
        return response()->json($this->response);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'login' => 'required|max:100|unique:users,login',
            'password' => 'required|min:8|same:password-2',
            'password-2' => 'required'
        ], [
            'required' => 'All fields required!',
            'unique' => 'This user already exist!',
            'min' => 'Min password length = 8',
            'same' => 'Passwords mismatch!'
        ]);
        if($validator->fails()){
            $this->response['message'] = $validator->errors()->first();
            return $this->response;
        }

        if(!UserHelper::CreateNewUser($request)){
            $this->response['message'] = 'Registration fault!';
            return $this->response;
        }

        $this->response['status'] = 'OK';
        return $this->response;
    }
}
