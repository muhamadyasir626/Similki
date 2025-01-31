<?php


use App\Models\SatwaTitipan;
use App\Models\LembagaKonservasi;
use App\Models\MonitoringInvestasi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SatwaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\ListSpeciesController;
use App\Http\Controllers\SatwaTitipanController;
use App\Http\Controllers\BarangKonservasiController;
use App\Http\Controllers\LembagaKonservasiController;
use App\Http\Controllers\MonitoringInvestasiController;
use App\Http\Controllers\SatwaKoleksiIndividuController;
use App\Http\Controllers\SatwaPerolehanController;
use App\Models\BarangKonservasi;
use App\Models\SatwaPerolehan;

Route::middleware(['checkAuth'])->group(function () {
    Route::get('/', [AuthController::class,'viewLogin'])->name('signin');
    Route::get('/register',[AuthController::class,'viewRegister'])->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    
});

Route::middleware(['auth:sanctum','check.permission',config('jetstream.auth_session'),'verified'])
->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    
    // Route::middleware(['role:KKHSG'])->group(function(){
    //     #Lembaga konservasi
    //     Route::get('/search-lk',[LembagaKonservasiController::class,'search'])->name('lk-search');
    //     Route::resource('lk', LembagaKonservasiController::class)->only(['index','edit']);
    //     Route::get('/daftar-pengajuan-lk', [LembagaKonservasiController::class, 'submission'])->name('daftar-pengajuan-lk');
    //     Route::get('/detail-pengajuan-lk/{id}', [LembagaKonservasiController::class, 'detailSubmission'])->name('detail-pengajuan-lk');

    //     #Barang Konservasi 
    //     Route::resource('barang-konservasi', BarangKonservasiController::class)->parameters(['barang-konservasi' => 'id'])->except('store')->only(['index']);
    //     Route::get('daftar-pengajuan-barang-konservasi', [BarangKonservasiController::class,'submission'])->name('daftar-pengajuan-barang');

    //     #verifikasi 
    //     Route::resource('verifikasi', VerifikasiController::class)->parameters(['verifikasi' => 'id']);

    //     #ttipan
    //     Route::resource('satwa-titipan',SatwaTitipanController::class)->parameters(['satwa-titipan'=>'id'])->only(['index']);

    //     #koleksi individu
    //     Route::resource('satwa-koleksi', SatwaKoleksiIndividuController::class)->parameters(['satwa-koleksi' => 'id'])->only(['index']);
    //     Route::get('/search/koleksi-individu', [SatwaKoleksiIndividuController::class , 'search'])->name('search-koleksi-individu');
        
    //     #Perolehan
    //     Route::get('/search-satwa-perolehan', [SatwaPerolehanController::class, 'search'])->name('search-satwa-perolehan');
    //     Route::resource('satwa-perolehan', SatwaPerolehanController::class)->parameters(['satwa-perolehan'=>'id'])->only(['index']);
    //     Route::get('/daftar-pengajuan-satwa-perolehan', [SatwaPerolehanController::class, 'submission'])->name('daftar-pengajuan-satwa-perolehan');
    //     Route::get('/detail-pengajuan-satwa-perolehan/{id}', [SatwaPerolehanController::class, 'detailsubmission'])->name('detail-pengajuan-satwa-perolehan');
    
        
    //     #pengaturan
    //     Route::get('/verification-account',[AuthController::class,'index'])->name('verifikasi-akun');

    // });

    Route::resource('lembaga-konservasi', LembagaKonservasiController::class);
    
    Route::get('/get-satwa', [SatwaController::class, 'updateDashboard']);
    Route::get('/get-lembaga-konservasi', [LembagaKonservasiController::class, 'getall']);
    Route::get('/get-spesies', [ListSpeciesController::class, 'index']);
    
    Route::get('/satwa/form-genealogy',[SatwaController::class,'viewSilsilah'])->name('viewSilsilah');
    Route::get('/satwa/search',[SatwaController::class,'search'])->name('satwa-search');
    
    
    Route::get('/permission',[AuthController::class,'viewPermission'])->name('permission');
    Route::get('/verification-account',[AuthController::class,'index'])->name('verifikasi-akun');
    // Route::post('/updated-permission/{id}',[AuthController::class,'updatePermission'])->name('updated-permission');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('satwa', SatwaController::class)->parameters(['satwa' => 'id']);
    
    //lk
    Route::resource('lk', LembagaKonservasiController::class)->parameters(['lk' => 'id']);
    Route::get('/daftar-pengajuan-lk', [LembagaKonservasiController::class, 'submission'])->name('daftar-pengajuan-lk');
    Route::get('/detail-pengajuan-lk/{id}/{status}', [LembagaKonservasiController::class, 'detailSubmission'])->name('detail-pengajuan-lk');
    Route::get('/search',[LembagaKonservasiController::class,'search'])->name('lk-search');
    
    // Koleksi
    Route::resource('satwa-koleksi', SatwaKoleksiIndividuController::class)->parameters(['satwa-koleksi' => 'id']);
    Route::get('/search/koleksi-individu', [SatwaKoleksiIndividuController::class , 'search'])->name('search-koleksi-individu');
    
    //titipan
    Route::resource('satwa-titipan',SatwaTitipanController::class)->parameters(['satwa-titipan'=>'id']);
    Route::get('/search-satwa-titipan', [SatwaTitipanController::class, 'search'])->name('search-satwa-titipan');
    
    //verifikasi
    Route::resource('verifikasi', VerifikasiController::class)->parameters(['verifikasi' => 'id']);
    // Route::post('/verifikasi-lk',[VerifikasiController::class,'verifikasi'])->name('verifikasi');
    
    //barang konservasi
    Route::resource('barang-konservasi', BarangKonservasiController::class)->parameters(['barang-konservasi' => 'id'])->except('store');
    Route::post('barang-konservasi/{id}', [BarangKonservasiController::class,'store'])->name('barang-konservasi.store');
    Route::get('daftar-pengajuan-barang-konservasi', [BarangKonservasiController::class,'submission'])->name('daftar-pengajuan-barang');
    Route::get('/detail-pengajuan-barang/{id}/{status}', [BarangKonservasiController::class, 'detailSubmission'])->name('detail-pengajuan-barang');

    //satwa perolehan
    Route::resource('satwa-perolehan', SatwaPerolehanController::class)->parameters(['satwa-perolehan'=>'id']);
    Route::get('/daftar-pengajuan-satwa-perolehan', [SatwaPerolehanController::class, 'submission'])->name('daftar-pengajuan-satwa-perolehan');
    Route::get('/detail-pengajuan-satwa-perolehan/{id}', [SatwaPerolehanController::class, 'detailsubmission'])->name('detail-pengajuan-satwa-perolehan');
    Route::get('/search-satwa-perolehan', [SatwaPerolehanController::class, 'search'])->name('search-satwa-perolehan');
    Route::post('/delete-document', [SatwaPerolehanController::class,'deleteDocument'])->name('delete-document');
});


