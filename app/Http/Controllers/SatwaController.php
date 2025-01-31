<?php

namespace App\Http\Controllers;

use App\Models\Couples;
use App\Models\Family_members;
use App\Models\History;
use App\Models\User;
use App\Models\Satwa;
use App\Models\Tagging;
use App\Models\ListSpecies;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use App\Models\ListAsalSatwaTitipan;
use App\Models\ListCaraPerolehanKoleksi;
use App\Models\RiwayatSatwa;
use App\Models\SatwaKoleksiIndividu;
use App\Models\SatwaTitipan;
use App\Policies\SatwaKoleksiPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        session()->forget('satwa');
        $satwa = Satwa::with(['species','lk' => function ($query) {
            $query->select('id', 'nama_spesies');
        }])->select('id', 'nama_panggilan', 'asal_satwa', 'jenis_koleksi', 'status_perlindungan')->paginate(50);


        return view('pages.satwa.daftar-satwa', compact('satwa'));
    }

    public function create(Request $request){ 
        
        $users = User::with('lk','role', 'upt', 'spesies')->find(Auth::id());
        // $namaIlmiah = ListSpecies::select('nama_ilmiah')->distinct()->pluck('nama_ilmiah');
        $namaIlmiah = ListSpecies::select('id', 'nama_ilmiah')->distinct()->get();
        $lks = LembagaKonservasi::select('id','nama')->get();
        $tagging = Tagging::select('id','jenis_tagging')->get();
        $perolehanKoleksiIndividu = ListCaraPerolehanKoleksi::select('id','nama')->get();
        return view('pages.satwa.data-koleksi-individu', compact('lks','users','namaIlmiah','tagging','perolehanKoleksiIndividu'));

    }

    public function search(Request $request){
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
    
    public function update(Request $request, $id){
        try {
            $satwa = Satwa::findOrFail($id);
            $oldData = $satwa->getOriginal();

            $tagging = Tagging::where('id_satwa', $id)->first();
            $validatedData = $request->validate([
                'id_lk' => 'required|exists:lembaga_konservasi,id',
                'id_spesies' => 'required|exists:list_species,id',
                'jenis_koleksi' => 'required|in:satwa hidup,awetan',
                'status_satwa' => 'in:koleksi,titipan,rehabilitasi,breeding loan',
                'no_izin_peroleh' => 'string|max:50|required_if:status_satwa,koleksi|nullable',
                'pengambilan_satwa' => 'in:1,0|nullable',
                'asal_satwa' => 'in:endemik,eksotik',
                'status_perlindungan' => 'required_if:jenis_koleksi,satwa hidup|in:1,0|nullable',
                'no_sats_ln' => 'string|nullable|max:50',
                'sk_kepala' => 'string|max:50|nullable',
                'sk_ksdae' => 'string|max:50|nullable',
                'sk_menteri' => 'string|max:50|nullable',
                'no_ba_titipan'=> 'string|nullable|max:100',
                'no_ba_kematian'=> 'string|nullable|max:100',
                'no_ba_kelahiran'=> 'string|nullable|max:100',
                'perilaku_satwa' => 'required|in:1,0',
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
                'jumlah_jantan' => 'numeric|nullable',
                'jumlah_betina' => 'numeric|nullable',
                'jumlah_unsex' => 'numeric|nullable',
                'tahun_titipan' => 'string|max:4',
                'validasi_tanggal' => 'required|date',
                'jumlah_keseluruhan_gender' => 'numeric|nullable',
                'keterangan' => 'string|max:255|nullable',
            ]);
    
            $satwa->update($validatedData);
            // Assuming you are within a controller method and have a $request instance
            $taggingData = $request->only(['jenis_tagging','kode_tagging', 'alasan_belum_tagging', 'ba_tagging']);
    
            if ($tagging) {
                $tagging->update($taggingData);
            }
            
            $newData = $satwa->getDirty();

            // History::create([
            //     'user_id' => auth()->id(),
            //     'action' => 'update',
            //     'old_data' => json_encode($oldData),
            //     'new_data' => json_encode($newData),
            // ]);
            

            return response()->json([
                'success' => true,
                'message' => 'Pendataan satwa berhasil diperbarui'
            ]);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Satwa tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy(Satwa $id){
        try{
            dd($id->nama_panggilan);
            // History::create([
            //     'user_id' => auth()->id,
            //     'action' => 'delete',
            //     'messages' => `Delete data {$id->nama_panggilan} - {$id->nama_lokal}`
            // ]);
            // $id->delete();

            return response()->json([
                'status' => 'success',
                'message'=> 'Satwa beerhasil dihapus',
            ],303);

        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Penghapusan data satwa gagal.',
                'error' => $e -> getMessage()
            ],500);
        }
    }

    public function viewSilsilah(){
        $listSatwa = Satwa::with('species:id,nama_ilmiah')->select('id','nama_panggilan','id_spesies','jenis_kelamin')->get();
        return view('pages.satwa.form-silsilah',compact('listSatwa'));
    }

    public function getCouples($jenis_kelamin){
        if($jenis_kelamin == 1){
            $listCouple = Satwa::with('species:id,nama_ilmiah')->where('jenis_kelamin', 0)->select('id','nama_panggilan','id_spesies')->get();
        }else{
            $listCouple = Satwa::with('species:id,nama_ilmiah')->where('jenis_kelamin', 1)->select('id','nama_panggilan','id_spesies')->get();
        }

        return response()->json([
            'success' =>'true',
            'listCouple' => $listCouple,
        ]);
    }

    public function storeGenealogy(Request $request){
        // Validasi data
        $validatedData = Validator::make($request->all(), [
            'id_satwa' => 'required',
            'id_jenis_kelamin' => 'required',
            'id_ayah' => 'required',
            'id_ibu' => 'required',
            'id_pasangan' => 'nullable',
            'id_anak' => 'nullable',
        ]);

        // Jika validasi gagal
        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validatedData->errors(),
            ], 422);
        }

        // Ambil data yang telah divalidasi
        $validatedData = $validatedData->validated();  // Mengambil data valid

        // Cek apakah ada pasangan yang diisi dan proses pasangan
        if (!empty($request['id_pasangan'])) {
            $jenisKelamin = $request['id_jenis_kelamin'];

            // Tentukan pasangan berdasarkan jenis kelamin
            $dataCouple = [];
            if ($jenisKelamin == "1") {  // Jika satwa adalah jantan
                $dataCouple['id_jantan'] = $request['id_satwa'];
                $dataCouple['id_betina'] = $request['id_pasangan'];
            } else {  // Jika satwa adalah betina
                $dataCouple['id_betina'] = $request['id_satwa'];
                $dataCouple['id_jantan'] = $request['id_pasangan'];
            }

            // Simpan data pasangan ke dalam tabel Couples
            Couples::create($dataCouple);
        }

        // Simpan data keluarga ke dalam tabel Family_members
        Family_members::create($validatedData);

        // Kembalikan respon sukses
        return response()->json([
            'success' => true,
            'message' => "Penambahan silsilah satwa berhasil",
        ]);
    }

    public function getListSpecies(Request $request){
        $nama_ilmiah = $request->query('nama_ilmiah');
        $data = ListSpecies::select('id','nama_lokal','nama_internasional','class')->where('nama_ilmiah',$nama_ilmiah)->first();
        if(!$data){
            return response()->json([
                'success' => false,
                'type' =>'error',
                'message' => 'Input data ilmiah tidak ada',
            ],404);
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

}