<?php

use App\Models\Role;
use App\Models\ListUpt;
use App\Models\ListSpecies;
use App\Models\LembagaKonservasi;
use App\Models\Satwa;
use App\Models\Tagging;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckPermission;
use App\Http\Controllers\LembagaKonservasiController;
use App\Http\Controllers\SatwaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

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

// Authentication Routes
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    $roles = Role::all();
    $upt_bentuk = ListUpt::distinct()->select('bentuk')->get();
    $upt_wilayah = ListUpt::distinct()->select('wilayah')->get();
    $list_lk = LembagaKonservasi::orderBy('nama', 'asc')->get();
    $list_species = ListSpecies::all();

    return view('auth.register', compact('roles', 'upt_bentuk', 'upt_wilayah', 'list_lk', 'list_species'));
});

Route::post('register1', [AuthController::class, 'register1'])->name('register1');
Route::post('register2', [AuthController::class, 'register2'])->name('register2');
Route::post('register3', [AuthController::class, 'register3'])->name('register3');
Route::post('login', [AuthController::class, 'login'])->name('authenticate');

// Protected Routes (Requires Authentication)
Route::middleware(['auth:sanctum', 'check.permission', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        // Dashboard KKH
        // Route::get('/dashboard', function () {
        //     $lk_count = LembagaKonservasi::count();
        //     $species_count = ListSpecies::count();
        //     $skoleksi_count = Satwa::where('status_satwa', 'satwa koleksi')->count();
        //     $stitipan_count = Satwa::where('status_satwa', 'satwa titipan')->count();
        //     $sbelumtag_count = Tagging::where('jenis_tagging', 'belum ditagging')->count();
        //     $shidup_count = Satwa::where('jenis_koleksi', 'satwa hidup')->count();
            
        //     return view('dashboard', compact('lk_count', 'species_count', 'skoleksi_count', 'stitipan_count', 'sbelumtag_count', 'shidup_count'));
        // })->name('dashboard');

        // Dashboard UPT

        // Dashboard LK

        Route::get('/dashboard', function () {
            $lk = Auth::user()->lk->id;
            // dd(Auth::user());
            $species_count = Satwa::where('id_lk', $lk)->count();
            $skoleksi_count = Satwa::where('id_lk', $lk)->where('status_satwa', 'satwa koleksi')->count();
            $stitipan_count = Satwa::where('id_lk', $lk)->where('status_satwa', 'satwa titipan')->count();
            $sbelumtag_count = Tagging::whereHas('satwa', function ($query) use ($lk) {
                $query->where('id_lk', $lk);
            })->where('jenis_tagging', 'belum ditagging')->count();
            $shidup_count = Satwa::where('id_lk', $lk)->where('jenis_koleksi', 'satwa hidup')->count();
            $bentuk_lk = LembagaKonservasi::where('id', $lk)->value('bentuk_lk');
            $satwaLK = Satwa::whereHas('lk', function ($query) use ($lk){
                $query->where('id_lk',$lk);
            })->where('id_lk', $lk)->get();

            // dd($satwaLK);
            $satwaLK = Satwa::where('id_lk', $lk)
                        ->select('id_spesies as spesies', DB::raw('COUNT(*) as jumlah'))
                        ->groupBy('spesies')
                        ->get();
            return view('dashboard', compact( 'species_count', 'skoleksi_count', 'stitipan_count', 'sbelumtag_count', 'shidup_count', 'bentuk_lk', 'satwaLK'));
            // return view('dashboard');
        })->name('dashboard');


        Route::get('/get-data/{role}', [DashboardController::class, 'getData']);
       

        // $id_lembaga = auth()->user()->id_lk;
        
        // Route::get('/dashboard', function () {
        //     $lk_count = LembagaKonservasi::where('id', $id_lembaga)->count();
        //     $species_count = ListSpecies::where('id_lk', $id_lembaga)->count();
        //     $stitipan_count = Satwa::where('id_lk', $id_lembaga)->where('status_satwa', 'satwa titipan')->count();
        //     $sbelumtag_count = Tagging::where('id_lk', $id_lembaga)->where('jenis_tagging', 'belum ditagging')->count();
        //     $shidup_count = Satwa::where('id_lk', $id_lembaga)->where('jenis_koleksi', 'satwa hidup')->count();
        //     return view('dashboard', compact('lk_count', 'species_count', 'skoleksi_count', 'stitipan_count', 'sbelumtag_count', 'shidup_count'));
        // })->name('dashboard');
            



        // Permission Routes
        Route::get('/check-permission', [CheckPermission::class, 'check']);
        Route::get('/permission', function () {
            return view('permission');
        })->name('permission');
        Route::get('/verifikasi-akun', [AuthController::class, 'index'])->name('verifikasi-akun');
        Route::post('/updated-permission/id={id}', [AuthController::class, 'updatePermission'])->name('updated-permission');

        // Lembaga Konservasi Routes
        Route::resource('lembaga-konservasi', LembagaKonservasiController::class);
        Route::post('/lembaga-konservasi/import', [LembagaKonservasiController::class, 'import'])->name('import-lk');
        Route::get('/monitoring', [LembagaKonservasiController::class, 'monitoring'])->name('monitoring-lk');
        
        // Satwa Routes
        Route::resource('satwa', SatwaController::class);
        Route::get('/pendataan-satwa', [SatwaController::class, 'form'])->name('form-satwa');
        Route::post('/satwa/pendataan1', [SatwaController::class, 'pendataan1'])->name('pendataan-satwa1');
        Route::post('/satwa/pendataan2', [SatwaController::class, 'pendataan2'])->name('pendataan-satwa2');
        Route::get('/search', [SatwaController::class, 'search'])->name('satwa-search');
        
        // Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

// API Data Fetching
Route::get('/get-satwa', [SatwaController::class, 'getall']);
Route::get('/get-lembaga-konservasi', [LembagaKonservasiController::class, 'getall']);
Route::get('/get-wilayah-upt', [AuthController::class, 'getWilayahUPT']);