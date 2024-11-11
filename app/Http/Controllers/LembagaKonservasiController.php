<?php

namespace App\Http\Controllers;

use App\Models\LembagaKonservasi;
use App\Http\Requests\StoreLembagaKonservasiRequest;
use App\Http\Requests\UpdateLembagaKonservasiRequest;
use Illuminate\Http\Request;

class LembagaKonservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager loading 'id_upt' relation
        $ListLK = LembagaKonservasi::with('id_upt')->get();
        return view('lk.index', compact('ListLK'));
    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LembagaKonservasi $lembagaKonservasi)
    {
        $lembagaKonservasi->delete();

        return redirect()->route('lk.index')->with('success', 'Lembaga Konservasi deleted successfully.');
    }
}
