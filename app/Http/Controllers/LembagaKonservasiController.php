<?php

namespace App\Http\Controllers;

<<<<<<< Updated upstream
use App\Models\LembagaKonservasi;
use App\Http\Requests\StoreLembagaKonservasiRequest;
use App\Http\Requests\UpdateLembagaKonservasiRequest;
use App\Imports\LembagaKonservasiImport;
use App\Models\MonitoringInvestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
=======
use App\Models\ListUpt;
use App\Models\RiwayatLk;
use App\Models\Verifikasi;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\DB;
use App\Models\MonitoringInvestasi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\LembagaKonservasiUpdated;
use App\Imports\LembagaKonservasiImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreLembagaKonservasiRequest;
use App\Http\Requests\UpdateLembagaKonservasiRequest;
use Illuminate\Auth\Middleware\Authorize;
>>>>>>> Stashed changes

class LembagaKonservasiController extends Controller
{

    public function index(Request $request){
        $this->authorize('view',LembagaKonservasi::class);
        // session()->forget('ListLK');
        session()->forget('url');
        session()->forget('query');

        $urls = $request->fullUrl();
        session(['url' =>$urls ]);
        $status = 1;

        session(['status_search'=>1]);

        $ListLK = LembagaKonservasi::with('upt')->where('status',1)->paginate(50);
        return view('pages.lk.daftar-lk', compact('ListLK','status'));
    }

<<<<<<< Updated upstream
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLembagaKonservasiRequest $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:lembaga_konservasi,slug',
            'id_upt' => 'required|exists:units,id',
            'alamat' => 'required|string',
            'provinsi' => 'required|string|max:50',
            'kota_kab' => 'required|string|max:50',
            'kelurahan' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'kode_pos' => 'required|string|size:5',
            'tahun_izin' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'no_izin_peroleh' => 'required|string|max:255',
            'link_sk' => 'nullable|url',
            'legalitas_perizinan' => 'required|string|max:255',
            'nomor_tanggal_surat' => 'required|string|max:255',
            'bentuk_lk' => 'required|string|max:50',
            'pengelola' => 'required|string|max:20',
            'nama_pimpinan' => 'required|string|max:255',
            'izin_perolehan_tsl' => 'nullable|string',
            'tahun_akreditasi' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'nilai_akreditasi' => 'required|string|size:2',
            'pks_dengan_lk_lain' => 'nullable|string'
        ]);
    
        LembagaKonservasi::create($validatedData);
    
        return redirect()->route('lk.index')->with('success', 'Lembaga Konservasi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    
    public function show(LembagaKonservasi $lembagaKonservasi)
    {
        return view('lk.show', compact('lembagaKonservasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LembagaKonservasi $lembagaKonservasi)
    {
        return view('lk.edit', compact('lembagaKonservasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLembagaKonservasiRequest $request, LembagaKonservasi $lembagaKonservasi)
    {
        // Validate and update existing Lembaga Konservasi entry
        $validatedData = $request->validated();
        $lembagaKonservasi->update($validatedData);

        return redirect()->route('lk.index')->with('success', 'Lembaga Konservasi updated successfully.');
    }

    
    public function destroy(LembagaKonservasi $lembagaKonservasi)
    {
        $lembagaKonservasi->delete();

        return redirect()->route('lk.index')->with('success', 'Lembaga Konservasi deleted successfully.');
=======
    public function create(){
        $this->authorize('view',LembagaKonservasi::class);
        session()->forget('update');
        
        $listupt = ListUpt::select('id','wilayah')->distinct()->orderby('wilayah', 'asc')->get();
        return view('pages.lk.form-lk',compact('listupt'));
    }

    public function store(Request $request){
        // dd($request->all());
        $this->authorize('create', LembagaKonservasi::class);

        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'bentuk_lk' => 'required|string|max:50',
                'nib' => 'required|string',
                'npwp' => 'required|string',
                'id_upt' => 'required',
                'nama_direktur' => 'required|string|max:255',
                'email' => 'required|email|unique:lembaga_konservasis',
                'no_telp' => 'required|string|unique:lembaga_konservasis',
                'kode_pos' => 'required|string|size:5',
                'provinsi' => 'required|string|max:50',
                'kota_kab' => 'required|string|max:50',
                'kecamatan' => 'required|string|max:50',
                'kelurahan' => 'required|string|max:50',
                'alamat' => 'required|string',
                'luas_wilayah' => 'required|',
                'jumlah_investasi' => 'required|',
                'jumlah_tenaga_kerja' => 'required|integer',
                'doc_site_plan' => 'required|file|mimes:pdf|max:10240',
                'doc_persetujuan_lingkungan' => 'required|file|mimes:pdf|max:10240',
                'doc_draft_rkp' => 'required|file|mimes:pdf|max:10240',
                'doc_surat_permohonan' => 'required|file|mimes:pdf|max:10240',
            ],[
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa teks (karakter a-z, A-Z, 0-9).',
                'email' => ':attribute harus berformat email yang valid.',
                'unique' => ':attribute sudah digunakan. Harap masukkan yang lain.',
                'size' => ':attribute harus berukuran :size karakter.',
                'integer' => ':attribute harus berupa angka.',
                'file.mimes' => 'File untuk :attribute harus berformat PDF.',
                'file.max' => 'Ukuran file untuk :attribute maksimal 10 MB.',
                'max' => ':attribute tidak boleh lebih dari :max karakter.',
            ], [
                'nama' => 'Nama lembaga konservasi',
                'bentuk_lk' => 'Bentuk lembaga konservasi',
                'nib' => 'Nomor Induk Berusaha (NIB)',
                'npwp' => 'Nomor Pokok Wajib Pajak (NPWP)',
                'id_upt' => 'ID UPT',
                'nama_direktur' => 'Nama Direktur',
                'email' => 'Email',
                'no_telp' => 'Nomor Telepon',
                'kode_pos' => 'Kode Pos',
                'provinsi' => 'Provinsi',
                'kota_kab' => 'Kota/Kabupaten',
                'kecamatan' => 'Kecamatan',
                'kelurahan' => 'Kelurahan/Desa',
                'alamat' => 'Alamat',
                'luas_wilayah' => 'Luas Wilayah',
                'jumlah_investasi' => 'Jumlah Investasi',
                'jumlah_tenaga_kerja' => 'Jumlah Tenaga Kerja',
                'doc_site_plan' => 'Dokumen Site Plan',
                'doc_persetujuan_lingkungan' => 'Dokumen Persetujuan Lingkungan',
                'doc_draft_rkp' => 'Dokumen Draft RKP',
                'doc_surat_permohonan' => 'Dokumen Surat Permohonan',
            ]);
            

            $jumlah_investasi = str_replace('.', '', $request->input('jumlah_investasi'));
            $validatedData['jumlah_investasi'] = (float) $jumlah_investasi;
            $validatedData['path_site_plan'] = $request->file('doc_site_plan')->store('public/uploads/site_plan');
            $validatedData['doc_site_plan'] = $request->file('doc_site_plan')->getClientOriginalName();
            $validatedData['path_persetujuan_lingkungan'] = $request->file('doc_persetujuan_lingkungan')->store('public/uploads/persetujuan_lingkungan_lk');
            $validatedData['doc_persetujuan_lingkungan'] = $request->file('doc_persetujuan_lingkungan')->getClientOriginalName();
            $validatedData['path_draft_rkp'] = $request->file('doc_draft_rkp')->store('public/uploads/draft_rkp');
            $validatedData['doc_draft_rkp'] = $request->file('doc_draft_rkp')->getClientOriginalName();
            $validatedData['path_surat_permohonan'] = $request->file('doc_surat_permohonan')->store('public/uploads/surat_permohonan_lk');
            $validatedData['doc_surat_permohonan'] = $request->file('doc_surat_permohonan')->getClientOriginalName();
            $validatedData['slug'] = Str::slug($validatedData['nama']);
            // dd($validatedData);
            $data = LembagaKonservasi::create($validatedData);
            
            Verifikasi::create([
                'id_lk' => $data->id,
                'id_user' => Auth::user()->id,
                'status' => 'in progress',
                'keterangan' => 'Berkas masuk'
            ]);

            RiwayatLk::create([
                'id_user' => Auth::user()->id,
                'nama' => $data->nama,
                'action'=> 'create',
                'keterangan' => 'membuat lk baru',
            ]);
            
            session()->flash('notification',[
                'succes' => true,
                'message' => 'Pengajuan telah berhasil diinput',
            ]);

            DB::commit();

            
            return redirect()->route('daftar-pengajuan-lk');

        } catch (\Illuminate\Validation\ValidationException $exception) {
            // DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $exception->errors()
            ], 422);
        } catch (\Exception $exception) {
            // DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    
    public function update(Request $request, LembagaKonservasi $id) {
        $this->authorize('update', $id);
        DB::beginTransaction();
        // dd($id);
        $this->authorize('update',$id);
        try {
            $validateData = $request->validate([
                'nama' => 'required|string|max:255',
                'bentuk_lk' => 'required|string|max:50',
                'nib' => 'required|string',
                'npwp' => 'required|string',
                'id_upt' => 'required',
                'nama_direktur' => 'required|string|max:255',
                'email' => 'required|email|',
                'no_telp' => 'required|string|',
                'kode_pos' => 'required|string|size:5',
                'provinsi' => 'required|string|max:50',
                'kota_kab' => 'required|string|max:50',
                'kecamatan' => 'required|string|max:50',
                'kelurahan' => 'required|string|max:50',
                'alamat' => 'required|string',
                'luas_wilayah' => 'required|',
                'jumlah_investasi' => 'required|',
                'jumlah_tenaga_kerja' => 'required|integer',
                'doc_site_plan' => 'nullable|file|mimes:pdf|max:10240',
                'doc_persetujuan_lingkungan' => 'nullable|file|mimes:pdf|max:10240',
                'doc_draft_rkp' => 'nullable|file|mimes:pdf|max:10240',
                'doc_surat_permohonan' => 'nullable|file|mimes:pdf|max:10240',
            ],[
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa teks (karakter a-z, A-Z, 0-9).',
                'email' => ':attribute harus berformat email yang valid.',
                'unique' => ':attribute sudah digunakan. Harap masukkan yang lain.',
                'size' => ':attribute harus berukuran :size karakter.',
                'integer' => ':attribute harus berupa angka.',
                'file.mimes' => 'File untuk :attribute harus berformat PDF.',
                'file.max' => 'Ukuran file untuk :attribute maksimal 10 MB.',
                'max' => ':attribute tidak boleh lebih dari :max karakter.',
            ], [
                'nama' => 'Nama lembaga konservasi',
                'bentuk_lk' => 'Bentuk lembaga konservasi',
                'nib' => 'Nomor Induk Berusaha (NIB)',
                'npwp' => 'Nomor Pokok Wajib Pajak (NPWP)',
                'id_upt' => 'ID UPT',
                'nama_direktur' => 'Nama Direktur',
                'email' => 'Email',
                'no_telp' => 'Nomor Telepon',
                'kode_pos' => 'Kode Pos',
                'provinsi' => 'Provinsi',
                'kota_kab' => 'Kota/Kabupaten',
                'kecamatan' => 'Kecamatan',
                'kelurahan' => 'Kelurahan/Desa',
                'alamat' => 'Alamat',
                'luas_wilayah' => 'Luas Wilayah',
                'jumlah_investasi' => 'Jumlah Investasi',
                'jumlah_tenaga_kerja' => 'Jumlah Tenaga Kerja',
                'doc_site_plan' => 'Dokumen Site Plan',
                'doc_persetujuan_lingkungan' => 'Dokumen Persetujuan Lingkungan',
                'doc_draft_rkp' => 'Dokumen Draft RKP',
                'doc_surat_permohonan' => 'Dokumen Surat Permohonan',
            ]);

            $jumlah_investasi = str_replace('.', '', $request->input('jumlah_investasi'));
            $validateData['jumlah_investasi'] = $jumlah_investasi;
            
            if ($request->hasFile('doc_site_plan')) {
                if ($id->doc_site_plan && file_exists(storage_path($id->doc_site_plan))) {
                    unlink(storage_path($id->doc_site_plan));
                }
                $validateData['doc_site_plan'] = $request->file('doc_site_plan')->getClientOriginalName();
                $validateData['path_site_plan'] = $request->file('doc_site_plan')->store('public/uploads/site_plan');
            }
            if ($request->hasFile('doc_persetujuan_lingkungan')) {
                if ($id->doc_persetujuan_lingkungan && file_exists(storage_path($id->doc_persetujuan_lingkungan))) {
                    unlink(storage_path($id->doc_persetujuan_lingkungan));
                }
                $validateData['doc_persetujuan_lingkungan'] = $request->file('doc_persetujuan_lingkungan')->getClientOriginalName();
                $validateData['path_persetujuan_lingkungan'] = $request->file('doc_persetujuan_lingkungan')->store('public/uploads/persetujuan_lingakungan_lk');
            }
            if ($request->hasFile('doc_draft_rkp')) {
                if ($id->doc_draft_rkp && file_exists(storage_path($id->doc_draft_rkp))) {
                    unlink(storage_path($id->doc_draft_rkp));
                }
                $validateData['doc_draft_rkp'] = $request->file('doc_draft_rkp')->getClientOriginalName();
                $validateData['path_draft_rkp'] = $request->file('doc_draft_rkp')->store('public/uploads/draft_rkp');
            }
            if ($request->hasFile('doc_surat_pemohonan')) {
                if ($id->doc_surat_pemohonan && file_exists(storage_path($id->doc_surat_pemohonan))) {
                    unlink(storage_path($id->doc_surat_pemohonan));
                }
                $validateData['doc_surat_pemohonan'] = $request->file('doc_surat_pemohonan')->getClientOriginalName();
                $validateData['path_surat_permohonan'] = $request->file('doc_surat_pemohonan')->store('public/uploads/surat_permohonan_lk');
            }

            $datalama =$id->toArray();
            $databaru = $validateData;
            $datalama = Arr::except($datalama,['id']);
            $changes = array_diff_assoc($databaru, $datalama);
            // dd($changes);

            if ($changes) {

                if(array_key_exists('nama', $changes)){
                    $changes['slug'] = Str::slug($changes['nama']);
                }
                $user = Auth::user()->nama_lengkap;
                $id_user = Auth::user()->id;

                $id->update($changes);
        
                session()->flash('notification', [
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Terima kasih, ' . $user . '. Data ' . $id->nama . ' Perubahan telah disimpan ke sistem.',
                ]);

                $columnMap = [
                    'nama' => 'Nama lembaga konservasi',
                    'bentuk_lk' => 'Bentuk lembaga konservasi',
                    'nib' => 'Nomor Induk Berusaha (NIB)',
                    'npwp' => 'Nomor Pokok Wajib Pajak (NPWP)',
                    'id_upt' => 'ID UPT',
                    'nama_direktur' => 'Nama Direktur',
                    'email' => 'Email',
                    'no_telp' => 'Nomor Telepon',
                    'kode_pos' => 'Kode Pos',
                    'provinsi' => 'Provinsi',
                    'kota_kab' => 'Kota/Kabupaten',
                    'kecamatan' => 'Kecamatan',
                    'kelurahan' => 'Kelurahan/Desa',
                    'alamat' => 'Alamat',
                    'luas_wilayah' => 'Luas Wilayah',
                    'jumlah_investasi' => 'Jumlah Investasi',
                    'jumlah_tenaga_kerja' => 'Jumlah Tenaga Kerja',
                    'doc_site_plan' => 'Dokumen Site Plan',
                    'doc_persetujuan_lingkungan' => 'Dokumen Persetujuan Lingkungan',
                    'doc_draft_rkp' => 'Dokumen Draft RKP',
                    'doc_surat_permohonan' => 'Dokumen Surat Permohonan',
                ];

                $atribut = [];
                foreach (array_keys($changes) as $column) {
                    if (isset($columnMap[$column])) {
                        $atribut[] = $columnMap[$column]; 
                    }
                }

                $label = implode(', ', $atribut);

                RiwayatLk::create([
                    'id_user' => $id_user,
                    'nama_lk' => $id->nama,
                    'action' => 'update',
                    'keterangan' => 'melakukan perubahan pada: '. $label, 
                ]);
                // dd($id->nama);
                
                DB::commit();
            }
            
            $url = session('url');
            // dd($url);
            session()->forget('url');
            return redirect($url);
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('notification', [
                'success' => false,
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        
            return redirect()->back()->withInput();
        }
    }
    
    public function destroy(LembagaKonservasi $id){
        $this->authorize('view',LembagaKonservasi::class, LembagaKonservasi::class);

        DB::beginTransaction();
        try {
            $id_user = Auth::user()->id;
            $id->delete();
            
            RiwayatLk::create([
                'id_user' => $id_user,
                'nama_lk' => $id->nama,
                'action' => 'delete',
                'keterangan' => 'Menghapus satwa ' . $id->nama ,
            ]);
            
            // dd($id);
            session()->flash('notification',[
                'type' => 'success',
                'success' =>true,
                'message' => 'Pengajuan lembaga konservasi telah dihapus',
            ]);

            DB::commit();

            return response()->json([
                'type' => 'success',
                'success' => true,
                'message' => 'Pengajuan lembaga konservasi telah dihapus',
            ]);

            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Penghapusan Lembaga Konservasi gagal.',
                'error' => $e->getMessage()
            ], 403);
        }
    }   
    
    public function edit(LembagaKonservasi $id)
    {
        $this->authorize('update', $id);
        session(['update'=>true]);
        $listupt = ListUpt::select('id','wilayah')->distinct()->orderby('wilayah', 'asc')->get();
        $data = $id;
        return view('pages.lk.form-lk',compact('listupt','data'));
>>>>>>> Stashed changes
    }

    public function import(Request $request){
        $validatedFile = Validator::make($request->all(),[
            'file' =>'required|mimes:csv',
        ]);

        if($validatedFile->fails()){
            return redirect()->route('lk.create')
                    ->withErrors($validatedFile)
                    ->withInput();
        }
        try{
            Excel::import(new LembagaKonservasiImport, $request->file('file'));
            
            return redirect()->route('lk.index')->with('Success', 'File/Data import berhasil');
        }catch(\Exception$e){
            return redirect()->with('Failed', "File/Data import gagal!");
        }
    }

    public function search(Request $request){
        $this->authorize('view',LembagaKonservasi::class);
        session()->forget('url');
        session()->forget('query');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);
        // dd(session('status_search'));

        $request->validate([
            'query' => 'required|string|min:1',
        ]);
        $query = $request->input('query');
    
        $status = session('status_search');
        
        $data = LembagaKonservasi::where('status', $status) //
        ->where(function($q) use ($query) {
            $q->where('nama', 'like', "%$query%")
                ->orWhere('nib', 'like', "%$query%")
                ->orWhere('npwp', 'like', "%$query%")
                ->orWhere('email', $query)
                ->orWhere('no_telp', $query) 
                ->orWhere('nama_direktur', 'like', "%$query%")
                ->orWhere('slug', 'like', "%$query%");
        })
        ->paginate(50);
        return view('pages.lk.search-daftar-lk', compact('data', 'query','status'));
    }

    public function submission(Request $request){
        // dd($request->user());
        $this->authorize('view',LembagaKonservasi::class);

        session()->forget('url');
        $urls = $request->Url();
        session(['url' =>$urls ]);
        
        session(['status_search'=> 0]);

        $data = LembagaKonservasi::where('status', 0)
        ->select('id','nama','nama_direktur','nib','npwp','email', 
        // 'no_telp','bentuk_lk','alamat','jumlah_tenaga_kerja')
        'no_telp','bentuk_lk','alamat','jumlah_investasi', 'jumlah_tenaga_kerja')
        ->orderby('nama','asc')
        ->paginate(50);

        $status = 0;

        return view('pages.lk.daftar-pengajuan-lk',compact(['data','status']));
    }

    public function detailSubmission(LembagaKonservasi $id, $statusForm,Request $request){
        $this->authorize('detail',$id);
        
        session()->forget('url');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);
        // dd($id->id);
        // dd(Auth::user()->role->tag);
        $timeline = Verifikasi::where('id_lk',$id->id)->orderBy('id','asc')->get();
        $status = Verifikasi::where('id_lk',$id->id)->orderBy('id','desc')->select('status')->first();
        
        // dd($status);
        $data = $id;
        return view('pages.LK.detail-pengajuan-lk',compact(['data','timeline','status','statusForm']));
    }

    
    
}