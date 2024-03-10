<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

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
Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('auth:sanctum');


Route::group([
    'as' => 'api.',
    'middleware' => ['auth:sanctum']
], function(){
        Route::get('user/current',[UserController::class, 'show_current_user']);
        Route::put('user',[UserController::class, 'update']);
        Route::apiResource('user',UserController::class);
        Route::put('role/{id}',[RoleController::class, 'update']);
        Route::apiResource('role',RoleController::class);
        Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
    }
);

    



