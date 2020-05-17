<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request){
        $user = UserHelper::GetUser($request);
        return view('pages.support')->with([
            'logged' => $user !== null,
            'user' => $user
        ]);
    }

    public function submit(Request $request){
        //TODO: implement send!

        $this->response['status'] = 'OK';
        return $this->response;
    }
}
