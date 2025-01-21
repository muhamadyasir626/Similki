<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PersetujuanRKP;

class BKSDAController extends Controller
{
    /**
     * Display the Persetujuan RKP form.
     */
    public function index()
    {
        return view('pages.forms.persetujuan-rkp');
    }

    /**
     * Store Persetujuan RKP data.
     */
    public function storeRKP(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'nama_calon_lk' => 'required|string|max:255',
            'nama_direktur' => 'required|string|max:255',
            'nib' => 'required|string|max:255',
            'npwp' => 'required|string|max:255',
            'email_lk' => 'required|email|max:255',
            'bentuk_lk' => 'required|string|max:255',
            'alamat_lk' => 'required|string|max:255',
            'jumlah_investasi' => 'required|numeric|min:0',
            'jumlah_tenaga_kerja' => 'required|integer|min:0',
            'site_plan' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'dokumen_persetujuan_lingkungan' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'draft_rkp' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'surat_permohonan' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Handle file uploads
        $filePaths = [];
        foreach (['site_plan', 'dokumen_persetujuan_lingkungan', 'draft_rkp', 'surat_permohonan'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $filePaths[$fileField] = $file->storeAs('rkp_files', $fileField . '_' . time() . '.' . $file->getClientOriginalExtension());
            }
        }

        // Store data in the database
        $persetujuanRKP = new PersetujuanRKP();
        $persetujuanRKP->nama_calon_lk = $validatedData['nama_calon_lk'];
        $persetujuanRKP->nama_direktur = $validatedData['nama_direktur'];
        $persetujuanRKP->nib = $validatedData['nib'];
        $persetujuanRKP->npwp = $validatedData['npwp'];
        $persetujuanRKP->email_lk = $validatedData['email_lk'];
        $persetujuanRKP->bentuk_lk = $validatedData['bentuk_lk'];
        $persetujuanRKP->alamat_lk = $validatedData['alamat_lk'];
        $persetujuanRKP->jumlah_investasi = $validatedData['jumlah_investasi'];
        $persetujuanRKP->jumlah_tenaga_kerja = $validatedData['jumlah_tenaga_kerja'];
        $persetujuanRKP->site_plan = $filePaths['site_plan'] ?? null;
        $persetujuanRKP->dokumen_persetujuan_lingkungan = $filePaths['dokumen_persetujuan_lingkungan'] ?? null;
        $persetujuanRKP->draft_rkp = $filePaths['draft_rkp'] ?? null;
        $persetujuanRKP->surat_permohonan = $filePaths['surat_permohonan'] ?? null;

        $persetujuanRKP->save();

        return redirect()->route('persetujuan-rkp')
                         ->with('success', 'Data Persetujuan RKP berhasil disimpan.');
    }

    public function show()
    {
        // Mengambil semua data PersetujuanRKP
        $persetujuanRKPList = PersetujuanRKP::all();
    
        // Mengirim data ke view
        return view('pages.BKSDA.daftar-persetujuan-rkp', compact('persetujuanRKPList'));
    }

    public function verifikasiRKP(){
        return view('pages.BKSDA.detail-verifikasi-rkp');
    }
    
}
