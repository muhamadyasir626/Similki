<?php

use App\Models\Role;
use App\Models\ListUpt;
use App\Models\ListSpecies;
use App\Models\LembagaKonservasi;
use App\Models\Satwa;
use App\Models\Tagging;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\checkpermission;
use App\Http\Controllers\LembagaKonservasiController;
use App\Http\Controllers\SatwaController;
use Illuminate\Contracts\View\View;

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

Route::post('register1',[AuthController::class, 'register1'])->name('register1');
Route::post('register2',[AuthController::class, 'register2'])->name('register2');
Route::post('register3',[AuthController::class, 'register3'])->name('register3');
Route::post('login', [AuthController::class, 'login'])->name('authenticate');

Route::middleware(['auth:sanctum','check.permission',config('jetstream.auth_session'),'verified'])
->group(function () {
    Route::get('/check-permission',[checkpermission::class,'check']);

    
    Route::get('/dashboard', function () {
        $lk_count = LembagaKonservasi::count();
        $species_count = ListSpecies::count();
        $skoleksi_count = Satwa::where('status_satwa','satwa koleksi')->count();
        $stitipan_count = Satwa::where('status_satwa','satwa titipan')->count();
        $sbelumtag_count = Tagging::where('jenis_tagging','belum ditagging')->count();
        $shidup_count = Satwa::where('jenis_koleksi','satwa hidup')->count();
        return view('dashboard', compact('lk_count', 'species_count', 'skoleksi_count', 'stitipan_count', 'sbelumtag_count', 'shidup_count'));
    })->name('dashboard');
    
    
    Route::get('/permission', function(){
        return view('permission');
    })->name('permission');
    
    Route::resource('lembaga-konservasi', LembagaKonservasiController::class);
    Route::resource('satwa', SatwaController::class);
    Route::post('/lembaga-konservasi/import',[LembagaKonservasi::class])->name('import-lk');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/get-satwa',[SatwaController::class,'getall']);
    Route::get('/get-lembaga-konservasi',[LembagaKonservasiController::class,'getall']);
});

Route::get('/get-wilayah-upt',[AuthController::class,'getWilayahUPT']);

//undefined route 
// Route::any('/{page}', function () {
//     return View::make()
// });
