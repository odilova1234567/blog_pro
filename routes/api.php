<?php

use App\Http\Controllers\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[ApiUserController::class,"Login"]);
Route::post('/register',[ApiUserController::class,"Register"]);
Route::get("/list",[ApiUserController::class,"list"]);
Route::middleware('user_auth')->get('/get',[ApiUserController::class,"getApiUser"]);
Route::post("/create",[ApiUserController::class,"add"]);
Route::post("/update/{id}",[ApiUserController::class,"news"]);
Route::delete("/delete/{id}",[ApiUserController::class,"destroy"]);
