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

// Api Routes

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');


// Authenticated Api Routes
Route::group(['middleware' => 'auth:api'], function() {
	Route::get('/auth-user', 'Api\AuthController@authUser');
});