<?php

namespace App\Http\Controllers;

use App\Models\Satwa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreSatwaRequest;
use App\Http\Requests\UpdateSatwaRequest;
use App\Models\LembagaKonservasi;
use App\Models\ListSpecies;
use App\Models\Tagging;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

use function PHPUnit\Framework\isNull;

class SatwaController extends Controller
{
    //pendataan satwa
    // public function pendataan1(Request $request){
    //     $validator  = Validator::make($request->all(),[
    //         'id_lk' => 'required',
    //         'jenis_koleksi' => 'required|in:satwa hidup,awetan',
    //         'status_satwa' => 'in:koleksi,titipan,rehabilitasi,breeding loan',
    //         'no_peroleh_izin' => 'string|max:50|required_if:status_satwa, koleksi',
    //         'asal_satwa'=>'in:endemik,eksotik',
    //         'nomor_sats_ln'=>'string|nullable|max:50',
    //         'status_perlindungan' => 'required_if:jenis_koleksi, satwa hidup|in:dilindungi, tidak lindungi',
    //         'no_sk_kepala_balai' => 'string|max:50',
    //         'no_sk_dirjen_ksdae' => 'string|max:50',
    //         'no_sk_menteri_lhk' => 'string|max:50',
            
            
    //     ], [
    //         'string' => ':attribute harus berupa string.',
    //         'max' => ':attribute tidak boleh lebih dari :max karakter.',
    //         'status_satwa.in' => 'status satwa harus salah satu dari berikut: koleksi, titipan, rehabilitasi, breeding loan',
    //         'asal_satwa.in' => 'asal satwa harus salah satu dari berikut: endemik atau eksotik',
    //         'required_if' => 'Wajib diisi',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ],422);
    //     }

    //     $sessionData = $request->only([
    //         'id_lk','jenis_koleksi','status_satwa','no_peroleh_izin','asal_satwa',
    //         'nomor_sats_ln','no_sk_kepala_balai','no_sk_dirjen_ksdae', 'no_sk_menteri_lhk'
    //     ]);


    //     $request->session()->put('pendataan_satwa1',$sessionData);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Pendataan informasi status satwa berhasil'
    //     ]);
    // }

    // public function pendataan2(Request $request){
    //     $validator  = Validator::make($request->all(),[
    //         'perilaku_satwa'=> 'required|in:individu, kelompok',
    //         'jenis_kelamin'=>'required_if:perilaku_satwa, individu|in:jantan, betina, Tidak diketahui',
    //         'id_tagging' => 'required|in:ring, belum, label, chip, eartag', 
    //         'kode_tagging' => 'required_if:id_tagging|string|max:20',
    //         'alasan_belum_tagging' => 'required_if:id_tagging, belum|string|max:255|',
    //         'berita_acara_tagging' => 'required_if:id_tagging, ring, chip, label, chip, eartag|string|max:50',
    //         'nama_lokal '=> ['string','max:50', 'nullable'],
    //         'nama_panggilan'=>['string','max:50', 'nullable'],
    //         'class'=>['string','max:50', 'nullable'],
    //         'genus'=>['string','max:50', 'nullable'],
    //         'spesies'=>['string','max:50', 'nullable'],
    //         'sub_spesies'=>['string','max:50', 'nullable'],
    //         'jumlah_keseluruhan_gender '=> ['decimal', 'nullable'],
    //     ], [
    //         'required' => 'Wajib Diisi',
    //         'string' => ':atribut harus berupa huruf.',
    //         'integer' => ':atribut harus berupa angka.',
    //         'max' => ':atribut tidak boleh lebih dari :max karakter.',
    //         'required_if' => 'wajib diisi, mohon diperhatikan dengan baik.'
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ],422);
    //     }

    //     $pendataanSatwa1 = $request->session()->get('pendataan_satwa1');


    //     if(!$pendataanSatwa1){
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Silangkan ulangi proses pendataan satwa.'
    //         ]);
    //     }
    //     $data = array_merge($pendataanSatwa1, $validator->validated());
    //     $result = Satwa::create($data);


    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Pendataan satwa berhasil'
    //     ]);
    // }

    //perilaku individu
    // public function pendataan3(Request $request){
    //     $validator  = Validator::make($request->all(),[
    //         'nama_lokal '=> ['string','max:50', 'nullable'],
    //         'nama_panggilan'=>['string','max:50', 'nullable'],
    //         'class'=>['string','max:50', 'nullable'],
    //         'genus'=>['string','max:50', 'nullable'],
    //         'spesies'=>['string','max:50', 'nullable'],
    //         'sub_spesies'=>['string','max:50', 'nullable'],
    //     ], [
    //         'string' => ':attribute harus berupa string.',              
    //         'max' => ':attribute tidak boleh lebih dari :max karakter.',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ],422);
    //     }

    //     $pendataanSatwa1 = $request->session()->get('pendataan_satwa1');
    //     $pendataanSatwa2 = $request->session()->get('pendataan_satwa2');

    //     if(!$pendataanSatwa1 && !$pendataanSatwa2 ){
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Silangkan ulangi proses pendataan satwa.'
    //         ]);
    //     }

    //     $data = array_merge($pendataanSatwa1,$pendataanSatwa2, $validator->validated());

    //     $result = Satwa::create($data);


    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Pendataan satwa berhasil'
    //     ]);
    // }

    // // perilaku berkelompok
    // public function pendataan4(Request $request){
    //     $validator  = Validator::make($request->all(),[
    //         'jumlah_keseluruhan_gender '=> ['decimal', 'nullable'],
    //         'nama_panggilan' => ['required', 'array','nullable'],
    //         'nama_panggilan.*' => ['string','nullable']
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ],422);
    //     }

    //     $pendataanSatwa1 = $request->session()->get('pendataan_satwa1');
    //     $pendataanSatwa2 = $request->session()->get('pendataan_satwa2');

    //     if(!$pendataanSatwa1 && !$pendataanSatwa2 ){
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Silangkan ulangi proses pendataan satwa.'
    //         ]);
    //     }

    //     $data = array_merge($pendataanSatwa1,$pendataanSatwa2, $validator->validated());

    //     $result = Satwa::create($data);


    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Pendataan satwa berhasil'
    //     ]);
    // }

    public function index(){
        
        $satwa = Satwa::with(['species','lk' => function ($query) {
            $query->select('id', 'nama_spesies');
        }])->select('id', 'nama_panggilan', 'asal_satwa', 'jenis_koleksi', 'status_perlindungan')->paginate(50);

        return view('pages.satwa.daftar-satwa', compact('satwa'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
        ]);
        $query = $request->input('query');

        $satwa = Satwa::where('nama_panggilan', 'like', "%$query%")
            ->orWhere('asal_satwa', 'like', "%$query%")
            ->orWhere('jenis_koleksi', 'like', "%$query%")
            ->orWhereHas('species', function ($queryRelasi) use ($query) {
                $queryRelasi->where('spesies', 'like', "%$query%"); // Kolom dalam tabel list_species
            })
            ->orWhereHas('lk', function ($queryRelasi) use ($query) {
                $queryRelasi->where('slug', 'like', "%$query%"); // Kolom dalam tabel list_lk
            })
            ->paginate(50);

        session(['satwa' => $satwa]);

        return view('pages.satwa.daftar-satwa', compact('satwa', 'query'));
    }

    /**
     * Store a newly created resource in storage.a
     */
    public function store(Request $request){
        // Cek bagian yang akan diproses
        $section = $request->input('section');
    
        if ($section === 'pendataan1') {
            // Proses pendataan1
            $validator = Validator::make($request->all(), [
                'id_lk' => 'required',
                'jenis_koleksi' => 'required|in:satwa hidup,awetan',
                'status_satwa' => 'in:koleksi,titipan,rehabilitasi,breeding loan',
                'no_peroleh_izin' => 'string|max:50|required_if:status_satwa, koleksi|nullable',
                'pengambilan_satwa' => 'in:1,0||nullable',
                'asal_satwa' => 'in:endemik,eksotik',
                'status_perlindungan' => 'required_if:jenis_koleksi, satwa hidup|in:1, 0|nullable', // dilindungi (1) || tidak dilindungi (0)
                'nomor_sats_ln' => 'string|nullable|max:50',
                'no_sk_kepala_balai' => 'string|max:50|nullable',
                'no_sk_dirjen_ksdae' => 'string|max:50|nullable',
                'no_sk_menteri_lhk' => 'string|max:50|nullable',
            ], [
                'string' => ':attribute harus berupa string.',
                'max' => ':attribute tidak boleh lebih dari :max karakter.',
                'required_if' => 'Wajib diisi',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Simpan data sesi untuk pendataan1
            $sessionData = $validator->validated();
            $request->session()->put('pendataan_satwa1', $sessionData);
    
            return response()->json([
                'success' => true,
                'message' => 'Pendataan informasi status satwa berhasil'
            ]);
    
        } elseif ($section === 'pendataan2') {
            // Proses pendataan2
            $validator = Validator::make($request->all(), [
                'perilaku_satwa' => 'required|in:1,0', // individu (1) atau kelompok (0)
                //individu
                'jenis_kelamin' => 'required_if:perilaku_satwa,1|in:jantan,betina,Tidak diketahui|nullable',
                'jenis_tagging' => 'required_if:perilaku_satwa,1|in:ring,belum,label,chip,eartag|nullable', 
                'kode_tagging' => 'required_if:perilaku_satwa,1|required_if:jenis_tagging,ring|required_if:jenis_tagging,label|required_if:jenis_tagging,chip|required_if:jenis_tagging,eartag|string|max:20|nullable',
                'alasan_belum_tagging' => 'required_if:jenis_tagging,belum|string|max:255|nullable',
                'ba_tagging' => 'required_if:perilaku_satwa,1|required_if:jenis_tagging,ring|required_if:jenis_tagging,label|required_if:jenis_tagging,chip|required_if:jenis_tagging,eartag|string|max:50|nullable',
                'nama_lokal' => 'required_if:perilaku_satwa,1|string|max:50|nullable',
                'nama_panggilan' => 'required_if:perilaku_satwa,1|string|max:50|nullable',
                'class' => 'required_if:perilaku_satwa,1|string|max:50|nullable',
                'genus' => 'required_if:perilaku_satwa,1|string|max:50|nullable',
                'spesies' => 'required_if:perilaku_satwa,1|string|max:50|nullable',
                'sub_spesies' => 'required_if:perilaku_satwa,1|string|max:50|nullable',
                'nama_ilmiah' => 'required_if:perilaku_satwa,1|string|nullable',
                //kelompok
                'jumlah_jantan' => 'numeric|nullable',
                'jumlah_betina' => 'numeric|nullable',
                'jumlah_unsex' => 'numeric|nullable',
                'tahun_titipan' => 'string|max:4',
                'jumlah_keseluruhan_gender' => 'numeric|nullable',

                'keterangan' => 'string|max:255|nullable',
            ], [
                'required' => 'Wajib Diisi',
                'string' => ':atribut harus berupa huruf.',
                'max' => ':atribut tidak boleh lebih dari :max karakter.',
                'required_if' => 'wajib diisi, mohon diperhatikan dengan baik.'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Ambil data sesi pendataan1
            $pendataanSatwa1 = $request->session()->get('pendataan_satwa1');
            if (!$pendataanSatwa1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan ulangi proses pendataan satwa.'
                ]);
            }

            $pendataanSatwa2 = $request->only([
                'perilaku_satwa','jenis_kelamin',
                'nama_panggilan',
                'jumlah_keseluruhan_gender','jumlah_jantan','jumlah_betina','jumlah_unsex',
                'tahun_titipan',
                'keterangan',
            ]);
            
            $species = strtolower($request->input('species'));
            $id_spesies = ListSpecies::whereRaw('LOWER(spesies) = ?', [$species])->first()->id ?? null;

            if (is_null($id_spesies)) {
                $addSpesies = $request->only(['spesies', 'genus', 'class', 'nama_lokal', 'sub_spesies', 'nama_ilmiah']);
                $createSatwa = ListSpecies::create($addSpesies);
                $id_spesies = $createSatwa->id;
            }

            

            $data = array_merge($request->session()->get('pendataan_satwa1', []), $pendataanSatwa2);
            $data['id_spesies'] = $id_spesies;
            // dd($data);

            $result = Satwa::create($data);
            $id_satwa = $result->id;

            // dd($id_satwa);

            $dataTagging = $request->only([
                'jenis_tagging', 'kode_tagging', 'alasan_belum_tagging', 'ba_tagging'
            ]);
            $dataTagging['id_satwa'] = $id_satwa;
            // dd($dataTagging);

            $result2 = Tagging::create($dataTagging);

            return response()->json([
                'success' => true,
                'message' => 'Pendataan satwa berhasil'
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Section tidak valid.'
            ], 400);
        }
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

    //daftar satwa
    public function form(){
        $user = User::with('lk','role', 'upt', 'spesies')->find(Auth::id());
        $satwa = Satwa::with('lk')->get();
        $lk = LembagaKonservasi::with('upt')->get();

        return view('pages.satwa.pendataan-satwa', compact('satwa','lk','user',));
    }
}
