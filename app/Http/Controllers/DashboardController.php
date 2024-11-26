<?php

namespace App\Http\Controllers;

use App\Models\LembagaKonservasi;
use App\Models\Satwa;
use App\Models\Tagging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function getData($role)
    {
        try {
            $data = null;

            switch ($role) {
                case 'kkhsg':
                case 'lk':
                    $lk = Auth::user()->lk->id;
                    $satwa = Satwa::with(['species:id,nama_ilmiah,class,spesies', 'lk:id,id_upt,nama','lk.upt:id,wilayah'])
                        ->select('id', 'id_lk', 'status_satwa', 'jenis_koleksi', 'id_spesies', 'asal_satwa')
                        ->where('id_lk', $lk) 
                        ->get();
                    $tagging = Tagging::select('id','id_satwa','jenis_tagging')->get();
                    $pengelola = LembagaKonservasi::where('id',$lk)->select('pengelola')->first();

                    return response()->json([
                        'status' => 'success',
                        'satwa' => $satwa,
                        'tagging' => $tagging,
                        'pengelola' => $pengelola,

                        // 'count_lk' => $count_lk,
                    ]);

                    break;
                case 'upt':
                case 'drh':
                case 'sb':
                case 'sk':
                    $satwa = Satwa::with(['species:id,nama_ilmiah,class,spesies', 'lk:id,id_upt,nama','lk.upt:id,wilayah'])
                        ->select('id', 'id_lk', 'status_satwa', 'jenis_koleksi', 'id_spesies')
                        ->get();
                    $tagging = Tagging::select('id','id_satwa','jenis_tagging')->get();
                    $count_lk = LembagaKonservasi::count();

                    return response()->json([
                        'status' => 'success',
                        'satwa' => $satwa,
                        'tagging' => $tagging,
                        // 'count_lk' => $count_lk,
                    ]);

                    break;

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