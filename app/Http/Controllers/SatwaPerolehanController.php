<?php

namespace App\Http\Controllers;

use App\Models\Satwa;
use App\Models\Verifikasi;
use App\Models\ListSpecies;
use Illuminate\Support\Arr;
use App\Models\RiwayatSatwa;
use Illuminate\Http\Request;
use App\Models\SatwaPerolehan;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\ListCaraSatwaPerolehan;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSatwaPerolehanRequest;
use App\Http\Requests\UpdateSatwaPerolehanRequest;

class SatwaPerolehanController extends Controller
{
 
    public function index()
    {
        session()->forget('satwaPerolehan');
        session()->forget('url');

        $satwaPerolehan = SatwaPerolehan::with(['lk', 'asallk'])->where('status', 1);
        $status =  1;
        foreach ($satwaPerolehan as $satwa) {
            $satwa->doc_lainnya = $satwa->doc_lainnya ? json_decode($satwa->doc_lainnya, true) : [];
        }

        if(Auth::user()->role->tag == 'LK'){
            $satwaPerolehan = $satwaPerolehan->where('id_lk', Auth::user()->id_lk);
        }

        $satwaPerolehan = $satwaPerolehan->paginate(50);

        return view('pages.satwa.daftar-pengajuan-perolehan',compact('satwaPerolehan','status'));
    
    }

    public function create()
    {
        $this->authorize('create',SatwaPerolehan::class);
        session()->forget('update');
        $caraPerolehan = ListCaraSatwaPerolehan::get();
        $listlk = LembagaKonservasi::select('id','nama')->get();
        $namaIlmiah = ListSpecies::select('id', 'nama_ilmiah')->distinct()->get();
        return view('pages.satwa.form-pengajuan-perolehan', compact(['caraPerolehan','listlk','namaIlmiah']));
   
    }

    public function store($id,Request $request)
    {
        // $id = Crypt::decryptString($request->input('id'));
        // dd($request->all());
        $this->authorize('create',SatwaPerolehan::class);

        DB::beginTransaction();
        try {
            $validateData = $request->validate([
                'asal_satwa' => 'required|in:indonesia,asing',
                'status_perlindungan' => 'required|in:0,1',
                'id_spesies' => 'required|exists:list_species,id',
                'nama_cara_perolehan' => 'required|string|exists:list_cara_satwa_perolehans,nama',
                'id_cara_perolehan' => 'required|exists:list_cara_satwa_perolehans,id',
                'asal_lk' => 'required_if:nama_cara_perolehan,hibah pemberian/sumbangan|
                            required_if:nama_cara_perolehan,tukar menukar|
                            required_if:nama_cara_perolehan,peminjaman|',
                            // exists:lembaga_konservasis,id',
    
                'jumlah_jantan' => 'required|numeric|min:0',
                'jumlah_betina' => 'required|numeric|min:0',
                'jumlah_unknown' => 'required|numeric|min:0',
    
                'doc_surat_permohonan' => 'nullable|file|mimes:pdf|max:10240',
                'doc_berita_acara_pemeriksaan_sarana' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima' => 'nullable|file|mimes:pdf|max:10240',
                'doc_berita_acara_pemeriksaan_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_surat_keterangan_kesehatan_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_keterangan_asal_usul_silsilah_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_surat_keterangan_menerima_hibah' => 'nullable|file|mimes:pdf|max:10240',
                'doc_surat_keterangan_memberi_hibah' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_scientific_authority_appendix_i_cites' => 'nullable|file|mimes:pdf|max:10240',
                'doc_salinan_keputusan_pengadilan' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_kepala_b_bksda_asal_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_dokumen_kerja_sama' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_bbksda_domisili_asal' => 'nullable|file|mimes:pdf|max:10240',
                'doc_pnbp' => 'nullable|file|mimes:pdf|max:10240',
                'dokumen_lainnya' => 'nullable|array',
            ],[
                'asal_satwa.required' => 'Asal satwa harus dipilih.',
                'asal_satwa.in' => 'Asal satwa harus berupa salah satu dari: indonesia, asing.',
                
                'status_perlindungan.required' => 'Status perlindungan harus dipilih.',
                'status_perlindungan.in' => 'Status perlindungan harus berupa salah satu dari: Dilindungi, Tidak Dilindungi.',
                
                'id_spesies.required' => 'Nama ilmiah harus dipilih.',
                'id_spesies.exists' => 'Nama ilmiah yang dipilih tidak valid.',
                
                'nama_cara_perolehan.required' => 'Cara perolehan harus dipilih.',
                'nama_cara_perolehan.string' => 'Cara perolehan harus berupa string.',
                'nama_cara_perolehan.exists' => 'Cara perolehan yang dipilih tidak valid.',
                
                'id_cara_perolehan.required' => 'ID cara perolehan harus dipilih.',
                'id_cara_perolehan.exists' => 'ID cara perolehan yang dipilih tidak valid.',
                
                'asal_lk.required_if' => 'Nama lembaga konservasi harus dipilih jika cara perolehan adalah hibah, tukar menukar, atau peminjaman.',
                
                'jumlah_jantan.required' => 'Jumlah jantan harus diisi.',
                'jumlah_jantan.numeric' => 'Jumlah jantan harus berupa angka.',
                'jumlah_jantan.min' => 'Jumlah jantan tidak boleh kurang dari 0.',
                
                'jumlah_betina.required' => 'Jumlah betina harus diisi.',
                'jumlah_betina.numeric' => 'Jumlah betina harus berupa angka.',
                'jumlah_betina.min' => 'Jumlah betina tidak boleh kurang dari 0.',
                
                'jumlah_unknown.required' => 'Jumlah unknown harus diisi.',
                'jumlah_unknown.numeric' => 'Jumlah unknown harus berupa angka.',
                'jumlah_unknown.min' => 'Jumlah unknown tidak boleh kurang dari 0.',
                
                'doc_surat_permohonan.file' => 'Dokumen Surat Permohonan harus berupa file.',
                'doc_surat_permohonan.mimes' => 'Dokumen Surat Permohonan hanya boleh berupa file PDF.',
                'doc_surat_permohonan.max' => 'Dokumen Surat Permohonan tidak boleh lebih dari 10MB.',
                
                'doc_berita_acara_pemeriksaan_sarana.file' => 'Dokumen Berita Acara Sarana harus berupa file.',
                'doc_berita_acara_pemeriksaan_sarana.mimes' => 'Dokumen Berita Acara Sarana hanya boleh berupa file PDF.',
                'doc_berita_acara_pemeriksaan_sarana.max' => 'Dokumen Berita Acara Sarana tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima.file' => 'Dokumen Rekomendasi BBKSDA Pemohon harus berupa file.',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima.mimes' => 'Dokumen Rekomendasi BBKSDA Pemohon hanya boleh berupa file PDF.',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima.max' => 'Dokumen Rekomendasi BBKSDA Pemohon tidak boleh lebih dari 10MB.',
                
                'doc_berita_acara_pemeriksaan_satwa.file' => 'Dokumen Berita Acara Satwa harus berupa file.',
                'doc_berita_acara_pemeriksaan_satwa.mimes' => 'Dokumen Berita Acara Satwa hanya boleh berupa file PDF.',
                'doc_berita_acara_pemeriksaan_satwa.max' => 'Dokumen Berita Acara Satwa tidak boleh lebih dari 10MB.',
                
                'doc_surat_keterangan_kesehatan_satwa.file' => 'Dokumen Surat Kesehatan Satwa harus berupa file.',
                'doc_surat_keterangan_kesehatan_satwa.mimes' => 'Dokumen Surat Kesehatan Satwa hanya boleh berupa file PDF.',
                'doc_surat_keterangan_kesehatan_satwa.max' => 'Dokumen Surat Kesehatan Satwa tidak boleh lebih dari 10MB.',
                
                'doc_keterangan_asal_usul_silsilah_satwa.file' => 'Dokumen Keterangan Asal Silsilah harus berupa file.',
                'doc_keterangan_asal_usul_silsilah_satwa.mimes' => 'Dokumen Keterangan Asal Silsilah hanya boleh berupa file PDF.',
                'doc_keterangan_asal_usul_silsilah_satwa.max' => 'Dokumen Keterangan Asal Silsilah tidak boleh lebih dari 10MB.',
                
                'doc_surat_keterangan_menerima_hibah.file' => 'Dokumen Surat Menerima Hibah harus berupa file.',
                'doc_surat_keterangan_menerima_hibah.mimes' => 'Dokumen Surat Menerima Hibah hanya boleh berupa file PDF.',
                'doc_surat_keterangan_menerima_hibah.max' => 'Dokumen Surat Menerima Hibah tidak boleh lebih dari 10MB.',
                
                'doc_surat_keterangan_memberi_hibah.file' => 'Dokumen Surat Memberi Hibah harus berupa file.',
                'doc_surat_keterangan_memberi_hibah.mimes' => 'Dokumen Surat Memberi Hibah hanya boleh berupa file PDF.',
                'doc_surat_keterangan_memberi_hibah.max' => 'Dokumen Surat Memberi Hibah tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa.file' => 'Dokumen Rekomendasi BBKSDA Asal harus berupa file.',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa.mimes' => 'Dokumen Rekomendasi BBKSDA Asal hanya boleh berupa file PDF.',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa.max' => 'Dokumen Rekomendasi BBKSDA Asal tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_scientific_authority_appendix_i_cites.file' => 'Dokumen Rekomendasi Scientific Authority harus berupa file.',
                'doc_rekomendasi_scientific_authority_appendix_i_cites.mimes' => 'Dokumen Rekomendasi Scientific Authority hanya boleh berupa file PDF.',
                'doc_rekomendasi_scientific_authority_appendix_i_cites.max' => 'Dokumen Rekomendasi Scientific Authority tidak boleh lebih dari 10MB.',
                
                'doc_salinan_keputusan_pengadilan.file' => 'Dokumen Salinan Keputusan Pengadilan harus berupa file.',
                'doc_salinan_keputusan_pengadilan.mimes' => 'Dokumen Salinan Keputusan Pengadilan hanya boleh berupa file PDF.',
                'doc_salinan_keputusan_pengadilan.max' => 'Dokumen Salinan Keputusan Pengadilan tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_kepala_b_bksda_asal_satwa.file' => 'Dokumen Rekomendasi BBKSDA Asal Satwa harus berupa file.',
                'doc_rekomendasi_kepala_b_bksda_asal_satwa.mimes' => 'Dokumen Rekomendasi BBKSDA Asal Satwa hanya boleh berupa file PDF.',
                'doc_rekomendasi_kepala_b_bksda_asal_satwa.max' => 'Dokumen Rekomendasi BBKSDA Asal Satwa tidak boleh lebih dari 10MB.',
                
                'doc_dokumen_kerja_sama.file' => 'Dokumen Dokumen Kerja Sama harus berupa file.',
                'doc_dokumen_kerja_sama.mimes' => 'Dokumen Dokumen Kerja Sama hanya boleh berupa file PDF.',
                'doc_dokumen_kerja_sama.max' => 'Dokumen Dokumen Kerja Sama tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_bbksda_domisili_asal.file' => 'Dokumen Rekomendasi BBKSDA Domisili Asal harus berupa file.',
                'doc_rekomendasi_bbksda_domisili_asal.mimes' => 'Dokumen Rekomendasi BBKSDA Domisili Asal hanya boleh berupa file PDF.',
                'doc_rekomendasi_bbksda_domisili_asal.max' => 'Dokumen Rekomendasi BBKSDA Domisili Asal tidak boleh lebih dari 10MB.',
                
                'doc_pnbp.file' => 'Dokumen PNBP harus berupa file.',
                'doc_pnbp.mimes' => 'Dokumen PNBP hanya boleh berupa file PDF.',
                'doc_pnbp.max' => 'Dokumen PNBP tidak boleh lebih dari 10MB.',
                
                'dokumen_lainnya.array' => 'Dokumen lainnya harus berupa array.',
            ]);
    
            $validateData['id_lk'] = Auth::user()->id_lk; ;
    
    
            if ($request->hasFile('doc_surat_permohonan')) {
                $validateData['doc_surat_permohonan'] = $request->file('doc_surat_permohonan')->getClientOriginalName();
                $validateData['path_surat_permohonan'] = $request->file('doc_surat_permohonan')->store('public/uploads/satwa_perolehan/surat_permohonan');
            }
    
            if ($request->hasFile('doc_berita_acara_pemeriksaan_sarana')) {
                $validateData['doc_berita_acara_pemeriksaan_sarana'] = $request->file('doc_berita_acara_pemeriksaan_sarana')->getClientOriginalName();
                $validateData['path_berita_acara_pemeriksaan_sarana'] = $request->file('doc_berita_acara_pemeriksaan_sarana')->store('public/uploads/satwa_perolehan/berita_acara_pemeriksaan_sarana');
            }
    
            if ($request->hasFile('doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima')) {
                $validateData['doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima'] = $request->file('doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima')->getClientOriginalName();
                $validateData['path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima'] = $request->file('doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima')->store('public/uploads/satwa_perolehan/rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima');
            }
    
            if ($request->hasFile('doc_berita_acara_pemeriksaan_satwa')) {
                $validateData['doc_berita_acara_pemeriksaan_satwa'] = $request->file('doc_berita_acara_pemeriksaan_satwa')->getClientOriginalName();
                $validateData['path_berita_acara_pemeriksaan_satwa'] = $request->file('doc_berita_acara_pemeriksaan_satwa')->store('public/uploads/satwa_perolehan/berita_acara_pemeriksaan_satwa');
            }
    
            if ($request->hasFile('doc_surat_keterangan_kesehatan_satwa')) {
                $validateData['doc_surat_keterangan_kesehatan_satwa'] = $request->file('doc_surat_keterangan_kesehatan_satwa')->getClientOriginalName();
                $validateData['path_surat_keterangan_kesehatan_satwa'] = $request->file('doc_surat_keterangan_kesehatan_satwa')->store('public/uploads/satwa_perolehan/surat_keterangan_kesehatan_satwa');
            }
    
            if ($request->hasFile('doc_keterangan_asal_usul_silsilah_satwa')) {
                $validateData['doc_keterangan_asal_usul_silsilah_satwa'] = $request->file('doc_keterangan_asal_usul_silsilah_satwa')->getClientOriginalName();
                $validateData['path_keterangan_asal_usul_silsilah_satwa'] = $request->file('doc_keterangan_asal_usul_silsilah_satwa')->store('public/uploads/satwa_perolehan/keterangan_asal_usul_silsilah_satwa');
            }
    
            if ($request->hasFile('doc_surat_keterangan_menerima_hibah')) {
                $validateData['doc_surat_keterangan_menerima_hibah'] = $request->file('doc_surat_keterangan_menerima_hibah')->getClientOriginalName();
                $validateData['path_surat_keterangan_menerima_hibah'] = $request->file('doc_surat_keterangan_menerima_hibah')->store('public/uploads/satwa_perolehan/surat_keterangan_menerima_hibah');
            }
    
            if ($request->hasFile('doc_surat_keterangan_memberi_hibah')) {
                $validateData['doc_surat_keterangan_memberi_hibah'] = $request->file('doc_surat_keterangan_memberi_hibah')->getClientOriginalName();
                $validateData['path_surat_keterangan_memberi_hibah'] = $request->file('doc_surat_keterangan_memberi_hibah')->store('public/uploads/satwa_perolehan/surat_keterangan_memberi_hibah');
            }
    
            if ($request->hasFile('doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa')) {
                $validateData['doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa'] = $request->file('doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa')->getClientOriginalName();
                $validateData['path_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa'] = $request->file('doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa')->store('public/uploads/satwa_perolehan/rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa');
            }
    
            if ($request->hasFile('doc_rekomendasi_scientific_authority_appendix_i_cites')) {
                $validateData['doc_rekomendasi_scientific_authority_appendix_i_cites'] = $request->file('doc_rekomendasi_scientific_authority_appendix_i_cites')->getClientOriginalName();
                $validateData['path_rekomendasi_scientific_authority_appendix_i_cites'] = $request->file('doc_rekomendasi_scientific_authority_appendix_i_cites')->store('public/uploads/satwa_perolehan/rekomendasi_scientific_authority_appendix_i_cites');
            }
    
            if ($request->hasFile('doc_rekomendasi_kepala_b_bksda_asal_satwa')) {
                $validateData['doc_rekomendasi_kepala_b_bksda_asal_satwa'] = $request->file('doc_rekomendasi_kepala_b_bksda_asal_satwa')->getClientOriginalName();
                $validateData['path_rekomendasi_kepala_b_bksda_asal_satwa'] = $request->file('doc_rekomendasi_kepala_b_bksda_asal_satwa')->store('public/uploads/satwa_perolehan/rekomendasi_kepala_b_bksda_asal_satwa');
            }
    
            if ($request->hasFile('doc_salinan_keputusan_pengadilan')) {
                $validateData['doc_salinan_keputusan_pengadilan'] = $request->file('doc_salinan_keputusan_pengadilan')->getClientOriginalName();
                $validateData['path_salinan_keputusan_pengadilan'] = $request->file('doc_salinan_keputusan_pengadilan')->store('public/uploads/satwa_perolehan/salinan_keputusan_pengadilan');
            }
    
            if ($request->hasFile('doc_dokumen_kerja_sama')) {
                $validateData['doc_dokumen_kerja_sama'] = $request->file('doc_dokumen_kerja_sama')->getClientOriginalName();
                $validateData['path_dokumen_kerja_sama'] = $request->file('doc_dokumen_kerja_sama')->store('public/uploads/satwa_perolehan/dokumen_kerja_sama');
            }
    
            if ($request->hasFile('doc_rekomendasi_bbksda_domisili_asal')) {
                $validateData['doc_rekomendasi_bbksda_domisili_asal'] = $request->file('doc_rekomendasi_bbksda_domisili_asal')->getClientOriginalName();
                $validateData['path_rekomendasi_bbksda_domisili_asal'] = $request->file('doc_rekomendasi_bbksda_domisili_asal')->store('public/uploads/satwa_perolehan/rekomendasi_bbksda_domisili_asal');
            }
    
            if ($request->hasFile('doc_pnbp')) {
                $validateData['doc_pnbp'] = $request->file('doc_pnbp')->getClientOriginalName();
                $validateData['path_pnbp'] = $request->file('doc_pnbp')->store('public/uploads/satwa_perolehan/pnbp');
            }
            
            if ($request->hasFile('dokumen_lainnya')) {
                $dokumen_lainnya = [];
                
                foreach ($request->file('dokumen_lainnya') as $file) {
                    $path = $file->store('public/uploads/satwa_perolehan/dokumen_lainnya');
                    $dokumen_lainnya[] = [
                        'nama' => $file->getClientOriginalName(),
                        'path' => $path
                    ];
                }
                $validateData ['dokumen_lainnya'] = json_encode($dokumen_lainnya,true);
            }
            // dd($validateData);
            $data = SatwaPerolehan::create($validateData);
            // dd($data);
            Verifikasi::create([
                'id_user' => Auth::user()->id,
                'id_satwa_perolehan' => $data->id,
                'status' => 'in progress',
                'keterangan' => 'Permohonan masuk',
            ]);
            
            DB::commit();

            session()->flash('notification',[
                'success' => true,
                'message' => 'Permohonan Satwa Perolehan Telah Berhasil Diinput',
            ]);
            // dd('berhasil');
    
            return redirect()->route('daftar-pengajuan-satwa-perolehan');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();

        }catch (\Exception $e) {
            DB::rollBack();
    
            session()->flash('notification', [
                'success' => false,
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
    
            return redirect()->back()->withInput();
        }
        


        // return redirect()->route('satwa-perolehan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(SatwaPerolehan $id)
    {
        $this->authorize('create',SatwaPerolehan::class);
        session(['update'=>true]);
        $data = $id;
        // dd($data->dokumen_lainnya);
    
        
        $caraPerolehan = ListCaraSatwaPerolehan::get();
        $listlk = LembagaKonservasi::select('id','nama')->get();
        $namaIlmiah = ListSpecies::select('id', 'nama_ilmiah')->distinct()->get();
        return view('pages.satwa.form-pengajuan-perolehan', compact(['data','caraPerolehan','listlk','namaIlmiah']));
    }

    public function update(SatwaPerolehan $id, Request $request)
    {
        $this->authorize('create',SatwaPerolehan::class);
        DB::beginTransaction();
        try {
            $validateData = $request->validate([
                'asal_satwa' => 'required|in:indonesia,asing',
                'status_perlindungan' => 'required|in:0,1',
                'id_spesies' => 'required|exists:list_species,id',
                'nama_cara_perolehan' => 'required|string|exists:list_cara_satwa_perolehans,nama',
                'id_cara_perolehan' => 'required|exists:list_cara_satwa_perolehans,id',
                'asal_lk' => 'required_if:nama_cara_perolehan,hibah pemberian/sumbangan|
                            required_if:nama_cara_perolehan,tukar menukar|
                            required_if:nama_cara_perolehan,peminjaman|',
                            // exists:lembaga_konservasis,id',
    
                'jumlah_jantan' => 'required|numeric|min:0',
                'jumlah_betina' => 'required|numeric|min:0',
                'jumlah_unknown' => 'required|numeric|min:0',
    
                'doc_surat_permohonan' => 'nullable|file|mimes:pdf|max:10240',
                'doc_berita_acara_pemeriksaan_sarana' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima' => 'nullable|file|mimes:pdf|max:10240',
                'doc_berita_acara_pemeriksaan_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_surat_keterangan_kesehatan_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_keterangan_asal_usul_silsilah_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_surat_keterangan_menerima_hibah' => 'nullable|file|mimes:pdf|max:10240',
                'doc_surat_keterangan_memberi_hibah' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_scientific_authority_appendix_i_cites' => 'nullable|file|mimes:pdf|max:10240',
                'doc_salinan_keputusan_pengadilan' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_kepala_b_bksda_asal_satwa' => 'nullable|file|mimes:pdf|max:10240',
                'doc_dokumen_kerja_sama' => 'nullable|file|mimes:pdf|max:10240',
                'doc_rekomendasi_bbksda_domisili_asal' => 'nullable|file|mimes:pdf|max:10240',
                'doc_pnbp' => 'nullable|file|mimes:pdf|max:10240',
                'dokumen_lainnya' => 'nullable|array',
            ],[
                'asal_satwa.required' => 'Asal satwa harus dipilih.',
                'asal_satwa.in' => 'Asal satwa harus berupa salah satu dari: indonesia, asing.',
                
                'status_perlindungan.required' => 'Status perlindungan harus dipilih.',
                'status_perlindungan.in' => 'Status perlindungan harus berupa salah satu dari: Dilindungi, Tidak Dilindungi.',
                
                'id_spesies.required' => 'Nama ilmiah harus dipilih.',
                'id_spesies.exists' => 'Nama ilmiah yang dipilih tidak valid.',
                
                'nama_cara_perolehan.required' => 'Cara perolehan harus dipilih.',
                'nama_cara_perolehan.string' => 'Cara perolehan harus berupa string.',
                'nama_cara_perolehan.exists' => 'Cara perolehan yang dipilih tidak valid.',
                
                'id_cara_perolehan.required' => 'ID cara perolehan harus dipilih.',
                'id_cara_perolehan.exists' => 'ID cara perolehan yang dipilih tidak valid.',
                
                'asal_lk.required_if' => 'Nama lembaga konservasi harus dipilih jika cara perolehan adalah hibah, tukar menukar, atau peminjaman.',
                
                'jumlah_jantan.required' => 'Jumlah jantan harus diisi.',
                'jumlah_jantan.numeric' => 'Jumlah jantan harus berupa angka.',
                'jumlah_jantan.min' => 'Jumlah jantan tidak boleh kurang dari 0.',
                
                'jumlah_betina.required' => 'Jumlah betina harus diisi.',
                'jumlah_betina.numeric' => 'Jumlah betina harus berupa angka.',
                'jumlah_betina.min' => 'Jumlah betina tidak boleh kurang dari 0.',
                
                'jumlah_unknown.required' => 'Jumlah unknown harus diisi.',
                'jumlah_unknown.numeric' => 'Jumlah unknown harus berupa angka.',
                'jumlah_unknown.min' => 'Jumlah unknown tidak boleh kurang dari 0.',
                
                'doc_surat_permohonan.file' => 'Dokumen Surat Permohonan harus berupa file.',
                'doc_surat_permohonan.mimes' => 'Dokumen Surat Permohonan hanya boleh berupa file PDF.',
                'doc_surat_permohonan.max' => 'Dokumen Surat Permohonan tidak boleh lebih dari 10MB.',
                
                'doc_berita_acara_pemeriksaan_sarana.file' => 'Dokumen Berita Acara Sarana harus berupa file.',
                'doc_berita_acara_pemeriksaan_sarana.mimes' => 'Dokumen Berita Acara Sarana hanya boleh berupa file PDF.',
                'doc_berita_acara_pemeriksaan_sarana.max' => 'Dokumen Berita Acara Sarana tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima.file' => 'Dokumen Rekomendasi BBKSDA Pemohon harus berupa file.',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima.mimes' => 'Dokumen Rekomendasi BBKSDA Pemohon hanya boleh berupa file PDF.',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima.max' => 'Dokumen Rekomendasi BBKSDA Pemohon tidak boleh lebih dari 10MB.',
                
                'doc_berita_acara_pemeriksaan_satwa.file' => 'Dokumen Berita Acara Satwa harus berupa file.',
                'doc_berita_acara_pemeriksaan_satwa.mimes' => 'Dokumen Berita Acara Satwa hanya boleh berupa file PDF.',
                'doc_berita_acara_pemeriksaan_satwa.max' => 'Dokumen Berita Acara Satwa tidak boleh lebih dari 10MB.',
                
                'doc_surat_keterangan_kesehatan_satwa.file' => 'Dokumen Surat Kesehatan Satwa harus berupa file.',
                'doc_surat_keterangan_kesehatan_satwa.mimes' => 'Dokumen Surat Kesehatan Satwa hanya boleh berupa file PDF.',
                'doc_surat_keterangan_kesehatan_satwa.max' => 'Dokumen Surat Kesehatan Satwa tidak boleh lebih dari 10MB.',
                
                'doc_keterangan_asal_usul_silsilah_satwa.file' => 'Dokumen Keterangan Asal Silsilah harus berupa file.',
                'doc_keterangan_asal_usul_silsilah_satwa.mimes' => 'Dokumen Keterangan Asal Silsilah hanya boleh berupa file PDF.',
                'doc_keterangan_asal_usul_silsilah_satwa.max' => 'Dokumen Keterangan Asal Silsilah tidak boleh lebih dari 10MB.',
                
                'doc_surat_keterangan_menerima_hibah.file' => 'Dokumen Surat Menerima Hibah harus berupa file.',
                'doc_surat_keterangan_menerima_hibah.mimes' => 'Dokumen Surat Menerima Hibah hanya boleh berupa file PDF.',
                'doc_surat_keterangan_menerima_hibah.max' => 'Dokumen Surat Menerima Hibah tidak boleh lebih dari 10MB.',
                
                'doc_surat_keterangan_memberi_hibah.file' => 'Dokumen Surat Memberi Hibah harus berupa file.',
                'doc_surat_keterangan_memberi_hibah.mimes' => 'Dokumen Surat Memberi Hibah hanya boleh berupa file PDF.',
                'doc_surat_keterangan_memberi_hibah.max' => 'Dokumen Surat Memberi Hibah tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa.file' => 'Dokumen Rekomendasi BBKSDA Asal harus berupa file.',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa.mimes' => 'Dokumen Rekomendasi BBKSDA Asal hanya boleh berupa file PDF.',
                'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa.max' => 'Dokumen Rekomendasi BBKSDA Asal tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_scientific_authority_appendix_i_cites.file' => 'Dokumen Rekomendasi Scientific Authority harus berupa file.',
                'doc_rekomendasi_scientific_authority_appendix_i_cites.mimes' => 'Dokumen Rekomendasi Scientific Authority hanya boleh berupa file PDF.',
                'doc_rekomendasi_scientific_authority_appendix_i_cites.max' => 'Dokumen Rekomendasi Scientific Authority tidak boleh lebih dari 10MB.',
                
                'doc_salinan_keputusan_pengadilan.file' => 'Dokumen Salinan Keputusan Pengadilan harus berupa file.',
                'doc_salinan_keputusan_pengadilan.mimes' => 'Dokumen Salinan Keputusan Pengadilan hanya boleh berupa file PDF.',
                'doc_salinan_keputusan_pengadilan.max' => 'Dokumen Salinan Keputusan Pengadilan tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_kepala_b_bksda_asal_satwa.file' => 'Dokumen Rekomendasi BBKSDA Asal Satwa harus berupa file.',
                'doc_rekomendasi_kepala_b_bksda_asal_satwa.mimes' => 'Dokumen Rekomendasi BBKSDA Asal Satwa hanya boleh berupa file PDF.',
                'doc_rekomendasi_kepala_b_bksda_asal_satwa.max' => 'Dokumen Rekomendasi BBKSDA Asal Satwa tidak boleh lebih dari 10MB.',
                
                'doc_dokumen_kerja_sama.file' => 'Dokumen Dokumen Kerja Sama harus berupa file.',
                'doc_dokumen_kerja_sama.mimes' => 'Dokumen Dokumen Kerja Sama hanya boleh berupa file PDF.',
                'doc_dokumen_kerja_sama.max' => 'Dokumen Dokumen Kerja Sama tidak boleh lebih dari 10MB.',
                
                'doc_rekomendasi_bbksda_domisili_asal.file' => 'Dokumen Rekomendasi BBKSDA Domisili Asal harus berupa file.',
                'doc_rekomendasi_bbksda_domisili_asal.mimes' => 'Dokumen Rekomendasi BBKSDA Domisili Asal hanya boleh berupa file PDF.',
                'doc_rekomendasi_bbksda_domisili_asal.max' => 'Dokumen Rekomendasi BBKSDA Domisili Asal tidak boleh lebih dari 10MB.',
                
                'doc_pnbp.file' => 'Dokumen PNBP harus berupa file.',
                'doc_pnbp.mimes' => 'Dokumen PNBP hanya boleh berupa file PDF.',
                'doc_pnbp.max' => 'Dokumen PNBP tidak boleh lebih dari 10MB.',
                
                'dokumen_lainnya.array' => 'Dokumen lainnya harus berupa array.',
            ]);

            if ($request->hasFile('doc_surat_permohonan')) {
                if ($id->doc_surat_permohonan && file_exists(storage_path($id->doc_surat_permohonan))) {
                    unlink(storage_path($id->doc_surat_permohonan));
                }
                $validateData['doc_surat_permohonan'] = $request->file('doc_surat_permohonan')->getClientOriginalName();
                $validateData['path_surat_permohonan'] = $request->file('doc_surat_permohonan')->store('public/uploads/barang_konservasi/surat_permohonan');
            }
            
            if ($request->hasFile('doc_berita_acara_pemeriksaan_sarana')) {
                if ($id->doc_berita_acara_pemeriksaan_sarana && file_exists(storage_path($id->doc_berita_acara_pemeriksaan_sarana))) {
                    unlink(storage_path($id->doc_berita_acara_pemeriksaan_sarana));
                }
                $validateData['doc_berita_acara_pemeriksaan_sarana'] = $request->file('doc_berita_acara_pemeriksaan_sarana')->getClientOriginalName();
                $validateData['path_berita_acara_pemeriksaan_sarana'] = $request->file('doc_berita_acara_pemeriksaan_sarana')->store('public/uploads/barang_konservasi/berita_acara_pemeriksaan_sarana');
            }
            
            if ($request->hasFile('doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima')) {
                if ($id->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima && file_exists(storage_path($id->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima))) {
                    unlink(storage_path($id->doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima));
                }
                $validateData['doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima'] = $request->file('doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima')->getClientOriginalName();
                $validateData['path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima'] = $request->file('doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima')->store('public/uploads/barang_konservasi/rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima');
            }
            
            if ($request->hasFile('doc_berita_acara_pemeriksaan_satwa')) {
                if ($id->doc_berita_acara_pemeriksaan_satwa && file_exists(storage_path($id->doc_berita_acara_pemeriksaan_satwa))) {
                    unlink(storage_path($id->doc_berita_acara_pemeriksaan_satwa));
                }
                $validateData['doc_berita_acara_pemeriksaan_satwa'] = $request->file('doc_berita_acara_pemeriksaan_satwa')->getClientOriginalName();
                $validateData['path_berita_acara_pemeriksaan_satwa'] = $request->file('doc_berita_acara_pemeriksaan_satwa')->store('public/uploads/barang_konservasi/berita_acara_pemeriksaan_satwa');
            }
            
            if ($request->hasFile('doc_surat_keterangan_kesehatan_satwa')) {
                if ($id->doc_surat_keterangan_kesehatan_satwa && file_exists(storage_path($id->doc_surat_keterangan_kesehatan_satwa))) {
                    unlink(storage_path($id->doc_surat_keterangan_kesehatan_satwa));
                }
                $validateData['doc_surat_keterangan_kesehatan_satwa'] = $request->file('doc_surat_keterangan_kesehatan_satwa')->getClientOriginalName();
                $validateData['path_surat_keterangan_kesehatan_satwa'] = $request->file('doc_surat_keterangan_kesehatan_satwa')->store('public/uploads/barang_konservasi/surat_keterangan_kesehatan_satwa');
            }
            
            if ($request->hasFile('doc_keterangan_asal_usul_silsilah_satwa')) {
                if ($id->doc_keterangan_asal_usul_silsilah_satwa && file_exists(storage_path($id->doc_keterangan_asal_usul_silsilah_satwa))) {
                    unlink(storage_path($id->doc_keterangan_asal_usul_silsilah_satwa));
                }
                $validateData['doc_keterangan_asal_usul_silsilah_satwa'] = $request->file('doc_keterangan_asal_usul_silsilah_satwa')->getClientOriginalName();
                $validateData['path_keterangan_asal_usul_silsilah_satwa'] = $request->file('doc_keterangan_asal_usul_silsilah_satwa')->store('public/uploads/barang_konservasi/keterangan_asal_usul_silsilah_satwa');
            }
            
            if ($request->hasFile('doc_surat_keterangan_menerima_hibah')) {
                if ($id->doc_surat_keterangan_menerima_hibah && file_exists(storage_path($id->doc_surat_keterangan_menerima_hibah))) {
                    unlink(storage_path($id->doc_surat_keterangan_menerima_hibah));
                }
                $validateData['doc_surat_keterangan_menerima_hibah'] = $request->file('doc_surat_keterangan_menerima_hibah')->getClientOriginalName();
                $validateData['path_surat_keterangan_menerima_hibah'] = $request->file('doc_surat_keterangan_menerima_hibah')->store('public/uploads/barang_konservasi/surat_keterangan_menerima_hibah');
            }
            
            if ($request->hasFile('doc_surat_keterangan_memberi_hibah')) {
                if ($id->doc_surat_keterangan_memberi_hibah && file_exists(storage_path($id->doc_surat_keterangan_memberi_hibah))) {
                    unlink(storage_path($id->doc_surat_keterangan_memberi_hibah));
                }
                $validateData['doc_surat_keterangan_memberi_hibah'] = $request->file('doc_surat_keterangan_memberi_hibah')->getClientOriginalName();
                $validateData['path_surat_keterangan_memberi_hibah'] = $request->file('doc_surat_keterangan_memberi_hibah')->store('public/uploads/barang_konservasi/surat_keterangan_memberi_hibah');
            }
            
            if ($request->hasFile('doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa')) {
                if ($id->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa && file_exists(storage_path($id->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa))) {
                    unlink(storage_path($id->doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa));
                }
                $validateData['doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa'] = $request->file('doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa')->getClientOriginalName();
                $validateData['path_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa'] = $request->file('doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa')->store('public/uploads/barang_konservasi/rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa');
            }
            
            if ($request->hasFile('doc_rekomendasi_scientific_authority_appendix_i_cites')) {
                if ($id->doc_rekomendasi_scientific_authority_appendix_i_cites && file_exists(storage_path($id->doc_rekomendasi_scientific_authority_appendix_i_cites))) {
                    unlink(storage_path($id->doc_rekomendasi_scientific_authority_appendix_i_cites));
                }
                $validateData['doc_rekomendasi_scientific_authority_appendix_i_cites'] = $request->file('doc_rekomendasi_scientific_authority_appendix_i_cites')->getClientOriginalName();
                $validateData['path_rekomendasi_scientific_authority_appendix_i_cites'] = $request->file('doc_rekomendasi_scientific_authority_appendix_i_cites')->store('public/uploads/barang_konservasi/rekomendasi_scientific_authority_appendix_i_cites');
            }
            
            if ($request->hasFile('doc_salinan_keputusan_pengadilan')) {
                if ($id->doc_salinan_keputusan_pengadilan && file_exists(storage_path($id->doc_salinan_keputusan_pengadilan))) {
                    unlink(storage_path($id->doc_salinan_keputusan_pengadilan));
                }
                $validateData['doc_salinan_keputusan_pengadilan'] = $request->file('doc_salinan_keputusan_pengadilan')->getClientOriginalName();
                $validateData['path_salinan_keputusan_pengadilan'] = $request->file('doc_salinan_keputusan_pengadilan')->store('public/uploads/barang_konservasi/salinan_keputusan_pengadilan');
            }
            
            if ($request->hasFile('doc_rekomendasi_kepala_b_bksda_asal_satwa')) {
                if ($id->doc_rekomendasi_kepala_b_bksda_asal_satwa && file_exists(storage_path($id->doc_rekomendasi_kepala_b_bksda_asal_satwa))) {
                    unlink(storage_path($id->doc_rekomendasi_kepala_b_bksda_asal_satwa));
                }
                $validateData['doc_rekomendasi_kepala_b_bksda_asal_satwa'] = $request->file('doc_rekomendasi_kepala_b_bksda_asal_satwa')->getClientOriginalName();
                $validateData['path_rekomendasi_kepala_b_bksda_asal_satwa'] = $request->file('doc_rekomendasi_kepala_b_bksda_asal_satwa')->store('public/uploads/barang_konservasi/rekomendasi_kepala_b_bksda_asal_satwa');
            }
            
            if ($request->hasFile('doc_dokumen_kerja_sama')) {
                if ($id->doc_dokumen_kerja_sama && file_exists(storage_path($id->doc_dokumen_kerja_sama))) {
                    unlink(storage_path($id->doc_dokumen_kerja_sama));
                }
                $validateData['doc_dokumen_kerja_sama'] = $request->file('doc_dokumen_kerja_sama')->getClientOriginalName();
                $validateData['path_dokumen_kerja_sama'] = $request->file('doc_dokumen_kerja_sama')->store('public/uploads/barang_konservasi/dokumen_kerja_sama');
            }
            
            if ($request->hasFile('doc_rekomendasi_bbksda_domisili_asal')) {
                if ($id->doc_rekomendasi_bbksda_domisili_asal && file_exists(storage_path($id->doc_rekomendasi_bbksda_domisili_asal))) {
                    unlink(storage_path($id->doc_rekomendasi_bbksda_domisili_asal));
                }
                $validateData['doc_rekomendasi_bbksda_domisili_asal'] = $request->file('doc_rekomendasi_bbksda_domisili_asal')->getClientOriginalName();
                $validateData['path_rekomendasi_bbksda_domisili_asal'] = $request->file('doc_rekomendasi_bbksda_domisili_asal')->store('public/uploads/barang_konservasi/rekomendasi_bbksda_domisili_asal');
            }
            
            if ($request->hasFile('doc_pnbp')) {
                if ($id->doc_pnbp && file_exists(storage_path($id->doc_pnbp))) {
                    unlink(storage_path($id->doc_pnbp));
                }
                $validateData['doc_pnbp'] = $request->file('doc_pnbp')->getClientOriginalName();
                $validateData['path_pnbp'] = $request->file('doc_pnbp')->store('public/uploads/barang_konservasi/pnbp');
            }
            if ($request->hasFile('dokumen_lainnya')) {
                $dokumen_lainnya = [];
                
                foreach ($request->file('dokumen_lainnya') as $file) {
                    $path = $file->store('public/uploads/satwa_perolehan/dokumen_lainnya');
                    $dokumen_lainnya[] = [
                        'nama' => $file->getClientOriginalName(),
                        'path' => $path
                    ];
                }
                $validateData ['dokumen_lainnya'] = json_encode($dokumen_lainnya,true);
            }
            
            $datalama = $id->toArray();
            $databaru = $validateData;
            $datalama = Arr::except($datalama,['id']);
            $changes = array_diff_assoc($databaru, $datalama);

            if ($changes) {
                $user = Auth::user()->nama_lengkap;
                $id_user = Auth::user()->id;

                $id->update($changes);
        
                session()->flash('notification', [
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Terima kasih, ' . $user . '. Data ' . $id->spesies->nama_lokal . ' Perubahan telah disimpan ke sistem.',
                ]);

                RiwayatSatwa::create([
                    'id_user' => $id_user,
                    'id_satwa_perolehan' => $id->id,
                    'action' => 'update',
                    'keterangan' => 'Pengajuan Satwa Perolehan '. $id->spesies->nama_lokal . ' telah diubah',
                ]);

                $columnMap = [
                    'doc_surat_permohonan' => 'Surat Permohonan',
                    'doc_berita_acara_pemeriksaan_sarana' => 'Berita Acara Pemeriksaan Sarana',
                    'doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima' => 'Rekomendasi Kepala B.BKSDA Domisili LK Pemohon Penerima',
                    'doc_berita_acara_pemeriksaan_satwa' => 'Berita Acara Pemeriksaan Satwa',
                    'doc_surat_keterangan_kesehatan_satwa' => 'Surat Keterangan Kesehatan Satwa',
                    'doc_keterangan_asal_usul_silsilah_satwa' => 'Keterangan Asal Usul Silsilah Satwa',
                    'doc_surat_keterangan_menerima_hibah' => 'Surat Keterangan Menerima Hibah',
                    'doc_surat_keterangan_memberi_hibah' => 'Surat Keterangan Memberi Hibah',
                    'doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa' => 'Rekomendasi Kepala B.BKSDA Domisili LK Asal Satwa',
                    'doc_rekomendasi_scientific_authority_appendix_i_cites' => 'Rekomendasi Scientific Authority Appendix I CITES',
                    'doc_salinan_keputusan_pengadilan' => 'Salinan Keputusan Pengadilan',
                    'doc_rekomendasi_kepala_b_bksda_asal_satwa' => 'Rekomendasi Kepala B.BKSDA Asal Satwa',
                    'doc_dokumen_kerja_sama' => 'Dokumen Kerja Sama',
                    'doc_rekomendasi_bbksda_domisili_asal' => 'Rekomendasi BBKSDA Domisili Asal',
                    'doc_pnbp' => 'PNBP',
                    'dokumen_lainnya' =>'Dokumen Lainnya',
                ];
                

                $atribut = [];
                foreach (array_keys($changes) as $column) {
                    if (isset($columnMap[$column])) {
                        $atribut[] = $columnMap[$column]; 
                    }
                }

                $label = implode(', ', $atribut);

                Verifikasi::create([
                    'id_user' => $id_user,
                    'id_satwa_perolehan' => $id->id,
                    'status' => 'update',
                    'perbaikan' => $label, 
                    'keterangan' => 'melakukan perubahan pada:', 
                ]);
                
                DB::commit();
            }
            
            $url = session('url');
            // dd($url);
            session()->forget('url');
            return redirect($url);

            
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('notification', [
                'success' => false,
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        
            return redirect()->back()->withInput();
        
        }
    }


    public function destroy(SatwaPerolehan $id){
        $this->authorize('create',SatwaPerolehan::class);

        DB::beginTransaction();
        try {
            $nama = $id->spesies ? $id->spesies->nama_ilmiah : 'Tidak Diketahui';
            $id_user = Auth::user()->id;
            
            RiwayatSatwa::create([
                'id_user' => $id_user,
                'id_satwa_perolehan' => $id->id,
                'action' => 'delete',
                'keterangan' => 'Pengajuan Satwa Perolehan ' . $nama . ' telah dihapus',
            ]);

            $id->delete();

            DB::commit();

            session()->flash('notification', [
                'type' => 'success',
                'success' => true,
                'message' => 'Pengajuan Satwa Perolehan telah dihapus',
            ]);

            return response()->json([
                'type' => 'success',
                'success' => true,
                'message' => 'Pengajuan Satwa Perolehan telah dihapus',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'success' => false,
                'message' => 'Terjadi kesalahan, penghapusan gagal' . $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request){
        session()->forget('url');
        session()->forget('satwaPerolehan');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);

        $request->validate([
            'query' => 'required|string|min:1',
        ]);
        $query = $request->input('query');

        $satwaPerolehan = SatwaPerolehan::
            WhereHas('spesies', function ($queryRelasi) use ($query) {
                $queryRelasi->where('nama_ilmiah', 'like', "%$query%"); 
            })
            ->orWhereHas('carasatwaperolehan', function ($queryRelasi) use ($query) {
                $queryRelasi->where('nama', 'like', "%$query%"); 
            })
            ->orWhereHas('lk', function ($queryRelasi) use ($query) {
                $queryRelasi->where('slug', 'like', "%$query%");
            })
            ->orWhereHas('asallk', function ($queryRelasi) use ($query) {
                $queryRelasi->where('slug', 'like', "%$query%"); 
            });
        if(Auth::user()->id_lk){
            $satwaPerolehan->where('id_lk', Auth::user()->id_lk);
        }
        if(Auth::user()->id_spesies){
            $satwaPerolehan->where('id_spesies', Auth::user()->id_spesies);
        }
        $satwaPerolehan = $satwaPerolehan->paginate(50);

        session(['satwaPerolehan' => $satwaPerolehan]);

        return view('pages.satwa.daftar-pengajuan-perolehan', compact('satwaPerolehan', 'query'));
    }

    public function submission()
    {
        
        session()->forget('satwaPerolehan');
        session()->forget('url');
        $status = 0;
        $satwaPerolehan = SatwaPerolehan::with(['lk', 'asallk'])->where('status', 0)->paginate(50);

        return view('pages.satwa.daftar-pengajuan-perolehan',compact('satwaPerolehan','status'));
    }

    public function detailSubmission(Request $request, SatwaPerolehan $id)
    {

        $data = $id;
        // dd($data->dokumen_lainnya);
        session()->forget('url');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);
        $timeline = Verifikasi::where('id_satwa_perolehan',$id->id)->orderBy('id','asc')->get();
        $status = Verifikasi::where('id_satwa_perolehan',$id->id)->orderBy('id','desc')->select('status')->first();

        return view('pages.satwa.detail-pengajuan-perolehan', compact('data','timeline','status'));
    }

    public function deleteDocument(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->authorize('create',SatwaPerolehan::class);

            $path = $request->input('path'); 
            $data = SatwaPerolehan::find($request->input('data_id')); 
            $dokumen = json_decode($data->dokumen_lainnya, true);
            
            $deletedDoc = array_filter($dokumen, function ($doc) use ($path) {
                return $doc['path'] === $path;
            });
            
            if (count($deletedDoc) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dokumen tidak ditemukan.',
                ], 404);
            }
            
            $deletedDoc = array_values($deletedDoc)[0];

            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            $updatedDokumen = array_filter($dokumen, function ($doc) use ($path) {
                return $doc['path'] !== $path;
            });

            $data->dokumen_lainnya = json_encode(array_values($updatedDokumen));
            $data->save();

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dihapus.',
                'deleted_doc' => [
                    'nama' => $deletedDoc['nama'],
                    'path' => $deletedDoc['path'],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
 
}
