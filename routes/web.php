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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    //'register' => false
]);


Route::get('/', 'HomeController@index');

Route::get('/success', 'SuccessController@show');

Route::get('/media/{sess_id}/{id}', 'MediaController@show');

Route::get('/error', 'ErrorController@show');

Route::resource('invites','InviteController');

Route::resource('invites.applications','ApplicationController');

Route::get('/app/{appid}','Application@show');
