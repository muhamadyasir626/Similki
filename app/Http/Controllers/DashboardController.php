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
                $lastUpdateBentukLk = LembagaKonservasi::max('updated_at');
                $cacheKeyBentukLk = 'label_bentukLk' . $lastUpdateBentukLk;
                $label_bentukLk = Cache::remember($cacheKeyBentukLk, 0, function () {
                    return LembagaKonservasi::select('id', 'bentuk_lk')
                        ->get()
                        ->groupBy('bentuk_lk')
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => $key];
                        });
                });
                $total_bentukLk = $label_bentukLk->pluck('total', 'label');
                
                $lastUpdateWilayahLk= LembagaKonservasi::max('updated_at');
                $cacheKeyWilayahLk = 'label_wilayahLk' . $lastUpdateWilayahLk;
                $label_wilayahLk = Cache::remember($cacheKeyWilayahLk, 0, function () {
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
                
                $lastUpdateJenisKoleksi= Satwa::max('updated_at');
                $cacheKeyJenisKoleksi = 'label_jenisKoleksi' . $lastUpdateJenisKoleksi;
                $label_jenisKoleksi = Cache::remember($cacheKeyJenisKoleksi, 0, function () {
                    return Satwa::select('id', 'jenis_koleksi')
                        ->get()
                        ->groupBy('jenis_koleksi')
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => $key];
                        });
                });
                $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');
                
                $lastUpdateClass= listSpecies::max('updated_at');
                $cacheKeyClass = 'label_class' . $lastUpdateClass;
                $label_class = Cache::remember($cacheKeyClass, 0, function () {
                    return ListSpecies::select('id', 'class')->get()
                        ->groupBy('class')
                        ->map(function ($item, $key) {
                            return ['total' => $item->count(), 'label' => strtolower($key)];
                        });
                });
                $total_class = $label_class->pluck('total', 'label');

                $lastUpdateJumlahIndvSpecies= listSpecies::max('updated_at');
                $cacheKeyJumlahIndvSpecies = 'label_JumlahIndvSpesies' . $lastUpdateJumlahIndvSpecies;
                $label_jumlahIndvSpesies = Cache::remember($cacheKeyJumlahIndvSpecies, 0, function () {
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
                
                $lastUpdateTagging= listSpecies::max('updated_at');
                $cacheKeyTagging = 'label_Tagging' . $lastUpdateTagging;
                $label_tagging = Cache::remember($cacheKeyTagging, 0, function () {
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
                
                $lastUpdatejenis_koleksi= Satwa::max('updated_at');
                $cacheKeyjenis_koleksi = 'label_jenis_koleksi' . $lastUpdatejenis_koleksi;
                $label_jenis_koleksi = Cache::remember($cacheKeyJenisKoleksi, 0, function () {
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
