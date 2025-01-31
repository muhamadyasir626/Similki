<?php

namespace App\Http\Controllers;

use App\Models\Satwa;
use App\Models\Tagging;
use App\Models\ListSpecies;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use App\Models\ListUpt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class DashboardController extends Controller
{
    // public function index(){
    //     $role = Auth::user()->role->tag;
    //     switch($role){
    //         case'KKHSG':
    //             //filter 
    //             $lks = LembagaKonservasi::with('upt')->select('id','nama')->get();
    //             $upts = ListUpt::distinct()->select('id','wilayah')->get();
    //             $classes = ListSpecies::distinct()->select('class')->get();


    //             //statis
    //             // $lk_count = LembagaKonservasi::count();
    //             // $species_count = ListSpecies::count();
    //             // $skoleksi_count = Satwa::where('status_satwa','satwa koleksi')->count();
    //             // $stitipan_count = Satwa::where('status_satwa','satwa titipan')->count();
    //             // $sbelumtag_count = Tagging::where('jenis_tagging','belum ditagging')->count();
    //             // $shidup_count = Satwa::where('jenis_koleksi','satwa hidup')->count();
    //             // $taksa = ListSpecies::select('spesies')->count();

    //             $lk_count = LembagaKonservasi::select('id')->get(); //diubah jd select id sm nama upt / slug 
    //             $species_count = ListSpecies::distinct()->select('spesies')->get(); //ini jg ambil id sm nama
    //             // dd($species_count);
    //             $skoleksi_count = Satwa::where('status_satwa','satwa koleksi')->select('id')->get(); //id sm id upt sm id lk 
    //             // dd($skoleksi_count); 
    //             $stitipan_count = Satwa::where('status_satwa','satwa titipan')->select('id', 'id_lk')->get();
    //             // dd($stitipan_count);
    //             $sbelumtag_count = Tagging::where('jenis_tagging','belum ditagging')->select('id', 'id_satwa')->get();
    //             // dd($sbelumtag_count);
    //             $shidup_count = Satwa::where('jenis_koleksi','satwa hidup')->select('id', 'id_lk')->get();
    //             // dd($shidup_count);
    //             $taksa = ListSpecies::distinct()->select('class')->get();
    //             // dd($taksa);


    //             //data chart Bentuk lembaga konservasi
    //             $lastUpdateBentukLk = LembagaKonservasi::max('updated_at');
    //             $cacheKeyBentukLk = 'label_bentukLk' . $lastUpdateBentukLk;
    //             $label_bentukLk = Cache::remember($cacheKeyBentukLk, 0, function () {
    //                 return LembagaKonservasi::select('id', 'bentuk_lk')
    //                     ->get()
    //                     ->groupBy('bentuk_lk')
    //                     ->map(function ($item, $key) {
    //                         return ['total' => $item->count(), 'label' => $key];
    //                     });
    //             });
    //             $total_bentukLk = $label_bentukLk->pluck('total', 'label');
                
    //             $lastUpdateWilayahLk= LembagaKonservasi::max('updated_at');
    //             $cacheKeyWilayahLk = 'label_wilayahLk' . $lastUpdateWilayahLk;
    //             $label_wilayahLk = Cache::remember($cacheKeyWilayahLk, 0, function () {
    //                 return LembagaKonservasi::with(['upt' => function ($query) {
    //                         $query->select('id', 'wilayah');
    //                     }])->select('id', 'id_upt')
    //                     ->get()
    //                     ->groupBy('id_upt')
    //                     ->map(function ($item, $id_upt) {
    //                         return ['total' => $item->count(), 'label' => optional($item->first()->upt)->wilayah];
    //                     });
    //             });
    //             $total_wilayahLk = $label_wilayahLk->pluck('total', 'label');
                
    //             $lastUpdateJenisKoleksi= Satwa::max('updated_at');
    //             $cacheKeyJenisKoleksi = 'label_jenisKoleksi' . $lastUpdateJenisKoleksi;
    //             $label_jenisKoleksi = Cache::remember($cacheKeyJenisKoleksi, 0, function () {
    //                 return Satwa::select('id', 'jenis_koleksi')
    //                     ->get()
    //                     ->groupBy('jenis_koleksi')
    //                     ->map(function ($item, $key) {
    //                         return ['total' => $item->count(), 'label' => $key];
    //                     });
    //             });
    //             $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');
                
    //             $lastUpdateClass= listSpecies::max('updated_at');
    //             $cacheKeyClass = 'label_class' . $lastUpdateClass;
    //             $label_class = Cache::remember($cacheKeyClass, 0, function () {
    //                 return ListSpecies::select('id', 'class')->get()
    //                     ->groupBy('class')
    //                     ->map(function ($item, $key) {
    //                         return ['total' => $item->count(), 'label' => strtolower($key)];
    //                     });
    //             });
    //             $total_class = $label_class->pluck('total', 'label');

    //             $lastUpdateJumlahIndvSpecies= listSpecies::max('updated_at');
    //             $cacheKeyJumlahIndvSpecies = 'label_JumlahIndvSpesies' . $lastUpdateJumlahIndvSpecies;
    //             $label_jumlahIndvSpesies = Cache::remember($cacheKeyJumlahIndvSpecies, 0, function () {
    //                 return Satwa::with(['species' => function($query) {
    //                                 $query->select('id', 'nama_ilmiah');
    //                             }])
                                
    //                             ->select('id', 'id_spesies')  
    //                             ->get()
    //                             ->groupBy('id_spesies')
    //                             ->map(function($item, $id_spesies){
    //                                 $nama_ilmiah = optional($item->first()->species)->nama_ilmiah;
    //                                 if(is_null($nama_ilmiah) || empty($nama_ilmiah)){
    //                                     $nama_ilmiah = 'Spesies belum diketahui';
    //                                 }
    //                                 return [
    //                                     'total' => $item->count(),
    //                                     'label' => $nama_ilmiah
    //                                 ];
    //                             })
    //                             ->sortByDesc('total') 
    //                             ->take(10); 
    //             });
    //             $total_jumlahIndvSpesies = $label_jumlahIndvSpesies->pluck('total', 'label');
                
    //             $lastUpdateTagging= listSpecies::max('updated_at');
    //             $cacheKeyTagging = 'label_Tagging' . $lastUpdateTagging;
    //             $label_tagging = Cache::remember($cacheKeyTagging, 0, function () {
    //                 return Tagging::select('id', 'jenis_tagging')->get()
    //                     ->groupBy('jenis_tagging')
    //                     ->map(function ($item, $key) {
    //                         if (empty($key)) {
    //                             $key = 'belum ditagging';
    //                         }
    //                         return [
    //                             'total' => $item->count(),
    //                             'label' => strtolower($key)
    //                         ];
    //                     });
    //             });
    //             $total_tagging = $label_tagging->pluck('total', 'label');
                
    //             $lastUpdateTaksa= listSpecies::max('updated_at');
    //             $cacheKeyTaksa = 'label_Taksa' . $lastUpdateTaksa;
    //             $label_taksa = Cache::remember($cacheKeyTaksa, 0, function () {
    //                 return Satwa::with(['species' => function($query) {
    //                                 $query->select('id', 'class');
    //                             }])
    //                             ->select('id', 'id_spesies')
    //                             ->get()
    //                             ->groupBy('id_spesies')
    //                             ->map(function ($item, $id_spesies) {
    //                                 $class = optional($item->first()->species)->class;
    //                                 if (empty($class)) {
    //                                     $class = 'Class satwa belum Diketahui';
    //                                 }
    //                                 return [
    //                                     'total' => $item->count(),
    //                                     'label' => $class
    //                                 ];
    //                             });
    //             });
    //             $total_taksa = $label_taksa->pluck('total', 'label');
                
    //             $lastUpdatejenis_koleksi= Satwa::max('updated_at');
    //             $cacheKeyjenis_koleksi = 'label_jenis_koleksi' . $lastUpdatejenis_koleksi;
    //             $label_jenis_koleksi = Cache::remember($cacheKeyJenisKoleksi, 0, function () {
    //                 return Satwa::select('id', 'jenis_koleksi')->get()
    //                     ->groupBy('jenis_koleksi')
    //                     ->map(function ($item, $key) {
    //                         if (empty($key)) {
    //                             $key = 'belum diketahui';
    //                         }
    //                         return [
    //                             'total' => $item->count(),
    //                             'label' => strtolower($key)
    //                         ];
    //                     });
    //             });
    //             $total_jenis_koleksi = $label_jenis_koleksi->pluck('total', 'label');

    //             return view('dashboard', compact(
    //                 'lk_count', 'species_count', 'skoleksi_count', 
    //                 'stitipan_count', 'sbelumtag_count', 'shidup_count',
    //                 'total_bentukLk', 'taksa', 'total_wilayahLk',
    //                 'total_jumlahIndvSpesies', 'total_tagging',
    //                 'total_taksa','total_jenis_koleksi', 'lks',
    //                 'classes','upts',
    //             ));
    //         case'LK':
    //             $lk = Auth::user()->lk->id;
    //             $bentuk_lk = LembagaKonservasi::where('id', $lk)->value('bentuk_lk');
    //             $species_count = Satwa::where('id_lk', $lk)->count();
    //             $skoleksi_count = Satwa::where('id_lk', $lk)->where('status_satwa', 'satwa koleksi')->count();
    //             $stitipan_count = Satwa::where('id_lk', $lk)->where('status_satwa', 'satwa titipan')->count();
    //             $sbelumtag_count = Tagging::whereHas('satwa', function ($query) use ($lk) {
    //                 $query->where('id_lk', $lk);
    //             })->where('jenis_tagging', 'belum ditagging')->count();
    //             $shidup_count = Satwa::where('id_lk', $lk)->where('jenis_koleksi', 'satwa hidup')->count();
    //             $satwa = Satwa::with(['species:id,nama_ilmiah,class,spesies', 'lk:id,id_upt,nama','lk.upt:id,wilayah'])
    //                 ->select('id', 'id_lk', 'status_satwa', 'jenis_koleksi', 'id_spesies', 'asal_satwa')
    //                 ->where('id_lk', $lk) 
    //                 ->get();
    //             $tagging = Tagging::select('id','id_satwa','jenis_tagging')->get();
    //             $pengelola = LembagaKonservasi::where('id',$lk)->select('pengelola')->first();
    //             // return response()->json([
    //             //     'status' => 'success',
    //             //     'satwa' => $satwa,
    //             //     'tagging' => $tagging,
    //             //     'pengelola' => $pengelola,
    //             //     // 'count_lk' => $count_lk,
    //             // ]);

    //             //data chart - total jumlah species individu
    //             $label_jenisKoleksi = Cache::remember('label_jenisKoleksi', 0, function () use ($lk) {
    //                 return Satwa::select('id', 'jenis_koleksi')
    //                     ->where('id_lk',$lk)
    //                     ->get()
    //                     ->groupBy('jenis_koleksi')
    //                     ->map(function ($item, $key) {
    //                         return ['total' => $item->count(), 'label' => $key];
    //                     });
    //             });
    //             $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');
    //             // dd($total_jenisKoleksi);
                
    //             $label_class = Cache::remember('label_class_' . $lk, 0, function () use ($lk) {
    //                 // Ambil semua data satwa berdasarkan id_lk
    //                 return Satwa::whereHas('species', function ($query) use ($lk) {
    //                         $query->where('id_lk', $lk);
    //                     })
    //                     ->with('species:id,class') // Pastikan membawa atribut "class" dari relasi species
    //                     ->get()
    //                     ->groupBy(function ($item) {
    //                         return strtolower($item->species->class ?: 'unknown'); // Gunakan 'unknown' jika kelas tidak ada
    //                     })
    //                     ->map(function ($items, $class) {
    //                         return [
    //                             'total' => $items->count(),
    //                             'label' => $class,
    //                         ];
    //                     });
    //             });
                
                
    //             $total_class = $label_class->pluck('total', 'label');
    //             // dd($label_class->toArray()); // Lihat struktur data

                
    //             // dd($total_class);
                
                
    //             $label_tagging = Cache::remember('label_tagging_' . $lk, 0, function () use ($lk) {
    //                 return Tagging::whereHas('satwa', function ($query) use ($lk) {
    //                     $query->where('id_lk', $lk);
    //                 })
    //                 ->select('id', 'jenis_tagging')  
    //                 ->get()  
    //                 ->groupBy('jenis_tagging')  
    //                 ->map(function ($item, $key) {
    //                     if (empty($key)) {
    //                         $key = 'belum ditagging';
    //                     }
    //                     return [
    //                         'total' => $item->count(),
    //                         'label' => strtolower($key),
    //                     ];
    //                 });
    //             });
    //             $total_tagging = $label_tagging->pluck('total', 'label');
                
    //             // dd($total_tagging);

    //             $label_jenis_koleksi = Cache::remember('label_jenis_koleksi', 0, function () use($lk) {
    //                 return Satwa::select('id', 'jenis_koleksi')                            
    //                     ->where('id_lk',$lk)
    //                     ->get()
    //                     ->groupBy('jenis_koleksi')
    //                     ->map(function ($item, $key) {
    //                         if (empty($key)) {
    //                             $key = 'belum diketahui';
    //                         }
    //                         return [
    //                             'total' => $item->count(),
    //                             'label' => strtolower($key)
    //                         ];
    //                     });
    //             });
    //             $total_jenis_koleksi = $label_jenis_koleksi->pluck('total', 'label');

    //             $label_jumlahIndvSpesies = Cache::remember('label_jumlahIndvSpesies', 60*60, function () use($lk) {
    //                 return Satwa::with(['species' => function($query) {
    //                                 $query->select('id', 'nama_ilmiah');
    //                             }])
    //                             ->where('id_lk', $lk)
    //                             ->select('id', 'id_spesies')  
    //                             ->get()
    //                             ->groupBy('id_spesies')
    //                             ->map(function($item, $id_spesies){
    //                                 $nama_ilmiah = optional($item->first()->species)->nama_ilmiah;
    //                                 if(is_null($nama_ilmiah) || empty($nama_ilmiah)){
    //                                     $nama_ilmiah = 'Spesies belum diketahui';
    //                                 }
    //                                 return [
    //                                     'total' => $item->count(),
    //                                     'label' => $nama_ilmiah
    //                                 ];
    //                             })
    //                             ->sortByDesc('total') 
    //                             ->take(10); 
    //             });
    //             $total_jumlahIndvSpesies = $label_jumlahIndvSpesies->pluck('total', 'label');
    //             // dd($total_jumlahIndvSpesies);
    //             return view('dashboard-lk',compact(
    //                 'bentuk_lk', 'species_count', 'skoleksi_count', 
    //                 'stitipan_count', 'sbelumtag_count', 'shidup_count', 
    //                 'satwa', 'tagging', 'pengelola','total_jumlahIndvSpesies', 
    //                 'total_class', 'total_tagging', 'total_jenis_koleksi'
    //         ));
    //         case'DRH':
    //         case'UPT':
    //             $upt = Auth::user()->upt->id;
    //                 $lk_count = LembagaKonservasi::where('id_upt', $upt)->count();
    //                 // $bentuk_lk = LembagaKonservasi::where('id', $upt)->value('bentuk_lk');
    //                 $species_count = Satwa::whereHas('lk', function ($query) use ($upt) {
    //                     // Mengambil data LembagaKonservasi yang terkait dengan UPT
    //                     $query->whereHas('upt', function ($query) use ($upt) {
    //                         $query->where('id', $upt); // Pastikan $upt adalah ID UPT yang ingin dicari
    //                     });
    //                 })->count();
    //                 $skoleksi_count = Satwa::whereHas('lk')
    //                                 ->where('status_satwa', 'satwa koleksi')
    //                                 ->whereHas('lk', function ($query) use ($upt) {
    //                                     // Mengambil data LembagaKonservasi yang terkait dengan UPT
    //                                     $query->whereHas('upt', function ($query) use ($upt) {
    //                                         $query->where('id', $upt); // Pastikan $upt adalah ID UPT yang ingin dicari
    //                                     });
    //                                 })
    //                                 ->count();
    //                 $stitipan_count = Satwa::whereHas('lk')
    //                                 ->where('status_satwa', 'satwa titipan')
    //                                 ->whereHas('lk', function ($query) use ($upt) {
    //                                     // Mengambil data LembagaKonservasi yang terkait dengan UPT
    //                                     $query->whereHas('upt', function ($query) use ($upt) {
    //                                         $query->where('id', $upt); // Pastikan $upt adalah ID UPT yang ingin dicari
    //                                     });
    //                                 })
    //                                 ->count();
                    
    //                 $sbelumtag_count = Tagging::whereHas('satwa.lk.upt', function ($query) use ($upt) {
    //                     // Memastikan bahwa UPT terkait dengan LembagaKonservasi (LK) yang memiliki ID $upt
    //                     $query->where('id', $upt); 
    //                 })
    //                 ->where('jenis_tagging', 'belum ditagging') // Pastikan jenis tagging adalah 'belum ditagging'
    //                 ->count();
                                                                   
    //                 $shidup_count = Satwa::whereHas('lk')
    //                                 ->where('jenis_koleksi', 'satwa hidup')
    //                                 ->whereHas('lk', function ($query) use ($upt) {
    //                                     $query->whereHas('upt', function ($query) use ($upt) {
    //                                         $query->where('id', $upt);
    //                                     });
    //                                 })
    //                                 ->count();
    //                 // $satwa = Satwa::with(['species:id,nama_ilmiah,class,spesies', 'lk:id,id_upt,nama','lk.upt:id,wilayah'])
    //                 //     ->select('id', 'id_lk', 'status_satwa', 'jenis_koleksi', 'id_spesies', 'asal_satwa')
    //                 //     ->where('id_lk', $lk) 
    //                 //     ->get();
    //                 // $tagging = Tagging::select('id','id_satwa','jenis_tagging')->get();
    //                 // $pengelola = LembagaKonservasi::where('id',$lk)->select('pengelola')->first();
    //                 // // return response()->json([
    //                 // //     'status' => 'success',
    //                 // //     'satwa' => $satwa,
    //                 // //     'tagging' => $tagging,
    //                 // //     'pengelola' => $pengelola,
    //                 // //     // 'count_lk' => $count_lk,
    //                 // // ]);

    //                 //data chart Bentuk lembaga konservasi
    //                 $label_bentukLk = Cache::remember('label_bentukLk_' . $upt, 0, function () use ($upt) {
    //                     return LembagaKonservasi::whereHas('upt', function ($query) use ($upt) {
    //                         // Pastikan hanya mengambil Lembaga Konservasi yang berelasi dengan UPT yang sesuai
    //                         $query->where('id', $upt);
    //                     })
    //                     ->select('id', 'bentuk_lk') // Pilih hanya id dan bentuk_lk
    //                     ->get()
    //                     ->groupBy('bentuk_lk') // Kelompokkan berdasarkan bentuk_lk
    //                     ->map(function ($item, $key) {
    //                         // Hitung jumlah lembaga konservasi per bentuk LK
    //                         return ['total' => $item->count(), 'label' => $key];
    //                     });
    //                 });
                    
    //                 // Mengambil jumlah total berdasarkan bentuk LK
    //                 $total_bentukLk = $label_bentukLk->pluck('total', 'label');

                    
                    
                    

    //                 // //data chart - total jumlah species individu
    //                 // $label_jenisKoleksi = Cache::remember('label_jenisKoleksi', 0, function () use ($lk) {
    //                 //     return Satwa::select('id', 'jenis_koleksi')
    //                 //         ->where('id_lk',$lk)
    //                 //         ->get()
    //                 //         ->groupBy('jenis_koleksi')
    //                 //         ->map(function ($item, $key) {
    //                 //             return ['total' => $item->count(), 'label' => $key];
    //                 //         });
    //                 // });
    //                 // $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');
    //                 // // dd($total_jenisKoleksi);
                    
    //                 $label_class = Cache::remember('label_class_' . $upt, 0, function () use ($upt) {
    //                     // Pastikan $upt sudah terdefinisi sebelumnya dan gunakan ID UPT untuk query
    //                     return Satwa::whereHas('lk', function ($query) use ($upt) {
    //                         // Pastikan Satwa terkait dengan Lembaga Konservasi yang terkait dengan UPT
    //                         $query->whereHas('upt', function ($query) use ($upt) {
    //                             // Ambil data Lembaga Konservasi yang terkait dengan UPT
    //                             $query->where('id', $upt);
    //                         });
    //                     })
    //                     ->with('species:id,class') // Mengambil atribut "class" dari relasi species
    //                     ->get()
    //                     ->groupBy(function ($item) {
    //                         // Kelompokkan berdasarkan class species, jika tidak ada class, beri label 'unknown'
    //                         return strtolower($item->species->class ?: 'unknown');
    //                     })
    //                     ->map(function ($items, $class) {
    //                         // Hitung jumlah satwa per kelas dan buat labelnya
    //                         return [
    //                             'total' => $items->count(),
    //                             'label' => $class,
    //                         ];
    //                     });
    //                 });

    //                 $total_class = $label_class->pluck('total', 'label');

    //                 $label_jumlahIndvSpesies = Cache::remember('label_jumlahIndvSpesies', 60*60, function () use ($upt) {
    //                     return Satwa::whereHas('lk.upt', function ($query) use ($upt) {
    //                                         $query->where('id', $upt); // Filter berdasarkan ID UPT
    //                                     })
    //                                     ->with(['species' => function ($query) {
    //                                         $query->select('id', 'nama_ilmiah');
    //                                     }])
    //                                     ->select('id', 'id_spesies')  
    //                                     ->get()
    //                                     ->groupBy('id_spesies')
    //                                     ->map(function ($item, $id_spesies) {
    //                                         $nama_ilmiah = optional($item->first()->species)->nama_ilmiah;
    //                                         if (is_null($nama_ilmiah) || empty($nama_ilmiah)) {
    //                                             $nama_ilmiah = 'Spesies belum diketahui';
    //                                         }
    //                                         return [
    //                                             'total' => $item->count(),
    //                                             'label' => $nama_ilmiah
    //                                         ];
    //                                     })
    //                                     ->sortByDesc('total')
    //                                     ->take(10); 
    //                 });
    //                 $total_jumlahIndvSpesies = $label_jumlahIndvSpesies->pluck('total', 'label');
                    
                    
    //                 // $label_tagging = Cache::remember('label_tagging_' . $lk, 0, function () use ($lk) {
    //                 //     return Tagging::whereHas('satwa', function ($query) use ($lk) {
    //                 //         // Filter satwa berdasarkan id_lk
    //                 //         $query->where('id_lk', $lk);
    //                 //     })
    //                 //     ->select('id', 'jenis_tagging')  // Ambil hanya kolom yang diperlukan dari Tagging
    //                 //     ->get()  // Ambil data Tagging
    //                 //     ->groupBy('jenis_tagging')  // Kelompokkan berdasarkan jenis_tagging
    //                 //     ->map(function ($item, $key) {
    //                 //         // Jika jenis_tagging kosong, beri label default
    //                 //         if (empty($key)) {
    //                 //             $key = 'belum ditagging';
    //                 //         }
    //                 //         // Kembalikan total dan label
    //                 //         return [
    //                 //             'total' => $item->count(),
    //                 //             'label' => strtolower($key),
    //                 //         ];
    //                 //     });
    //                 // });
    //                 // $total_tagging = $label_tagging->pluck('total', 'label');
                    
    //                 // // dd($total_tagging);

    //                 // $label_jenis_koleksi = Cache::remember('label_jenis_koleksi', 0, function () use($lk) {
    //                 //     return Satwa::select('id', 'jenis_koleksi')                            
    //                 //         ->where('id_lk',$lk)
    //                 //         ->get()
    //                 //         ->groupBy('jenis_koleksi')
    //                 //         ->map(function ($item, $key) {
    //                 //             if (empty($key)) {
    //                 //                 $key = 'belum diketahui';
    //                 //             }
    //                 //             return [
    //                 //                 'total' => $item->count(),
    //                 //                 'label' => strtolower($key)
    //                 //             ];
    //                 //         });
    //                 // });
    //                 // $total_jenis_koleksi = $label_jenis_koleksi->pluck('total', 'label');

    //                 return view('dashboard-upt',compact(
    //                     'lk_count', 'species_count', 'skoleksi_count',
    //                     'stitipan_count', 'sbelumtag_count', 'shidup_count',
    //                     'total_class', 'total_bentukLk', 'total_jumlahIndvSpesies'
    //             ));
    //         case'SB':
    //         case'SK':
    //         default:
           
            
    //     }
        
        
        
    // }
    // public function filterData(Request $request)
    // {
        
    // }

    public function index(){
        
        $role = Auth::user()->role->tag;
        switch($role){
            case'KKHSG':
                $lks = LembagaKonservasi::with('upt')->select('id','nama')->get();
                $upts = ListUpt::distinct()->select('id','wilayah')->get();
                $classes = ListSpecies::distinct()->select('class')->get();

                //filter database
                $satwa = Satwa::select('id','id_spesies','id_lk','status_satwa','jenis_koleksi', 'asal_satwa')->get();
                // $satwas = Satwa::with('lk')->select('id','id_spesies','id_lk','status_satwa','jenis_koleksi', 'asal_satwa')->get();
                $tag = Tagging::select('id_satwa','jenis_tagging')->get();

                //statis
                $lk_count = LembagaKonservasi::count();
                $species_count = ListSpecies::count();
                $skoleksi_count = Satwa::where('status_satwa','satwa koleksi')->count();
                $stitipan_count = Satwa::where('status_satwa','satwa titipan')->count();
                $sbelumtag_count = Tagging::where('jenis_tagging','belum ditagging')->count();
                $shidup_count = Satwa::where('jenis_koleksi','satwa hidup')->count();
                $taksa = ListSpecies::select('spesies')->count();
                $endemik_count = Satwa::where('asal_satwa', 'endemik')->count();
                $eksotik_count = Satwa::where('asal_satwa', 'eksotik')->count();

                // $lk_count = LembagaKonservasi::select('id')->get(); //diubah jd select id sm nama upt / slug 
                // $species_count = ListSpecies::distinct()->select('id','spesies')->get(); //ini jg ambil id sm nama
                // // dd($species_count);
                // $skoleksi_count = Satwa::where('status_satwa','satwa koleksi')->select('id','id_lk','id_spesies')->get(); //id sm id upt sm id lk 
                // // dd($skoleksi_count); 
                // $stitipan_count = Satwa::where('status_satwa','satwa titipan')->select('id', 'id_lk','id_spesies')->get();
                // // dd($stitipan_count);
                // $sbelumtag_count = Tagging::where('jenis_tagging','belum ditagging')->select('id', 'id_satwa')->get();
                // // dd($sbelumtag_count);
                // $shidup_count = Satwa::where('jenis_koleksi','satwa hidup')->select('id', 'id_lk','id_spesies')->get();
                // // dd($shidup_count);
                // $taksa = ListSpecies::distinct()->select('class')->get();
                // // dd($taksa);


                //data chart Bentuk lembaga konservasi
                $label_bentukLk = Cache::remember('label_bentukLk', 0, function () {
                    return LembagaKonservasi::select('id', 'bentuk_lk')
                        ->get()
                        ->groupBy('bentuk_lk')
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => $key];
                        });
                });
                $total_bentukLk = $label_bentukLk->pluck('total', 'label');
                
                $label_wilayahLk = Cache::remember('label_wilayahLk', 0, function () {
                    return LembagaKonservasi::with(['upt' => function ($query) {
                            $query->select('id', 'wilayah');
                        }])->select('id', 'id_upt')
                        ->get()
                        ->groupBy('id_upt')
                        ->map(function ($item, $id_upt) {
                            return ['total' => $item->count(), 'label' => optional($item->first()->upt)->wilayah];
                        });
                });
                $total_wilayahLk = $label_wilayahLk->pluck('total', 'label');
                
                $label_jenisKoleksi = Cache::remember('label_jenisKoleksi', 0, function () {
                    return Satwa::select('id', 'jenis_koleksi')
                        ->get()
                        ->groupBy('jenis_koleksi')
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => $key];
                        });
                });
                $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');
                
                $label_class = Cache::remember('label_class_kkhsg', 0, function () {
                    // Ambil semua data satwa tanpa perantara LK, langsung berdasarkan class dari species
                    return Satwa::with('species:id,class') // Pastikan membawa atribut "class" dari relasi species
                                ->get()
                                ->groupBy(function ($item) {
                                    // Kategorikan berdasarkan class dari species, gunakan 'unknown' jika class kosong
                                    return strtolower($item->species->class ?: 'unknown');
                                })
                                ->map(function ($items, $class) {
                                    return [
                                        'total' => $items->count(),
                                        'label' => $class,
                                    ];
                                });
                });
             
                $total_class = $label_class->pluck('total', 'label');
                // dd($total_class);
                
                
                $label_jumlahIndvSpesies = Cache::remember('label_jumlahIndvSpesies', 0, function () {
                    return Satwa::with(['species' => function($query) {
                                    $query->select('id', 'nama_ilmiah');
                                }])
                                ->select('id', 'id_spesies')  
                                ->get()
                                ->groupBy('id_spesies')
                                ->map(function($item, $id_spesies){
                                    $nama_ilmiah = optional($item->first()->species)->nama_ilmiah;
                                    if(is_null($nama_ilmiah) || empty($nama_ilmiah)){
                                        $nama_ilmiah = 'Spesies belum diketahui';
                                    }
                                    return [
                                        'total' => $item->count(),
                                        'label' => $nama_ilmiah
                                    ];
                                })
                                ->sortByDesc('total') 
                                ->take(10); 
                });
                $total_jumlahIndvSpesies = $label_jumlahIndvSpesies->pluck('total', 'label');
                
                $label_tagging = Cache::remember('label_tagging_kkhsg', 0, function () {
                    return Tagging::with('satwa') 
                        ->select('id', 'jenis_tagging') 
                        ->get()  
                        ->groupBy(function ($item) {
                            $key = strtolower($item->jenis_tagging);
                            if (empty($key)) {
                                $key = 'belum ditagging';
                            }
                            return $key;
                        })  
                        ->map(function ($item, $key) {
                            return [
                                'total' => $item->count(),
                                'label' => $key,  
                            ];
                        });
                });
                
                $total_tagging = $label_tagging->pluck('total', 'label');                
                // dd($total_tagging);
                             
                $label_jenis_koleksi = Cache::remember('label_jenis_koleksi', 0, function () {
                    return Satwa::select('id', 'jenis_koleksi')->get()
                        ->groupBy('jenis_koleksi')
                        ->map(function ($item, $key) {
                            if (empty($key)) {
                                $key = 'belum diketahui';
                            }
                            return [
                                'total' => $item->count(),
                                'label' => strtolower($key)
                            ];
                        });
                });
                $total_jenis_koleksi = $label_jenis_koleksi->pluck('total', 'label');
                
                
                return view('dashboard', compact(
                    'lk_count', 'species_count', 'skoleksi_count', 
                    'stitipan_count', 'sbelumtag_count', 'shidup_count',
                    'total_bentukLk', 'taksa', 'total_wilayahLk',
                    'total_jumlahIndvSpesies', 'total_tagging',
                    'total_jenis_koleksi', 'total_class', 'lks', 'upts', 'classes',
                    'satwa', 'endemik_count', 'eksotik_count', 'tag'
                                ));
                
                case'LK':
                $lk = Auth::user()->lk->id;
                    $bentuk_lk = LembagaKonservasi::where('id', $lk)->value('bentuk_lk');
                    $species_count = Satwa::where('id_lk', $lk)->count();
                    $skoleksi_count = Satwa::where('id_lk', $lk)->where('status_satwa', 'satwa koleksi')->count();
                    $stitipan_count = Satwa::where('id_lk', $lk)->where('status_satwa', 'satwa titipan')->count();
                    $sbelumtag_count = Tagging::whereHas('satwa', function ($query) use ($lk) {
                        $query->where('id_lk', $lk);
                    })->where('jenis_tagging', 'belum ditagging')->count();
                    $shidup_count = Satwa::where('id_lk', $lk)->where('jenis_koleksi', 'satwa hidup')->count();
                    $satwa = Satwa::with(['species:id,nama_ilmiah,class,spesies', 'lk:id,id_upt,nama','lk.upt:id,wilayah'])
                        ->select('id', 'id_lk', 'status_satwa', 'jenis_koleksi', 'id_spesies', 'asal_satwa')
                        ->where('id_lk', $lk) 
                        ->get();
                    $tagging = Tagging::select('id','id_satwa','jenis_tagging')->get();
                    $pengelola = LembagaKonservasi::where('id',$lk)->select('pengelola')->first();
                    // return response()->json([
                    //     'status' => 'success',
                    //     'satwa' => $satwa,
                    //     'tagging' => $tagging,
                    //     'pengelola' => $pengelola,
                    //     // 'count_lk' => $count_lk,
                    // ]);

                    //data chart - total jumlah species individu
                    $label_jenisKoleksi = Cache::remember('label_jenisKoleksi', 0, function () use ($lk) {
                        return Satwa::select('id', 'jenis_koleksi')
                            ->where('id_lk',$lk)
                            ->get()
                            ->groupBy('jenis_koleksi')
                            ->map(function ($item, $key) {
                                return ['total' => $item->count(), 'label' => $key];
                            });
                    });
                    $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');
                    // dd($total_jenisKoleksi);
                    
                    $label_class = Cache::remember('label_class_' . $lk, 0, function () use ($lk) {
                        // Ambil semua data satwa berdasarkan id_lk
                        return Satwa::whereHas('species', function ($query) use ($lk) {
                                $query->where('id_lk', $lk);
                            })
                            ->with('species:id,class') // Pastikan membawa atribut "class" dari relasi species
                            ->get()
                            ->groupBy(function ($item) {
                                return strtolower($item->species->class ?: 'unknown'); // Gunakan 'unknown' jika kelas tidak ada
                            })
                            ->map(function ($items, $class) {
                                return [
                                    'total' => $items->count(),
                                    'label' => $class,
                                ];
                            });
                    });
                    
                    
                    $total_class = $label_class->pluck('total', 'label');
                    // dd($label_class->toArray()); // Lihat struktur data

                    
                    // dd($total_class);
                    
                    
                    $label_tagging = Cache::remember('label_tagging_' . $lk, 0, function () use ($lk) {
                        return Tagging::whereHas('satwa', function ($query) use ($lk) {
                            $query->where('id_lk', $lk);
                        })
                        ->select('id', 'jenis_tagging')  
                        ->get()  
                        ->groupBy('jenis_tagging')  
                        ->map(function ($item, $key) {
                            if (empty($key)) {
                                $key = 'belum ditagging';
                            }
                            return [
                                'total' => $item->count(),
                                'label' => strtolower($key),
                            ];
                        });
                    });
                    $total_tagging = $label_tagging->pluck('total', 'label');
                    
                    // dd($total_tagging);

                    $label_jenis_koleksi = Cache::remember('label_jenis_koleksi', 0, function () use($lk) {
                        return Satwa::select('id', 'jenis_koleksi')                            
                            ->where('id_lk',$lk)
                            ->get()
                            ->groupBy('jenis_koleksi')
                            ->map(function ($item, $key) {
                                if (empty($key)) {
                                    $key = 'belum diketahui';
                                }
                                return [
                                    'total' => $item->count(),
                                    'label' => strtolower($key)
                                ];
                            });
                    });
                    $total_jenis_koleksi = $label_jenis_koleksi->pluck('total', 'label');

                    $label_jumlahIndvSpesies = Cache::remember('label_jumlahIndvSpesies', 60*60, function () use($lk) {
                        return Satwa::with(['species' => function($query) {
                                        $query->select('id', 'nama_ilmiah');
                                    }])
                                    ->where('id_lk', $lk)
                                    ->select('id', 'id_spesies')  
                                    ->get()
                                    ->groupBy('id_spesies')
                                    ->map(function($item, $id_spesies){
                                        $nama_ilmiah = optional($item->first()->species)->nama_ilmiah;
                                        if(is_null($nama_ilmiah) || empty($nama_ilmiah)){
                                            $nama_ilmiah = 'Spesies belum diketahui';
                                        }
                                        return [
                                            'total' => $item->count(),
                                            'label' => $nama_ilmiah
                                        ];
                                    })
                                    ->sortByDesc('total') 
                                    ->take(10); 
                    });
                    $total_jumlahIndvSpesies = $label_jumlahIndvSpesies->pluck('total', 'label');
                    // dd($total_jumlahIndvSpesies);
                    return view('dashboard-lk',compact(
                        'bentuk_lk', 'species_count', 'skoleksi_count', 
                        'stitipan_count', 'sbelumtag_count', 'shidup_count', 
                        'satwa', 'tagging', 'pengelola','total_jumlahIndvSpesies', 
                        'total_class', 'total_tagging', 'total_jenis_koleksi'
                ));
            case'DRH':
            case'UPT':
                $upt = Auth::user()->upt->id;
                    $lk_count = LembagaKonservasi::where('id_upt', $upt)->count();
                    // $bentuk_lk = LembagaKonservasi::where('id', $upt)->value('bentuk_lk');
                    $species_count = Satwa::whereHas('lk', function ($query) use ($upt) {
                        // Mengambil data LembagaKonservasi yang terkait dengan UPT
                        $query->whereHas('upt', function ($query) use ($upt) {
                            $query->where('id', $upt); // Pastikan $upt adalah ID UPT yang ingin dicari
                        });
                    })->count();
                    $skoleksi_count = Satwa::whereHas('lk')
                                    ->where('status_satwa', 'satwa koleksi')
                                    ->whereHas('lk', function ($query) use ($upt) {
                                        // Mengambil data LembagaKonservasi yang terkait dengan UPT
                                        $query->whereHas('upt', function ($query) use ($upt) {
                                            $query->where('id', $upt); // Pastikan $upt adalah ID UPT yang ingin dicari
                                        });
                                    })
                                    ->count();
                    $stitipan_count = Satwa::whereHas('lk')
                                    ->where('status_satwa', 'satwa titipan')
                                    ->whereHas('lk', function ($query) use ($upt) {
                                        // Mengambil data LembagaKonservasi yang terkait dengan UPT
                                        $query->whereHas('upt', function ($query) use ($upt) {
                                            $query->where('id', $upt); // Pastikan $upt adalah ID UPT yang ingin dicari
                                        });
                                    })
                                    ->count();
                    
                    $sbelumtag_count = Tagging::whereHas('satwa.lk.upt', function ($query) use ($upt) {
                        // Memastikan bahwa UPT terkait dengan LembagaKonservasi (LK) yang memiliki ID $upt
                        $query->where('id', $upt); 
                    })
                    ->where('jenis_tagging', 'belum ditagging') // Pastikan jenis tagging adalah 'belum ditagging'
                    ->count();
                                                                   
                    $shidup_count = Satwa::whereHas('lk')
                                    ->where('jenis_koleksi', 'satwa hidup')
                                    ->whereHas('lk', function ($query) use ($upt) {
                                        $query->whereHas('upt', function ($query) use ($upt) {
                                            $query->where('id', $upt);
                                        });
                                    })
                                    ->count();
                    // $satwa = Satwa::with(['species:id,nama_ilmiah,class,spesies', 'lk:id,id_upt,nama','lk.upt:id,wilayah'])
                    //     ->select('id', 'id_lk', 'status_satwa', 'jenis_koleksi', 'id_spesies', 'asal_satwa')
                    //     ->where('id_lk', $lk) 
                    //     ->get();
                    // $tagging = Tagging::select('id','id_satwa','jenis_tagging')->get();
                    // $pengelola = LembagaKonservasi::where('id',$lk)->select('pengelola')->first();
                    // // return response()->json([
                    // //     'status' => 'success',
                    // //     'satwa' => $satwa,
                    // //     'tagging' => $tagging,
                    // //     'pengelola' => $pengelola,
                    // //     // 'count_lk' => $count_lk,
                    // // ]);

                    //data chart Bentuk lembaga konservasi
                    $label_bentukLk = Cache::remember('label_bentukLk_' . $upt, 0, function () use ($upt) {
                        return LembagaKonservasi::whereHas('upt', function ($query) use ($upt) {
                            // Pastikan hanya mengambil Lembaga Konservasi yang berelasi dengan UPT yang sesuai
                            $query->where('id', $upt);
                        })
                        ->select('id', 'bentuk_lk') // Pilih hanya id dan bentuk_lk
                        ->get()
                        ->groupBy('bentuk_lk') // Kelompokkan berdasarkan bentuk_lk
                        ->map(function ($item, $key) {
                            // Hitung jumlah lembaga konservasi per bentuk LK
                            return ['total' => $item->count(), 'label' => $key];
                        });
                    });
                    
                    // Mengambil jumlah total berdasarkan bentuk LK
                    $total_bentukLk = $label_bentukLk->pluck('total', 'label');

                    
                    
                    

                    // //data chart - total jumlah species individu
                    // $label_jenisKoleksi = Cache::remember('label_jenisKoleksi', 0, function () use ($lk) {
                    //     return Satwa::select('id', 'jenis_koleksi')
                    //         ->where('id_lk',$lk)
                    //         ->get()
                    //         ->groupBy('jenis_koleksi')
                    //         ->map(function ($item, $key) {
                    //             return ['total' => $item->count(), 'label' => $key];
                    //         });
                    // });
                    // $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');
                    // // dd($total_jenisKoleksi);
                    
                    $label_class = Cache::remember('label_class_' . $upt, 0, function () use ($upt) {
                        // Pastikan $upt sudah terdefinisi sebelumnya dan gunakan ID UPT untuk query
                        return Satwa::whereHas('lk', function ($query) use ($upt) {
                            // Pastikan Satwa terkait dengan Lembaga Konservasi yang terkait dengan UPT
                            $query->whereHas('upt', function ($query) use ($upt) {
                                // Ambil data Lembaga Konservasi yang terkait dengan UPT
                                $query->where('id', $upt);
                            });
                        })
                        ->with('species:id,class') // Mengambil atribut "class" dari relasi species
                        ->get()
                        ->groupBy(function ($item) {
                            // Kelompokkan berdasarkan class species, jika tidak ada class, beri label 'unknown'
                            return strtolower($item->species->class ?: 'unknown');
                        })
                        ->map(function ($items, $class) {
                            // Hitung jumlah satwa per kelas dan buat labelnya
                            return [
                                'total' => $items->count(),
                                'label' => $class,
                            ];
                        });
                    });

                    $total_class = $label_class->pluck('total', 'label');

                    $label_jumlahIndvSpesies = Cache::remember('label_jumlahIndvSpesies', 60*60, function () use ($upt) {
                        return Satwa::whereHas('lk.upt', function ($query) use ($upt) {
                                            $query->where('id', $upt); // Filter berdasarkan ID UPT
                                        })
                                        ->with(['species' => function ($query) {
                                            $query->select('id', 'nama_ilmiah');
                                        }])
                                        ->select('id', 'id_spesies')  
                                        ->get()
                                        ->groupBy('id_spesies')
                                        ->map(function ($item, $id_spesies) {
                                            $nama_ilmiah = optional($item->first()->species)->nama_ilmiah;
                                            if (is_null($nama_ilmiah) || empty($nama_ilmiah)) {
                                                $nama_ilmiah = 'Spesies belum diketahui';
                                            }
                                            return [
                                                'total' => $item->count(),
                                                'label' => $nama_ilmiah
                                            ];
                                        })
                                        ->sortByDesc('total')
                                        ->take(10); 
                    });
                    $total_jumlahIndvSpesies = $label_jumlahIndvSpesies->pluck('total', 'label');
                    
                    
                    // $label_tagging = Cache::remember('label_tagging_' . $lk, 0, function () use ($lk) {
                    //     return Tagging::whereHas('satwa', function ($query) use ($lk) {
                    //         // Filter satwa berdasarkan id_lk
                    //         $query->where('id_lk', $lk);
                    //     })
                    //     ->select('id', 'jenis_tagging')  // Ambil hanya kolom yang diperlukan dari Tagging
                    //     ->get()  // Ambil data Tagging
                    //     ->groupBy('jenis_tagging')  // Kelompokkan berdasarkan jenis_tagging
                    //     ->map(function ($item, $key) {
                    //         // Jika jenis_tagging kosong, beri label default
                    //         if (empty($key)) {
                    //             $key = 'belum ditagging';
                    //         }
                    //         // Kembalikan total dan label
                    //         return [
                    //             'total' => $item->count(),
                    //             'label' => strtolower($key),
                    //         ];
                    //     });
                    // });
                    // $total_tagging = $label_tagging->pluck('total', 'label');
                    
                    // // dd($total_tagging);

                    // $label_jenis_koleksi = Cache::remember('label_jenis_koleksi', 0, function () use($lk) {
                    //     return Satwa::select('id', 'jenis_koleksi')                            
                    //         ->where('id_lk',$lk)
                    //         ->get()
                    //         ->groupBy('jenis_koleksi')
                    //         ->map(function ($item, $key) {
                    //             if (empty($key)) {
                    //                 $key = 'belum diketahui';
                    //             }
                    //             return [
                    //                 'total' => $item->count(),
                    //                 'label' => strtolower($key)
                    //             ];
                    //         });
                    // });
                    // $total_jenis_koleksi = $label_jenis_koleksi->pluck('total', 'label');

                    return view('dashboard-upt',compact(
                        'lk_count', 'species_count', 'skoleksi_count',
                        'stitipan_count', 'sbelumtag_count', 'shidup_count',
                        'total_class', 'total_bentukLk', 'total_jumlahIndvSpesies'
                ));
            case'SB':
            case'SK':
            default:
            
        }
        
        
        
    }
    public function updateData()
    {
        
    }

    public function filterClass(Request $request, $lk)
    {
        try {
            $query = Satwa::with('species:id, class');
            
            if($lk) {
                $query->where('id_lk', $lk);
            }

            $filter_class = Cache::remember('filter_class', $lk, 60, function () use($query) {
                return $query->get()
                            ->pluck('species.class')
                            ->map(function ($class) {
                                return strtolower(trim($class));
                            })
                            ->unique()
                            ->filter()
                            ->values();
            });
            
            return view('sidebar', (compact('filter_class'))); // Pastikan response dalam format JSON
            
        } catch (\Exception $e) {
            // Menangani error dan memberi response yang sesuai
            return response()->json(['error' => 'Data tidak ditemukan', 'message' => $e->getMessage()], 500);
        }
    }
}
