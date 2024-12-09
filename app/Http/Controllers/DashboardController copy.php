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
use Illuminate\Support\Facades\Log;  // Impor Log dengan benar


class DashboardController extends Controller
{
    public function index(Request $request){
        $role = Auth::user()->role->tag;
        switch($role){
            case'KKHSG':
                //filter 
                $lks = LembagaKonservasi::with('upt')->select('id','nama')->get();
                $upts = ListUpt::distinct()->select('id','wilayah')->get();
                $classes = ListSpecies::distinct()->select('class')->get();

                // dd($classes);

                $lksFilter = $request->input('lks', []); // Menangkap filter Lembaga Konservasi
                $uptsFilter = $request->input('upts', []); // Menangkap filter UPT
                $classesFilter = $request->input('classes', []); // Menangkap filter Class
                Log::info('Request data:', $request->all());

                //statis
                $lk_count = LembagaKonservasi::count(); //diubah jd select id sm nama upt / slug 
                $species_count = ListSpecies::count(); //ini jg ambil id sm nama
                $skoleksi_count = Satwa::where('status_satwa','satwa koleksi')->count(); //id sm id upt sm id lk 
                $stitipan_count = Satwa::where('status_satwa','satwa titipan')->count();
                $sbelumtag_count = Tagging::where('jenis_tagging','belum ditagging')->count();
                $shidup_count = Satwa::where('jenis_koleksi','satwa hidup')->count();
                $taksa = ListSpecies::select('spesies')->count();

                //data chart Bentuk lembaga konservasi
                $lastUpdateBentukLk = LembagaKonservasi::max('updated_at');
                $cacheKeyBentukLk = 'label_bentukLk' . $lastUpdateBentukLk;
                $label_bentukLk = Cache::remember($cacheKeyBentukLk, 0, function () use ($lksFilter) {
                    $query = LembagaKonservasi::select('id', 'bentuk_lk');
                    
                    // Cek jika filter tersedia, jika ada filter berdasarkan 'id', jika tidak, tampilkan semua data
                    if (!empty($lksFilter)) {
                        $query->whereIn('id', $lksFilter);
                    }

                    return $query->get()
                        ->groupBy('bentuk_lk')
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => $key];
                        });
                });
                $total_bentukLk = $label_bentukLk->pluck('total', 'label');

                $lastUpdateWilayahLk = LembagaKonservasi::max('updated_at');
                $cacheKeyWilayahLk = 'label_wilayahLk' . $lastUpdateWilayahLk;
                $label_wilayahLk = Cache::remember($cacheKeyWilayahLk, 0, function () use ($lksFilter) {
                    $query = LembagaKonservasi::with(['upt' => function ($query) {
                            $query->select('id', 'wilayah');
                        }])
                        ->select('id', 'id_upt');

                    // Cek jika filter tersedia, jika ada filter berdasarkan 'id', jika tidak, tampilkan semua data
                    if (!empty($lksFilter)) {
                        $query->whereIn('id', $lksFilter);
                    }

                    return $query->get()
                        ->groupBy('id_upt')
                        ->map(function ($item, $id_upt) {
                            return ['total' => $item->count(), 'label' => optional($item->first()->upt)->wilayah];
                        });
                });
                $total_wilayahLk = $label_wilayahLk->pluck('total', 'label');

                
                $lastUpdateJenisKoleksi = Satwa::max('updated_at');
                $cacheKeyJenisKoleksi = 'label_jenisKoleksi' . $lastUpdateJenisKoleksi;
                $label_jenisKoleksi = Cache::remember($cacheKeyJenisKoleksi, 0, function () use ($lksFilter) {
                    return Satwa::select('id', 'jenis_koleksi')
                        ->when($lksFilter, function ($query) use ($lksFilter) {
                            return $query->whereIn('id_lk', $lksFilter);  // Filter berdasarkan id_lk
                        })
                        ->get()
                        ->groupBy('jenis_koleksi')
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => strtolower($key)];
                        });
                });
                $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');

                
                // $lastUpdateClass = ListSpecies::max('updated_at');
                // $cacheKeyClass = 'label_class' . $lastUpdateClass;
                // $label_class = Cache::remember($cacheKeyClass, 0, function () use ($lksFilter) {
                //     return ListSpecies::select('id', 'class')
                //         ->whereHas('satwa', function ($query) use ($lksFilter) {
                //             $query->whereIn('id_lk', $lksFilter);  // Filter berdasarkan id_lk yang ada di tabel satwa
                //         })
                //         ->get()
                //         ->groupBy('class')
                //         ->map(function ($item, $key) {
                //             return ['total' => $item->count(), 'label' => strtolower($key)];
                //         });
                // });
                // $total_class = $label_class->pluck('total', 'label');

                $lastUpdateClass = Satwa::max('updated_at');
                $cacheKeyClass = 'label_class' . $lastUpdateClass;
                $label_class = Cache::remember($cacheKeyClass, 0, function () use ($lksFilter) {
                    $query = Satwa::with('species:id,class');
                
                    // Cek jika filter ada, jika tidak, tampilkan semua data
                    if (!empty($lksFilter)) {
                        $query->whereHas('lk', function ($query) use ($lksFilter) {
                            $query->whereIn('id', $lksFilter); // Filter berdasarkan id LK
                        });
                    }
                
                    return $query->get()
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
                


                $lastUpdateJumlahIndvSpecies = ListSpecies::max('updated_at');
                $cacheKeyJumlahIndvSpecies = 'label_JumlahIndvSpesies' . $lastUpdateJumlahIndvSpecies;
                $label_jumlahIndvSpesies = Cache::remember($cacheKeyJumlahIndvSpecies, 0, function () use ($lksFilter) {
                    return Satwa::with(['species' => function ($query) {
                        $query->select('id', 'nama_ilmiah');
                    }])
                    ->select('id', 'id_spesies')
                    ->when($lksFilter, function ($query) use ($lksFilter) {
                        return $query->whereIn('id_lk', $lksFilter);  // Filter berdasarkan id_lk
                    })
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

                
                $lastUpdateTagging = ListSpecies::max('updated_at');
                $cacheKeyTagging = 'label_tagging_' . ($lksFilter ? implode('_', $lksFilter) : 'all') . '_' . $lastUpdateTagging;

                $label_tagging = Cache::remember($cacheKeyTagging, 0, function () use ($lksFilter) {
                    return Tagging::select('id', 'jenis_tagging')
                        ->when($lksFilter, function ($query) use ($lksFilter) {
                            // Terapkan filter hanya jika $lksFilter tidak kosong
                            $query->whereHas('satwa', function ($satwaQuery) use ($lksFilter) {
                                $satwaQuery->whereIn('id_lk', $lksFilter); // Filter berdasarkan id_lk melalui relasi satwa
                            });
                        })
                        ->get()
                        ->groupBy(function ($item) {
                            // Tangani jika `jenis_tagging` kosong atau null
                            return strtolower($item->jenis_tagging ?: 'belum ditagging');
                        })
                        ->map(function ($item, $key) {
                            return [
                                'total' => $item->count(),
                                'label' => $key,
                            ];
                        });
                });

                $total_tagging = $label_tagging->pluck('total', 'label');
                
                $lastUpdateTaksa= listSpecies::max('updated_at');
                $cacheKeyTaksa = 'label_Taksa' . $lastUpdateTaksa;
                $label_taksa = Cache::remember($cacheKeyTaksa, 0, function () {
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
                
                $lastUpdateJenisKoleksi = Satwa::max('updated_at');
                $cacheKeyJenisKoleksi = 'label_jenis_koleksi_' . ($lksFilter ? implode('_', $lksFilter) : 'all') . '_' . $lastUpdateJenisKoleksi;

                $label_jenis_koleksi = Cache::remember($cacheKeyJenisKoleksi, 0, function () use ($lksFilter) {
                    return Satwa::select('id', 'jenis_koleksi')
                        ->when($lksFilter, function ($query) use ($lksFilter) {
                            // Terapkan filter jika $lksFilter tidak kosong
                            $query->whereHas('lk', function ($subQuery) use ($lksFilter) {
                                $subQuery->whereIn('id', $lksFilter); // Filter berdasarkan id LK
                            });
                        })
                        ->get()
                        ->groupBy(function ($item) {
                            // Tangani jika `jenis_koleksi` kosong atau null
                            return strtolower($item->jenis_koleksi ?: 'belum diketahui');
                        })
                        ->map(function ($items, $key) {
                            return [
                                'total' => $items->count(),
                                'label' => $key,
                            ];
                        });
                });

                // Ambil hasil total untuk grafik
                $total_jenis_koleksi = $label_jenis_koleksi->pluck('total', 'label');


                 // Tangkap filter dari request
        



            // Filter Lembaga Konservasi
            $lks = LembagaKonservasi::with('upt')->select('id', 'nama');
            if (!empty($lksFilter)) {
                // Jika ada filter Lembaga Konservasi, lakukan filter
                $lks = $lks->whereIn('id', $lksFilter);
            }
            $lks = $lks->get(); // Ambil data Lembaga Konservasi yang sudah difilter

            // Filter UPT
            $upts = ListUpt::distinct()->select('id', 'wilayah');
            if (!empty($uptsFilter)) {
                // Jika ada filter UPT, lakukan filter
                $upts = $upts->whereIn('id', $uptsFilter);
            }
            $upts = $upts->get(); // Ambil data UPT yang sudah difilter

            // Filter Class
            $classes = ListSpecies::distinct()->select('class');
            if (!empty($classesFilter)) {
                // Jika ada filter Class, lakukan filter
                $classes = $classes->whereIn('id', $classesFilter);
            }
            $classes = $classes->get(); // Ambil data Class yang sudah difilter

            // Hitung jumlah berdasarkan filter
            $lk_count = LembagaKonservasi::when($lksFilter, function ($query) use ($lksFilter) {
                return $query->whereIn('id', $lksFilter);
            })->count(); // Hitung jumlah Lembaga Konservasi yang difilter

            // Menghitung jumlah satwa berdasarkan kondisi:
            $species_count = Satwa::when($lksFilter, function ($query) use ($lksFilter) {
                return $query->whereIn('id_lk', $lksFilter);
            })->count(); // Hitung jumlah species yang ada dalam filter

            $skoleksi_count = Satwa::when($lksFilter, function ($query) use ($lksFilter) {
                return $query->whereIn('id_lk', $lksFilter)->where('status_satwa', 'satwa koleksi');
            })->count(); // Hitung jumlah koleksi satwa

            $stitipan_count = Satwa::when($lksFilter, function ($query) use ($lksFilter) {
                return $query->whereIn('id_lk', $lksFilter)->where('status_satwa', 'satwa titipan');
            })->count(); // Hitung jumlah satwa titipan

            $sbelumtag_count = Tagging::join('satwas', 'taggings.id_satwa', '=', 'satwas.id')  // Join dengan tabel satwas
                                ->when($lksFilter, function ($query) use ($lksFilter) {
                                    return $query->whereIn('satwas.id_lk', $lksFilter)  // Filter berdasarkan id_lk di tabel satwas
                                        ->where('taggings.jenis_tagging', 'belum ditagging');  // Filter berdasarkan status_tag di tabel taggings
                                })
                                ->count(); 

            $shidup_count = Satwa::when($lksFilter, function ($query) use ($lksFilter) {
                return $query->whereIn('id_lk', $lksFilter)->where('jenis_koleksi', 'satwa hidup');
            })->count(); // Hitung jumlah satwa hidup
            

                // Assuming the variables like total_bentukLk, total_wilayahLk, etc. are already computed
                // based on your application logic

                // Return the view with the filtered data
                return view('dashboard', compact(
                    'lk_count', 'species_count', 'skoleksi_count', 
                    'stitipan_count', 'sbelumtag_count', 'shidup_count',
                    'total_bentukLk', 'taksa', 'total_wilayahLk',
                    'total_jumlahIndvSpesies', 'total_tagging',
                    'total_class','total_jenis_koleksi', 'lks',
                    'classes', 'upts'
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

    public function filterClass()
    {
        try {
            $filter_class = Cache::remember('filter_class', 60, function () {
                return Satwa::with('species:id,class')
                            ->get()
                            ->pluck('species.class')
                            ->map(function ($class) {
                                return strtolower(trim($class));
                            })
                            ->unique()
                            ->filter()
                            ->values();
            });
            
            return response()->json($filter_class); // Pastikan response dalam format JSON
            
        } catch (\Exception $e) {
            // Menangani error dan memberi response yang sesuai
            return response()->json(['error' => 'Data tidak ditemukan', 'message' => $e->getMessage()], 500);
        }
    }
}