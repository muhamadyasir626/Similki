<?php

namespace App\Http\Controllers;

use App\Models\PendataanSatwa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePendataanSatwaRequest;
use App\Http\Requests\UpdatePendataanSatwaRequest;

class PendataanSatwaController extends Controller
{

    public function pendataan1(Request $request){
        $validator  = Validator::make($request->all(),[
            'jenis_koleksi'=> ['string','max:50', 'nullable'],
            'asal_satwa'=>['string','max:50', 'nullable'],
            'no_sats_ln'=>['string','max:50', 'nullable'],
            'status_perlindungan'=>['string','max:50', 'nullable'],
            'sk_kepala'=>['string','max:50', 'nullable'],
            'pengambilan_satwa'=>['string','max:50', 'nullable'],
            'sk_ksdae'=>['string','max:50', 'nullable'],
            'sk_menteri'=>['string','max:50', 'nullable'],
        ], [
            'string' => ':attribute harus berupa string.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],422);
        }

        $sessionData = $request->only([
            'jenis_koleksi','asal_satwa','no_sats_ln','status_perlindungan','sk_kepala',
            'pengambilan_satwa','sk_ksdae','sk_menteri'
        ]);

        $request->session()->put('pendataan_satwa1',$sessionData);

        return response()->json([
            'success' => true,
            'message' => 'Pendataan satwa (informasi status satwa) berhasil'
        ]);
    }

    public function pendataan2(Request $request){
        $validator  = Validator::make($request->all(),[
            'perilaku_satwa'=> ['string','max:50', 'nullable'],
            'jenis_kelamin_individu'=>['string','max:50', 'nullable'],
            'sudah_tagging'=>['string','max:50', 'nullable'],
            'id_tagging'=>['string','max:50', 'nullable'],
            'kode_tagging'=>['string','max:50', 'nullable'],
            'jumlah_male'=>['string','max:50', 'nullable'],
            'jumlah_female'=>['string','max:50', 'nullable'],
            'sk_menteri'=>['string','max:50', 'nullable'],
        ], [
            'string' => ':attribute harus berupa string.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],422);
        }

        $sessionData = $request->only([
            'perilaku_satwa','jenis_kelamin_individu','no_sats_ln','status_perlindungan','sk_kepala',
            'pengambilan_satwa','sk_ksdae','sk_menteri'
        ]);

        $request->session()->put('pendataan_satwa2',$sessionData);

        return response()->json([
            'success' => true,
            'message' => 'Pendataan satwa (informasi status satwa) berhasil'
        ]);
    }

    public function pendataan3(Request $request){
        $validator  = Validator::make($request->all(),[
            'nama_lokal '=> ['string','max:50', 'nullable'],
            'jenis_kelamin_individu'=>['string','max:50', 'nullable'],
            'sudah_tagging'=>['string','max:50', 'nullable'],
            'id_tagging'=>['string','max:50', 'nullable'],
            'kode_tagging'=>['string','max:50', 'nullable'],
            'jumlah_male'=>['string','max:50', 'nullable'],
            'jumlah_female'=>['string','max:50', 'nullable'],
            'sk_menteri'=>['string','max:50', 'nullable'],
        ], [
            'string' => ':attribute harus berupa string.',              
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],422);
        }

        $sessionData = $request->only([
            'perilaku_satwa','jenis_kelamin_individu','no_sats_ln','status_perlindungan','sk_kepala',
            'pengambilan_satwa','sk_ksdae','sk_menteri'
        ]);

        $request->session()->put('pendataan_satwa2',$sessionData);

        return response()->json([
            'success' => true,
            'message' => 'Pendataan satwa (informasi status satwa) berhasil'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePendataanSatwaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PendataanSatwa $pendataanSatwa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PendataanSatwa $pendataanSatwa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePendataanSatwaRequest $request, PendataanSatwa $pendataanSatwa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PendataanSatwa $pendataanSatwa)
    {
        //
    }
}
