<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;

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

Route::Post('/login',[AuthController::class,'login']);
Route::Post('/register',[AuthController::class,'register']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    
    Route::get('/profile',[ApiController::class,'profile'])->name('profile');
    
    Route::resource('work', 'ApiController');

});