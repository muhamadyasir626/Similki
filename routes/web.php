<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\ListLk;
use App\Models\ListSpecies;
use App\Models\ListUpt;

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



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/get-wilayah-upt',[AuthController::class,'getWilayahUPT']);


Route::get('/register', function () {
    $roles = Role::all();
    $upt_bentuk = ListUpt::distinct()->select('bentuk')->get();
    $upt_wilayah = ListUpt::distinct()->select('wilayah')->get();
    $list_lk = ListLk::orderBy('name','asc')->get();
    $list_species =ListSpecies::all();

    // dd($upt_bentuk);
    return view('auth.register',compact('roles','upt_bentuk','upt_wilayah','list_lk','list_species'));
});

Route::post('register1',[AuthController::class, 'register1'])->name('register1');
Route::post('register2',[AuthController::class, 'register2'])->name('register2');
Route::post('register3',[AuthController::class, 'register3'])->name('register3');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () {
    // dd(Auth::User());
        return view('dashboard');
    })->name('dashboard');
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//     // dd(Auth::User());
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::group(['prefix' => 'forms'], function(){
    Route::get('basic-elements', function () { return view('pages.forms.basic-elements'); });
    Route::get('data_lk', function () { return view('pages.forms.data_lk'); });
    Route::get('wizard', function () { return view('pages.forms.wizard'); });
    Route::get('input-investasi', function () { return view('pages.forms.input-investasi'); });
    Route::get('monitoring-investasi', function () { return view('pages.forms.monitoring-investasi'); });
    Route::get('input-lk', function () { return view('pages.forms.input-lk'); });

});

Route::group(['prefix' => 'tables'], function(){
    Route::get('data-table', function () { return view('pages.tables.data-table'); });
});