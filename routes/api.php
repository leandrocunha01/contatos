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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ROTAS PARA AUTENTICAÇÃO
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/reset-password', 'App\Http\Controllers\Auth\LoginController@resetPassword');


// Rotas para contatos
Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::get('/contacts', 'App\Http\Controllers\ContactController@index');
        Route::post('/contacts', 'App\Http\Controllers\ContactController@store');
        Route::put('/contacts/{id}', 'App\Http\Controllers\ContactController@update');
        Route::get('/contacts/{id}', 'App\Http\Controllers\ContactController@view');
        Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
    });
