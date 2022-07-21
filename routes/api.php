<?php

use App\Http\Controllers\API\V01\Auth\AuthController;
use App\Http\Controllers\API\V01\Channel\ChannelController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/v1')->group(function () {
    Route::prefix('/auth')->controller(AuthController::class)->group(function () {
        Route::post('/register', 'register')->name('auth.register');
        Route::post('/login', 'login')->name('auth.login');
        Route::post('/logout', 'logout')->name('auth.logout');
        Route::get('/user', 'user')->name('auth.user');
    });

    Route::prefix('/channel')->controller(ChannelController::class)->group(function () {
        Route::get('/index', 'getAllChannels')->name('channel.index');
        Route::post('/create', 'createNewChannel')->name('channel.create');
        Route::put('/update', 'updateChannel')->name('channel.update');
    });
});

