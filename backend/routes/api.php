<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserInfoController;
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
Route::get('/user-info/{id}',  [UserInfoController::class, 'list'])->name('user_info.list');
Route::post('/login',  [AuthController::class, 'login'])->name('login');
Route::post('/registration',  [AuthController::class, 'registration'])->name('registration');


Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');
    Route::get('/me',  [UserController::class, 'me'])->name('me');
    Route::post('/user-info',  [UserInfoController::class, 'save'])->name('user_info.save');
});
