<?php

use Illuminate\Http\Request;
use App\Http\Controllers\KodePosAPI;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\checkpermission;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users',  function (Request $request) {
        return $request->user();
    });
Route::post('/register1',[AuthController::class, 'register1'])->name('register1');
Route::post('/register2',[AuthController::class, 'register2'])->name('register2');
Route::post('/register3',[AuthController::class, 'register3'])->name('register3');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', function () {return view('auth.login');})->name('login');

});


Route::get('/search',[KodePosAPI::class,'search']);
Route::get('/check-permission',[checkpermission::class,'check']);

