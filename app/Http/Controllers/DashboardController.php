<?php

namespace App\Http\Controllers;

use App\Models\Satwa;
use App\Models\Tagging;
use App\Models\ListSpecies;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

use function PHPUnit\Framework\isNull;

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
// {
                $label_bentukLk = LembagaKonservasi::select('id','bentuk_lk')
                ->get()
                ->groupBy('bentuk_lk')
                ->map(function ($item,$key){
                    return ['total' => $item->count(), 'label' => $key];
                });

                $total_bentukLk = $label_bentukLk->pluck('total','label');
                // dd('label:',$label_lembagaKonservasi,'total:',$total_bentukLk);
// }

                //data chart - total wilayah lembaga konservasi 
// {
                $label_wilayahLk = LembagaKonservasi::with(['upt' => function($query) {
                    $query->select('id', 'wilayah'); 
                }])->select('id', 'id_upt')
                ->get() 
                ->groupBy('id_upt') 
                ->map(function ($item, $id_upt) {
                    return [
                        'total' => $item->count(), 
                        'label' => optional($item->first()->upt)->wilayah
                    ];
                });

                $total_wilayahLk = $label_wilayahLk->pluck('total', 'label');
                // dd($total_wilayahLk);
// }

                //data chart - total jenis koleksi 
// {
                $label_jenisKoleksi = Satwa::select('id','jenis_koleksi')
                    ->get()
                    ->groupBy('jenis_koleksi')
                    ->map(function ($item, $key) {
                        return ['total' => $item->count(), 'label' => $key];
                    });

                $total_jenisKoleksi = $label_jenisKoleksi->pluck('total', 'label');
                // dd('label:',$label_jenisKoleksi,'total:',$total_jenisKoleksi);
// }
                //data chart - total species
// {
                $label_class = ListSpecies::select('id', 'class')->get()
                ->groupBy('class')
                ->map(function ($item, $key) {
                    return [
                        'total' => $item->count(),
                        'label' => strtolower($key)  // Pastikan labelnya adalah huruf kecil
                    ];
                });
            
                $total_class = $label_class->pluck('total', 'label');
                // dd('total:',$total_class);
//}
                //data chart - total jumlah species individu
// {
                $label_jumlahIndvSpesies = Satwa::with(['species' => function($query) {
                    $query->select('id', 'nama_ilmiah');
                }])
                ->select('id', 'id_spesies')  
                ->get()
                ->groupBy('id_spesies')
                ->map(function($item, $id_spesies){
                    $nama_ilmiah = optional($item->first()->species)->nama_ilmiah;
                    if(is_null($nama_ilmiah)||empty($nama_ilmiah)){
                        $nama_ilmiah = 'Spesies belum diketahui';
                    }
                    return [
                        'total' => $item->count(),
                        'label' => $nama_ilmiah
                    ];
                })
                ->sortByDesc('total') 
                ->take(10); 

                $total_jumlahIndvSpesies = $label_jumlahIndvSpesies->pluck('total', 'label');
                // dd($total_jumlahIndvSpesies);
//}
                //data chart - total tagging
//{
                $label_tagging = Tagging::select('id', 'jenis_tagging')->get()
                ->groupBy('jenis_tagging')
                ->map(function ($item, $key) {
                    if(empty($key)){
                        $key = 'belum ditagging';
                    }
                    return [
                        'total' => $item->count(),
                        'label' => strtolower($key)
                    ];
                });
            
                $total_tagging = $label_tagging->pluck('total', 'label');
                // dd('total:',$total_tagging);
//}
                //data chart - total taksa
//{
                $label_taksa = satwa::with(['species' => function($query){
                    $query->select('id','class');
                }])
                ->select('id', 'id_spesies')
                ->get()
                ->groupBy('id_spesies')
                ->map(function ($item, $id_spesies) {
                    $class = optional($item->first()->species)->class;
                    if(empty($class)){
                        $class = 'Class satwa belum Diketahui';
                    }
                    return [
                        'total' => $item->count(),
                        'label' => $class
                    ];
                });
            
                $total_taksa = $label_taksa->pluck('total', 'label');
                // dd('total:',$total_taksa);
//}
                // data chart total jenis koleksi 
// {
                $label_jenis_koleksi = Satwa::select('id','jenis_koleksi')->get()
                ->groupBy('jenis_koleksi')
                ->map(function($item, $key){
                    if(empty($key)){
                        $key = 'belum diketahui';
                    }
                    return[
                        'total' => $item->count(),
                        'label' => strtolower($key)
                    ];
                });

                $total_jenis_koleksi = $label_jenis_koleksi->pluck('total','label');
                // dd($total_jenis_koleksi);
//}

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
    public function getData($role)
    {
        try {

            switch ($role) {
                case 'kkhsg':
                    //dinamis
                    $satwa = Satwa::with(['species:id,nama_ilmiah,class,spesies', 'lk:id,id_upt,nama','lk.upt:id,wilayah'])
                        ->select('id', 'id_lk', 'status_satwa', 'jenis_koleksi', 'id_spesies')
                        ->get();
                    $tagging = Tagging::select('id','id_satwa','jenis_tagging')->get();
                    //statis
                    $lk_count = LembagaKonservasi::count();
                    $species_count = ListSpecies::count();
                    $skoleksi_count = Satwa::where('status_satwa','satwa koleksi')->count();
                    $stitipan_count = Satwa::where('status_satwa','satwa titipan')->count();
                    $sbelumtag_count = Tagging::where('jenis_tagging','belum ditagging')->count();
                    $shidup_count = Satwa::where('jenis_koleksi','satwa hidup')->count();
                    $taksa = ListSpecies::select('spesies')->count();

                    
                    return response()->json([
                        'status' => 'success',
                        'satwa' => $satwa,
                        'tagging' => $tagging,
                        'lk_count' => $lk_count,
                        'species_count' => $species_count,
                        'skoleksi_count' => $skoleksi_count,
                        'stitipan_count' => $stitipan_count,
                        'sbelumtag_count' => $sbelumtag_count,
                        'shidup_count' => $shidup_count,
                        'taksa' => $taksa,
                    ]);
                case 'lk':
                case 'upt':
                case 'drh':
                case 'sb':
                case 'sk':

                default:
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid role provided',
                    ], 400);
            }

        
        } catch (\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage(),
            ], 500);
        }
    }
}
