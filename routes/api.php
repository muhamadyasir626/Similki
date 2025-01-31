<?php

use Illuminate\Http\Request;
use App\Http\Controllers\KodePosAPI;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangKonservasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SatwaController;
use App\Models\BarangKonservasi;

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

Route::middleware(['web'])->group(function () {
    Route::post('/register1', [AuthController::class, 'register1'])->name('register1');
    Route::post('/register2', [AuthController::class, 'register2'])->name('register2');
    Route::post('/register3', [AuthController::class, 'register3'])->name('register3');
    Route::get('/get-wilayah-upt',[AuthController::class,'getWilayahUPT']);
    Route::get('/search',[KodePosAPI::class,'search']);
    Route::get('/search-ListSpecies',[SatwaController::class,'getListSpecies']);
    Route::get('/get-pelabuhan-indonesia',[BarangKonservasiController::class ,'getPelabuhan']);
});






Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('check-permission',[AuthController::class,'checkPermission']);
    Route::post('/updated-permission/{id}',[AuthController::class,'updatePermission'])->name('updated-permission');
    Route::get('dashboard-filter',[DashboardController::class,'filter']);
    Route::get('/getcouple/{jenis_kelamin}',[SatwaController::class,'getCouples']);
    Route::post('/store-genealogy',[SatwaController::class,'storeGenealogy']);
    
    
});

