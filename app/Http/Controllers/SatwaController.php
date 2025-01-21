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
use Illuminate\Support\Facades\Cache;

class SatwaController extends Controller
{

// public function getAll()
// {
//     try {
//         // Ambil data dan cek apakah relasi berhasil di-load
//         // $satwa = Satwa::with(['lk', 'species'])
//         //               ->select('id', 'status_satwa', 'jenis_kelamin_individu')
//         //               ->whereIn('status_satwa', ['Satwa Koleksi', 'Satwa Titipan'])
//         //               ->get();
//         $satwa = Satwa::select('status_satwa')->count();

//         return response()->json([
//             'status' => 'success',
//             'data' => $satwa,
//         ]);
//     } catch (\Exception $e) {
//         // Tangkap error dan tampilkan pesan
//         return response()->json([
//             'status' => 'error',
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }

//     public function index(){
        
//         $satwa = Satwa::with(['species','lk' => function ($query) {
//             $query->select('id', 'nama_spesies');
//         }])->select('id', 'nama_panggilan', 'asal_satwa', 'jenis_koleksi', 'status_perlindungan')->paginate(50);

//         return view('pages.satwa.daftar-satwa', compact('satwa'));
//     }

//     public function search(Request $request)
//     {
//         $request->validate([
//             'query' => 'required|string|min:1',
//         ]);
//         $query = $request->input('query');

//         $satwa = Satwa::where('nama_panggilan', 'like', "%$query%")
//             ->orWhere('asal_satwa', 'like', "%$query%")
//             ->orWhere('jenis_koleksi', 'like', "%$query%")
//             ->orWhereHas('species', function ($queryRelasi) use ($query) {
//                 $queryRelasi->where('spesies', 'like', "%$query%"); // Kolom dalam tabel list_species
//             })
//             ->orWhereHas('lk', function ($queryRelasi) use ($query) {
//                 $queryRelasi->where('slug', 'like', "%$query%"); // Kolom dalam tabel list_lk
//             })
//             ->paginate(50);

//         session(['satwa' => $satwa]);

//         return view('pages.satwa.daftar-satwa', compact('satwa', 'query'));
//     }

//     /**
//      * Store a newly created resource in storage.a
//      */
//     public function store(Request $request){
//         // Cek bagian yang akan diproses
//         $section = $request->input('section');
    
//         if ($section === 'pendataan1') {
//             // Proses pendataan1
//             $validator = Validator::make($request->all(), [
//                 // 'id_lk' => 'required',
//                 'jenis_koleksi' => 'required|in:satwa hidup,awetan',
//                 'status_satwa' => 'in:koleksi,titipan,rehabilitasi,breeding loan',
//                 'no_peroleh_izin' => 'string|max:50|required_if:status_satwa, koleksi',
//                 'asal_satwa' => 'in:endemik,eksotik',
//                 'nomor_sats_ln' => 'string|nullable|max:50',
//                 'status_perlindungan' => 'required_if:jenis_koleksi, satwa hidup|in:dilindungi, tidak lindungi',
//                 'no_sk_kepala_balai' => 'string|max:50',
//                 'no_sk_dirjen_ksdae' => 'string|max:50',
//                 'no_sk_menteri_lhk' => 'string|max:50',
//             ], [
//                 'string' => ':attribute harus berupa string.',
//                 'max' => ':attribute tidak boleh lebih dari :max karakter.',
//                 'required_if' => 'Wajib diisi',
//             ]);
    
//             if ($validator->fails()) {
//                 return response()->json([
//                     'success' => false,
//                     'errors' => $validator->errors()
//                 ], 422);
//             }
    
//             // Simpan data sesi untuk pendataan1
//             $sessionData = $validator->validated();
//             $request->session()->put('pendataan_satwa1', $sessionData);
    
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Pendataan informasi status satwa berhasil'
//             ]);
    
//         } elseif ($section === 'pendataan2') {
//             // Proses pendataan2
//             $validator = Validator::make($request->all(), [
//                 'perilaku_satwa' => 'required|in:individu, kelompok',
//                 'jenis_kelamin' => 'required_if:perilaku_satwa, individu|in:jantan, betina, Tidak diketahui',
//                 'id_tagging' => 'required|in:ring, belum, label, chip, eartag', 
//                 'kode_tagging' => 'required_if:id_tagging|string|max:20',
//                 'alasan_belum_tagging' => 'required_if:id_tagging, belum|string|max:255',
//                 'berita_acara_tagging' => 'required_if:id_tagging, ring, chip, label, chip, eartag|string|max:50',
//                 'nama_lokal' => ['string', 'max:50', 'nullable'],
//                 'nama_panggilan' => ['string', 'max:50', 'nullable'],
//                 'class' => ['string', 'max:50', 'nullable'],
//                 'genus' => ['string', 'max:50', 'nullable'],
//                 'spesies' => ['string', 'max:50', 'nullable'],
//                 'sub_spesies' => ['string', 'max:50', 'nullable'],
//                 'jumlah_keseluruhan_gender' => ['decimal', 'nullable'],
//             ], [
//                 'required' => 'Wajib Diisi',
//                 'string' => ':atribut harus berupa huruf.',
//                 'max' => ':atribut tidak boleh lebih dari :max karakter.',
//                 'required_if' => 'wajib diisi, mohon diperhatikan dengan baik.'
//             ]);
    
//             if ($validator->fails()) {
//                 return response()->json([
//                     'success' => false,
//                     'errors' => $validator->errors()
//                 ], 422);
//             }
    
//             // Ambil data sesi pendataan1
//             $pendataanSatwa1 = $request->session()->get('pendataan_satwa1');
//             if (!$pendataanSatwa1) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Silakan ulangi proses pendataan satwa.'
//                 ]);
//             }
    
//             // Gabungkan data pendataan1 dengan data baru yang valid
//             $data = array_merge($pendataanSatwa1, $validator->validated());
//             $result = Satwa::create($data);
    
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Pendataan satwa berhasil'
//             ]);
//         } else {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Section tidak valid.'
//             ], 400);
//         }

//         // Simpan data ke database
//         $data = new Satwa();
//         $data->fill($request->all());
//         $data->save();

//         // Mengembalikan respons sukses
//         return response()->json(['success' => true]);
//         }

//     // Di model Satwa
// //     protected $fillable = [
// //     'id_lk', 'jenis_koleksi', 'status_satwa', 'no_peroleh_izin', 'asal_satwa',
// //     'nomor_sats_ln', 'status_perlindungan', 'no_sk_kepala_balai', 'no_sk_dirjen_ksdae',
// //     'no_sk_menteri_lhk', 'perilaku_satwa', 'jenis_kelamin', 'id_tagging', 'kode_tagging',
// //     'alasan_belum_tagging', 'berita_acara_tagging', 'nama_lokal', 'nama_panggilan', 'class',
// //     'genus', 'spesies', 'sub_spesies', 'jumlah_keseluruhan_gender'
// // ];

    
    
//     // public function store(Request $request){
//     // //     $validator = validator::make($request->all(),[
//     // //         'file' => 'required|file|mimes:csv',
//     // //     ]);

//     // //     Excel::import(new DataImport, request()->file('file'));
//     // }

//     /**
//      * Display the specified resource.
//      */
//     public function show(Satwa $Satwa)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(Satwa $Satwa)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(UpdateSatwaRequest $request, Satwa $Satwa)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(Satwa $Satwa)
//     {
//         //
//     }

//     //daftar satwa
//     public function form(Request $request){

//         $users = User::with('lk','role', 'upt', 'spesies')->find(Auth::id());
//         // $satwas = Satwa::with('lk')->get();
//         $classes = ListSpecies::select('class')->distinct()->pluck('class');
//         $genus = ListSpecies::select('genus')->distinct()->pluck('genus');
//         $spesies = ListSpecies::select('spesies')->distinct()->pluck('spesies');
//         $subSpesies = ListSpecies::select('subspesies')->distinct()->pluck('subspesies');
//         $lks = LembagaKonservasi::select('id','nama')->get();
//         $taggings = Tagging::select('jenis_tagging')->distinct()->pluck('jenis_tagging')->map(fn($tag) => ucfirst(strtolower($tag)))
//         ->toArray();

//         if ($request->ajax()) {
//             // Filter data berdasarkan parameter yang dikirim
//             if ($request->has('class')) {
//                 $genus = ListSpecies::where('class', $request->class)->pluck('genus');
//                 return response()->json($genus);
//             }
//             if ($request->has('genus')) {
//                 $species = ListSpecies::where('genus', $request->genus)->pluck('spesies');
//                 return response()->json($species);
//             }
//             if ($request->has('species')) {
//                 $subSpecies = ListSpecies::where('spesies', $request->species)->pluck('subspesies');
//                 return response()->json($subSpecies);
//             }
//         }
//         // dd($lks);
//         return view('pages.forms.pendataan-satwa', compact('lks','users','classes','genus','spesies','subSpesies', 'taggings'));
//     }  

    public function pendataanSatwaTitipan(){
        return view('pages.forms.pendataan-satwa-titipan');
    }

    public function storeSatwaTitipan(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'nama_ilmiah' => 'required|string|max:255',
            'nama_lokal' => 'required|string|max:255',
            'english_name' => 'required|string|max:255',
            'no_bap_titipan' => 'required|string|max:255',
            'asal_satwa' => 'required|string|max:255',
            'jumlah_satwa_jantan' => 'required|integer',
            'jumlah_satwa_betina' => 'required|integer',
            'jumlah_satwa_unknown' => 'required|integer',
            'bap_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
    
        // Handle file upload
        $bapFilePath = null;
        if ($request->hasFile('bap_file')) {
            $bapFile = $request->file('bap_file');
            $bapFilePath = $bapFile->storeAs('bap_files', time() . '.' . $bapFile->getClientOriginalExtension());
        }
    
        // Store data in the database
        $satwa = new Satwa();
        $satwa->nama_ilmiah = $validatedData['nama_ilmiah'];
        $satwa->nama_lokal = $validatedData['nama_lokal'];
        $satwa->english_name = $validatedData['english_name'];
        $satwa->no_bap_titipan = $validatedData['no_bap_titipan'];
        $satwa->asal_satwa = $validatedData['asal_satwa'];
        $satwa->jumlah_satwa_jantan = $validatedData['jumlah_satwa_jantan'];
        $satwa->jumlah_satwa_betina = $validatedData['jumlah_satwa_betina'];
        $satwa->jumlah_satwa_unknown = $validatedData['jumlah_satwa_unknown'];
        $satwa->bap_file = $bapFilePath;  // Store file path if uploaded
    
        $satwa->save();
    
        return redirect()->route('pendataan-satwa-titipan')
                         ->with('success', 'Data Satwa Titipan berhasil disimpan.');
    }
    

    public function daftarSatwaTitipan()
    {
        $satwaTitipan = Satwa::all(); 
        return view('pages.satwa.daftar-satwa-titipan', compact('satwaTitipan'));
    }

    // public function updateDashboard(){
    // try {
    //     $class = ListSpecies::select('class')->get()->map(function ($item) {
    //         return strtolower($item->class);
    //     });

    //     $jenis_tagging = Tagging::select('jenis_tagging')->get()->map(function($item){
    //         return strtolower( $item->jenis_tagging);
    //     });

    //     $jenis_koleksi = Satwa::select('jenis_koleksi')->get()->map(function($item){
    //         return $item->jenis_koleksi;
    //     });

    //     // $spesies = ListSpecies::select('spesies')->get()->map(function($item){
    //     //     return strtolower( $item->spesies);
    //     // });

    //     $spesies = Satwa::with('species')->select('');

    //     // $spesies = ListSpecies::withCount(['satwas as jumlah_individu'])
    //     //     ->get(['nama_ilmiah', 'jumlah_individu']);

    //     return response()->json([

    //     ]);
    // } catch (\Exception $e) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => $e->getMessage()
    //     ], 500);
    // }
    // }
}