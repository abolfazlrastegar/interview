<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', function (Request $request){
    if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
        $token = Auth::user()->createToken('follower');

        return ['token' => $token->plainTextToken];
    }
});
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::group(['prefix' => 'order'], function (){
        Route::post('new', 'App\Http\Controllers\V1\OrderController@insert');
        Route::get('list', 'App\Http\Controllers\V1\OrderController@show');
    });

    Route::group(['prefix' => 'follower'], function (){
        Route::post('new', 'App\Http\Controllers\V1\FollowerController@insert');
        Route::get('list', 'App\Http\Controllers\V1\FollowerController@show');
    });
});
