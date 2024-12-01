<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Satwa;
use App\Models\Tagging;
use App\Models\ListSpecies;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;
use App\Http\Requests\StoreSatwaRequest;
use App\Http\Requests\UpdateSatwaRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class SatwaController extends Controller
{

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
                'no_sats_ln' => 'string|nullable|max:50',
                'sk_kepala' => 'string|max:50|nullable',
                'sk_ksdae' => 'string|max:50|nullable',
                'sk_menteri' => 'string|max:50|nullable',
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
                'validasi_tanggal' =>'required|date',
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
    public function update(Request $request, $id)
    {
        try {
            $satwa = Satwa::findOrFail($id);
            $tagging = Tagging::where('id_satwa', $id)->first();
            $validatedData = $request->validate([
                'id_lk' => 'required|exists:lembaga_konservasis,id',
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
    

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satwa $id)
    {
        try{
            dd($id);
            $satwa->delete();
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

    //daftar satwa
    public function form(){
        $user = User::with('lk','role', 'upt', 'spesies')->find(Auth::id());
        $satwa = Satwa::with('lk')->get();
        $lk = LembagaKonservasi::with('upt')->get();

        return view('pages.satwa.pendataan-satwa', compact('satwa','lk','user',));
    }
}
