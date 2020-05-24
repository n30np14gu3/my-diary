<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('', ['uses' => 'Index@index']);
Route::get('faq', ['uses' => 'Index@faq']);
Route::get('logout', ['uses' => 'Auth@logout']);

Route::group(['prefix' => 'support'], function(){
    Route::get('', ['uses' => 'SupportController@index']);
    Route::post('submit', ['uses' => 'SupportController@submit']);
});

Route::group(['middleware' => 'diary_auth'], function (){
    Route::get('diary', ['uses' => 'DiaryController@index']);
    Route::get('settings', ['uses' => 'AccountController@index']);
    Route::post('change_password', ['uses' => 'AccountController@change_password']);
    Route::post('compose', ['uses' => 'DiaryController@compose']);
    Route::post('edit', ['uses' => 'DiaryController@edit']);
    Route::post('delete', ['uses' => 'DiaryController@delete']);
    Route::get('note/{note_id}', ['uses' => 'DiaryController@note']);
    Route::get('export/{note_id}', ['uses' => 'DiaryController@export']);
});

Route::group(['middleware' => 'diary_auth_form'], function(){
    Route::post('login', ['uses' => 'Auth@login']);
    Route::post('register', ['uses' => 'Auth@register']);
});

Route::group(['prefix' => 'd3v_4p1', 'middleware' => 'diary_auth'], function(){
    Route::get('free_export/{note_id}', ['uses' => 'DevApi@free_export']);
});
