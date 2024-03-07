<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::group([
    'as' => 'api.',
    'middleware' => ['auth:sanctum']
], function(){
        Route::apiResource('user',UserController::class);
        Route::apiResource('role',RoleController::class);
        Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
    }
);

    



