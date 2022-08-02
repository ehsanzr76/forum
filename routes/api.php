<?php

use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\Channel\ChannelController;
use App\Http\Controllers\API\v1\Thread\AnswerController;
use App\Http\Controllers\API\v1\Thread\SubscribeController;
use App\Http\Controllers\API\v1\Thread\ThreadController;
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

Route::prefix('v1')->group(function () {

    ////user
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/register', 'register')->name('auth.register');
        Route::post('/login', 'login')->name('auth.login');
        Route::post('/logout', 'logout')->name('auth.logout');
        Route::get('/user', 'user')->name('auth.user');
    });


    ///channel
    Route::prefix('channel')->controller(ChannelController::class)->group(function () {  ///because all channels every one can seen
        Route::get('/index', 'index')->name('channel.index');
        Route::group(['middleware' => ['permission:channel_management', 'auth:sanctum']], function () {     //just users authenticate can channel management
            Route::post('/create', 'create')->name('channel.create');
            Route::put('/update', 'update')->name('channel.update');
            Route::delete('/delete', 'destroy')->name('channel.delete');
        });
    });


    ////thread
    Route::Resource('threads', ThreadController::class);


    ////answer
    Route::prefix('/threads')->resource('answers', AnswerController::class);


    ////subscribe
    Route::prefix('/threads')->resource('subscribes', SubscribeController::class);

});

