<?php

namespace App\Http\Controllers;

use App\Models\Satwa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreSatwaRequest;
use App\Http\Requests\UpdateSatwaRequest;
use App\Models\LembagaKonservasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SatwaController extends Controller
{
    //pendataan satwa
    public function pendataan1(Request $request){
        $validator  = Validator::make($request->all(),[
            'id_lk' => 'required',
            'jenis_koleksi' => 'required|in:satwa hidup,awetan',
            'status_satwa' => 'in:koleksi,titipan,rehabilitasi,breeding loan',
            'no_peroleh_izin' => 'string|max:50|required_if:status_satwa, koleksi',
            'asal_satwa'=>'in:endemik,eksotik',
            'nomor_sats_ln'=>'string|nullable|max:50',
            'status_perlindungan' => 'required_if:jenis_koleksi, satwa hidup|in:dilindungi, tidak lindungi',
            'no_sk_kepala_balai' => 'string|max:50',
            'no_sk_dirjen_ksdae' => 'string|max:50',
            'no_sk_menteri_lhk' => 'string|max:50',
            
            
        ], [
            'string' => ':attribute harus berupa string.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'status_satwa.in' => 'status satwa harus salah satu dari berikut: koleksi, titipan, rehabilitasi, breeding loan',
            'asal_satwa.in' => 'asal satwa harus salah satu dari berikut: endemik atau eksotik',
            'required_if' => 'Wajib diisi',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],422);
        }

        $sessionData = $request->only([
            'id_lk','jenis_koleksi','status_satwa','no_peroleh_izin','asal_satwa',
            'nomor_sats_ln','no_sk_kepala_balai','no_sk_dirjen_ksdae', 'no_sk_menteri_lhk'
        ]);

        $request->session()->put('pendataan_satwa1',$sessionData);

        return response()->json([
            'success' => true,
            'message' => 'Pendataan informasi status satwa berhasil'
        ]);
    }

    public function pendataan2(Request $request){
        $validator  = Validator::make($request->all(),[
            'perilaku_satwa'=> 'required|in:individu, kelompok',
            'jenis_kelamin'=>'required_if:perilaku_satwa, individu|in:jantan, betina, Tidak diketahui',
            'id_tagging' => 'required|in:ring, belum, label, chip, eartag', 
            'kode_tagging' => 'required_if:id_tagging|string|max:20',
            'alasan_belum_tagging' => 'required_if:id_tagging, belum|string|max:255|',
            'berita_acara_tagging' => 'required_if:id_tagging, ring, chip, label, chip, eartag|string|max:50'
        ], [
            'required' => 'Wajib Diisi',
            'string' => ':atribut harus berupa huruf.',
            'integer' => ':atribut harus berupa angka.',
            'max' => ':atribut tidak boleh lebih dari :max karakter.',
            'required_if' => 'wajib diisi, mohon diperhatikan dengan baik.'
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

    //perilaku individu
    public function pendataan3(Request $request){
        $validator  = Validator::make($request->all(),[
            'nama_lokal '=> ['string','max:50', 'nullable'],
            'nama_panggilan'=>['string','max:50', 'nullable'],
            'class'=>['string','max:50', 'nullable'],
            'genus'=>['string','max:50', 'nullable'],
            'spesies'=>['string','max:50', 'nullable'],
            'sub_spesies'=>['string','max:50', 'nullable'],
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

        $pendataanSatwa1 = $request->session()->get('pendataan_satwa1');
        $pendataanSatwa2 = $request->session()->get('pendataan_satwa2');

        if(!$pendataanSatwa1 && !$pendataanSatwa2 ){
            return response()->json([
                'success' => false,
                'message' => 'Silangkan ulangi proses pendataan satwa.'
            ]);
        }

        $data = array_merge($pendataanSatwa1,$pendataanSatwa2, $validator->validated());

        $result = Satwa::create($data);


        return response()->json([
            'success' => true,
            'message' => 'Pendataan satwa berhasil'
        ]);
    }

    // perilaku berkelompok
    public function pendataan4(Request $request){
        $validator  = Validator::make($request->all(),[
            'jumlah_keseluruhan_gender '=> ['decimal', 'nullable'],
            'nama_panggilan' => ['required', 'array','nullable'],
            'nama_panggilan.*' => ['string','nullable']
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],422);
        }

        $pendataanSatwa1 = $request->session()->get('pendataan_satwa1');
        $pendataanSatwa2 = $request->session()->get('pendataan_satwa2');

        if(!$pendataanSatwa1 && !$pendataanSatwa2 ){
            return response()->json([
                'success' => false,
                'message' => 'Silangkan ulangi proses pendataan satwa.'
            ]);
        }

        $data = array_merge($pendataanSatwa1,$pendataanSatwa2, $validator->validated());

        $result = Satwa::create($data);


        return response()->json([
            'success' => true,
            'message' => 'Pendataan satwa berhasil'
        ]);
    }

    public function index(){
        $user = User::with('lk','role', 'upt', 'spesies')->find(Auth::id());
        $satwa = Satwa::with('lk')->get();
        $lk = LembagaKonservasi::with('ListUpt')->get();


        return view('pages.LK.pendataan-satwa', compact('satwa','lk','user',));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //     $validator = validator::make($request->all(),[
    //         'file' => 'required|file|mimes:csv',
    //     ]);

    //     Excel::import(new DataImport, request()->file('file'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Satwa $Satwa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satwa $Satwa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSatwaRequest $request, Satwa $Satwa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satwa $Satwa)
    {
        //
    }
}
