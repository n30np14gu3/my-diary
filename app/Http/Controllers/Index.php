<?php

namespace App\Http\Controllers;


use App\Helpers\UserHelper;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index(Request $request){
        return view('pages.welcome')->with([
            'logged' => UserHelper::GetUser($request) != null
        ]);
    }

    public function faq(Request $request){
        return view('pages.faq')->with([
            'logged' => UserHelper::GetUser($request) != null
        ]);
    }
}
