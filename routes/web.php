<?php

use App\Models\Role;
use App\Models\Satwa;
use App\Models\ListUpt;
use App\Models\Tagging;
use App\Models\ListSpecies;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\checkpermission;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SatwaController;
use App\Http\Controllers\LembagaKonservasiController;
use App\Http\Controllers\ListSpeciesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return view('auth.login');})->name('login');

//Auth
Route::get('/register', function () {
    $roles = Role::all();
    $upt_bentuk = ListUpt::distinct()->select('bentuk')->get();
    $upt_wilayah = ListUpt::distinct()->select('wilayah')->get();
    $list_lk = LembagaKonservasi::orderBy('nama','asc')->get();
    // dd($list_lk);
    $list_species =ListSpecies::all();

    // dd($upt_bentuk);
    return view('auth.register',compact('roles','upt_bentuk','upt_wilayah','list_lk','list_species'));
});

Route::post('/register1',[AuthController::class, 'register1'])->name('register1');
Route::post('/register2',[AuthController::class, 'register2'])->name('register2');
Route::post('/register3',[AuthController::class, 'register3'])->name('register3');
Route::post('/login', [AuthController::class, 'login'])->name('authenticate');

Route::middleware(['auth:sanctum','check.permission',config('jetstream.auth_session'),'verified'])
->group(function () {
    Route::get('/check-permission',[checkpermission::class,'check']);

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::get('/get-satwa', [SatwaController::class, 'updateDashboard']);
    Route::get('/get-lembaga-konservasi', [LembagaKonservasiController::class, 'getall']);
    Route::get('/get-spesies', [ListSpeciesController::class, 'index']);

    Route::resource('lembaga-konservasi', LembagaKonservasiController::class);

    Route::post('/lembaga-konservasi/import',[LembagaKonservasi::class])->name('import-lk');
    Route::get('/monitoring',[LembagaKonservasiController::class,'monitoring'])->name('monitoring-lk');

    
    Route::resource('satwa', SatwaController::class)->parameters([
        'satwa' => 'id'
    ]);
    
    Route::get('/pendataan-satwa', [SatwaController::class,'form'])->name('form-satwa');
    Route::post('/satwa/pendataan1',[SatwaController::class, 'pendataan1'])->name('pendataan-satwa1');
    Route::post('/satwa/pendataan2',[SatwaController::class, 'pendataan2'])->name('pendataan-satwa2');
    Route::get('/search',[SatwaController::class,'search'])->name('satwa-search');
    

    Route::get('/permission', function(){
        return view('permission');
    })->name('permission');
    Route::get('/verifikasi-akun',[AuthController::class,'index'])->name('verifikasi-akun');
    Route::post('/updated-permission/{id}',[AuthController::class,'updatePermission'])->name('updated-permission');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::get('/get-wilayah-upt',[AuthController::class,'getWilayahUPT']);

