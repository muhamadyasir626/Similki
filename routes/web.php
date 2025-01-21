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
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BKSDAController;

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
    
    Route::get('/lembaga-konservasi/import',[LembagaKonservasiController::class,'viewImport'])->name('import-lk');
    Route::get('/lembaga-konservasi/export',[LembagaKonservasiController::class,'viewExport'])->name('export-lk');

    // Route::get('/get-preview-data', [SatwaController::class, 'getPreviewData']);
    // Route::post('/export-data', [SatwaController::class, 'exportData']);

    Route::post('/lembaga-konservasi/import',[LembagaKonservasi::class]);
    Route::resource('lembaga-konservasi', LembagaKonservasiController::class);
    Route::get('/monitoring',[LembagaKonservasiController::class,'monitoring'])->name('monitoring-lk');

    
    Route::resource('satwa', SatwaController::class);
    Route::get('/pendataan-satwa', [SatwaController::class,'form'])->name('form-satwa');
    Route::post('/satwa/pendataan1',[SatwaController::class, 'pendataan1'])->name('pendataan-satwa1');
    Route::post('/satwa/pendataan2',[SatwaController::class, 'pendataan2'])->name('pendataan-satwa2');
    Route::post('/satwa/pendataan3',[SatwaController::class, 'pendataan3'])->name('pendataan-satwa3');
    Route::get('/search',[SatwaController::class,'search'])->name('satwa-search');
    Route::post('/satwas', [SatwaController::class, 'store'])->name('satwa.store'); 
    Route::get('/pendataan-satwa-titipan', [SatwaController::class, 'pendataanSatwaTitipan'])->name('pendataan-satwa-titipan');
    Route::post('/daftar-satwa-titipan', [SatwaController::class, 'storeSatwaTitipan'])->name('store-satwa-titipan');
    Route::get('/daftar-satwa-titipan', [SatwaController::class, 'daftarSatwaTitipan'])->name('daftar-satwa-titipan');
    Route::get('/satwa-titipan', [SatwaController::class, 'showSatwaTitipan'])->name('satwa.index');
    // Route::post('/pendataan-satwa-koleksi', [SatwaController::class, 'storeSatwaKoleksi'])->name('pendataan-satwa-koleksi.store');

    // Route::post('/satwas/store', [SatwaController::class, 'store'])->name('satwa.store');
    

    Route::get('/permission', function(){
        return view('permission');
    })->name('permission');
    Route::get('/verifikasi-akun',[AuthController::class,'index'])->name('verifikasi-akun');
    Route::post('/updated-permission/id={id}',[AuthController::class,'updatePermission'])->name('updated-permission');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log');


});

Route::get('/get-wilayah-upt',[AuthController::class,'getWilayahUPT']);
Route::get('/filter-class', [DashboardController::class, 'filterClass'])->name('dashboard.filter-class');
Route::get('/get-jenis-tagging', [SatwaController::class, 'getJenisTagging']);
// Route::get('/get-takson-satwa', [ListSpeciesController::class, 'getTaksonSatwa']);
Route::get('/get-takson-satwa', [ListSpeciesController::class, 'getTaksonSatwa'])->name('getTaksonSatwa');


//undefined route 
// Route::any('/{page}', function () {
//     return View::make()
// });

Route::group(['prefix' => 'forms'], function(){
    Route::get('data_lk', function () { return view('pages.forms.data_lk'); });
    Route::get('input-investasi', function () { return view('pages.forms.input-investasi'); });
    Route::get('input-lk', function () { return view('pages.forms.input-lk'); });
    Route::get('monitoring-investasi', function () { return view('pages.forms.monitoring-investasi'); });
    Route::get('pendataan-satwa', function () { return view('pages.forms.pendataan-satwa'); });
});

Route::get('/persetujuan-rkp', [BksdaController::class, 'index'])->name('persetujuan-rkp');
Route::get('/daftar-persetujuan-rkp', [BksdaController::class, 'show'])->name('daftar-persetujuan-rkp');
Route::get('/detail-verifikasi-rkp', [BksdaController::class, 'verifikasiRKP'])->name('detail-verifikasi-rkp');