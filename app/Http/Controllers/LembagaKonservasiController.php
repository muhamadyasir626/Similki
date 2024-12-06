<?php

namespace App\Http\Controllers;

use App\Models\ListUpt;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use App\Models\MonitoringInvestasi;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\LembagaKonservasiUpdated;
use App\Imports\LembagaKonservasiImport;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreLembagaKonservasiRequest;
use App\Http\Requests\UpdateLembagaKonservasiRequest;


class LembagaKonservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ListLK = LembagaKonservasi::with('upt')->get();
        return view('pages.lk.daftar-lk', compact('ListLK'));
    }

    public function create()
    {
        return view('lk.create');
    }

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
            'tahun_izin' => 'required|string|max:4',
            'link_sk' => 'required|string',
            'legalitas_perizinan' => 'required|string|max:255',
            'nomor_tanggal_surat' => 'required|string|max:255',
            'bentuk_lk' => 'required|string|max:50',
            'pengelola' => 'required|string|max:20',
            'nama_pimpinan' => 'required|string|max:255',
            'izin_perolehan_tsl' => 'nullable|string',
            'tahun_akred' => 'required|string|max:4',
            'nilai_akred' => 'required|string|size:2',
            'pks_dengan_lk_lainnya' => 'nullable|string'
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
     * Update the specified resource in storage.  */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Updating LembagaKonservasi with data:', $request->all());
            $lk = LembagaKonservasi::findOrFail($id);   
            $wilayah = $request->input('upt');
            $id_upt = ListUpt::where('wilayah',$wilayah)->first();
    
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'bentuk_lk' => 'required|string|max:50',
                'nama_pimpinan' => 'required|string|max:255',
                'nilai_akred' => 'required|string|max:2',
                'tahun_akred' => 'required|string|max:4',
                'tahun_izin' => 'required|string|max:4',
                'pengelola' => 'required|string|max:20',
                'alamat' => 'required|string',
                'link_sk' => 'required|string',
                'legalitas_perizinan' => 'required|string|max:255',
                'nomor_tanggal_surat' => 'required|string|max255',
                'izin_perolehan_tsl' => 'required|string',
                'pks_dengan_lk_lainnya' => 'required|string'
            ]);
    
            if ($id_upt) {
                $validatedData['id_upt'] = $id_upt->id;
                $lk->update($validatedData);
                
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wilayah UPT tidak ditemukan.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Lembaga Konservasi berhasil diperbarui.',
                'data' => $validatedData,
                'wilayah'=>$wilayah

            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->validator->errors()->messages() // Mendapatkan pesan error yang lebih detail
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    

    
    public function destroy(LembagaKonservasi $lembagaKonservasi)
    {
        try {
            $lembagaKonservasi->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Lembaga Konservasi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Penghapusan Lembaga Konservasi gagal.',
                'error' => $e->getMessage()
            ], 500);
        }
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

    public function monitoring(){
        $investasi = MonitoringInvestasi::with('lk')->get(); 

        return view('pages.lk.monitoring', compact('investasi'));
    }
}