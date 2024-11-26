<?php

namespace App\Http\Controllers;

use App\Models\Satwa;
use App\Models\Tagging;
use App\Models\ListSpecies;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class DashboardController extends Controller
{
    public function index(){
        $role = Auth::user()->role->tag;
        switch($role){
            case'KKHSG':
                //statis
                $lk_count = LembagaKonservasi::count();
                $species_count = ListSpecies::count();
                $skoleksi_count = Satwa::where('status_satwa','satwa koleksi')->count();
                $stitipan_count = Satwa::where('status_satwa','satwa titipan')->count();
                $sbelumtag_count = Tagging::where('jenis_tagging','belum ditagging')->count();
                $shidup_count = Satwa::where('jenis_koleksi','satwa hidup')->count();
                $taksa = ListSpecies::select('spesies')->count();

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
                
                $label_class = Cache::remember('label_class', 0, function () {
                    return ListSpecies::select('id', 'class')->get()
                        ->groupBy('class')
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => strtolower($key)];
                        });
                });
                $total_class = $label_class->pluck('total', 'label');
                
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
                
                $label_tagging = Cache::remember('label_tagging', 0, function () {
                    return Tagging::select('id', 'jenis_tagging')->get()
                        ->groupBy('jenis_tagging')
                        ->map(function ($item, $key) {
                            if (empty($key)) {
                                $key = 'belum ditagging';
                            }
                            return [
                                'total' => $item->count(),
                                'label' => strtolower($key)
                            ];
                        });
                });
                $total_tagging = $label_tagging->pluck('total', 'label');
                
                $label_taksa = Cache::remember('label_taksa', 0, function () {
                    return Satwa::with(['species' => function($query) {
                                    $query->select('id', 'class');
                                }])
                                ->select('id', 'id_spesies')
                                ->get()
                                ->groupBy('id_spesies')
                                ->map(function ($item, $id_spesies) {
                                    $class = optional($item->first()->species)->class;
                                    if (empty($class)) {
                                        $class = 'Class satwa belum Diketahui';
                                    }
                                    return [
                                        'total' => $item->count(),
                                        'label' => $class
                                    ];
                                });
                });
                $total_taksa = $label_taksa->pluck('total', 'label');
                
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
                    'total_taksa','total_jenis_koleksi'
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
                        return Satwa::whereHas('species', function ($query) use ($lk) {
                            // Filter data ListSpecies berdasarkan id_lk satwa
                            $query->where('id_lk', $lk);
                        })
                        ->select('id', 'class')  // Pilih hanya kolom id dan class
                        ->get()
                        ->groupBy('class')  // Kelompokkan berdasarkan class
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => strtolower($key)];
                        });
                    });
                    
                    $total_class = $label_class->pluck('total', 'label');
                    
                    dd($total_class);
                    
                    
                    $label_tagging = Cache::remember('label_tagging_' . $lk, 0, function () use ($lk) {
                        return Tagging::whereHas('satwa', function ($query) use ($lk) {
                            // Filter satwa berdasarkan id_lk
                            $query->where('id_lk', $lk);
                        })
                        ->select('id', 'jenis_tagging')  // Ambil hanya kolom yang diperlukan dari Tagging
                        ->get()  // Ambil data Tagging
                        ->groupBy('jenis_tagging')  // Kelompokkan berdasarkan jenis_tagging
                        ->map(function ($item, $key) {
                            // Jika jenis_tagging kosong, beri label default
                            if (empty($key)) {
                                $key = 'belum ditagging';
                            }
                            // Kembalikan total dan label
                            return [
                                'total' => $item->count(),
                                'label' => strtolower($key),
                            ];
                        });
                    });
                    $total_tagging = $label_tagging->pluck('total', 'label');
                    
                    // dd($total_tagging);

                    $label_taksa = Cache::remember('label_taksa', 0, function () use($lk) {
                        return Satwa::with(['species' => function($query) {
                                        $query->select('id', 'class');
                                    }])
                                    ->where('id_lk',$lk)
                                    ->select('id', 'id_spesies')
                                    ->get()
                                    ->groupBy('id_spesies')
                                    ->map(function ($item, $id_spesies) {
                                        $class = optional($item->first()->species)->class;
                                        if (empty($class)) {
                                            $class = 'Class satwa belum Diketahui';
                                        }
                                        return [
                                            'total' => $item->count(),
                                            'label' => $class
                                        ];
                                    });
                    });
                    $total_taksa = $label_taksa->pluck('total', 'label');
                    // dd($total_taksa);

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
                        'total_class', 'total_tagging', 'total_taksa','total_jenis_koleksi'
                ));
            case'DRH':
            case'UPT':
            case'SB':
            case'SK':
            default:
            
        }
        
        
        
    }
    public function updateData()
    {
        
    }
}