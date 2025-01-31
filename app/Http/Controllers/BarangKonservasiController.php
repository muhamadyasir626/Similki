<?php

namespace App\Http\Controllers;

use App\Models\Verifikasi;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\ListJenisBarang;
use App\Models\BarangKonservasi;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBarangKonservasiRequest;
use App\Http\Requests\UpdateBarangKonservasiRequest;
use App\Policies\BarangKonservasiPolicy;

class BarangKonservasiController extends Controller
{
    public function index()
    {
        $this->authorize('view',BarangKonservasi::class);
        $status = 1;
        
        $data = BarangKonservasi::with('jenisBarang')->where('status',$status);

        if(Auth::user()->role->tag == 'lk'){
            $data->where('id_lk', Auth::user()->id_lk);
        }

        $data = $data ->paginate(50);
        return view('pages.LK.daftar-pengajuan-barang', compact('data','status'));
    }

    public function submission(){
        $this->authorize('view',BarangKonservasi::class);
        $status = 0;
        $data = BarangKonservasi::with('jenisBarang')->where('status',$status);
        if(Auth::user()->role->tag == 'LK'){
            $data->where('id_lk',Auth::user()->id_lk);
        }

        $data->paginate(50);

        return view('pages.lk.daftar-pengajuan-barang', compact('data','status'));
    }

    public function detailSubmission(Request $request, BarangKonservasi $id, $statusForm){
        session()->forget('url');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);

        $this->authorize('detail',$id->id_lk);

        $data = $id;
        $timeline = Verifikasi::where('id_barang_konservasi',$id->id)->orderBy('id','asc')->get();
        $status = Verifikasi::where('id_barang_konservasi',$id->id)->orderBy('id','desc')->select('status')->first();
        
        return view('pages.LK.detail-pengajuan-barang',compact(['data','timeline','statusForm']));
    }

    public function create()
    {
        $this->authorize('create');
        session()->forget('update');
        $lk = LembagaKonservasi::where('id',Auth::user()->id_lk)->first();
        $listjenisbarang = ListJenisBarang::select('id','nama')->get();
        
        return view('pages.LK.form-pengajuan-barang', compact(['lk','listjenisbarang']));
    }

    public function store(Request $request,$id)
    {
        $this->authorize('create');
        // dd($request->all());
        DB::beginTransaction();
        try{
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'jenis_barang' => 'required|exists:list_jenis_barangs,id',
                'jumlah' => 'required|integer|min:1',
                'negara_asal' => 'required|string|max:100',
                'pelabuhan_masuk' => 'required|string|max:100',
                'perkiraan_nilai' => 'required|min:0',
                'doc_surat_permohonan' => 'required|file|mimes:pdf|max:10240',
                'doc_surat_pernyataan' => 'required|file|mimes:pdf|max:10240',
            ], [
                'nama.required' => 'Nama lembaga konservasi wajib diisi.',
                'nama.string' => 'Nama lembaga konservasi harus berupa teks.',
                'nama.max' => 'Nama lembaga konservasi maksimal 255 karakter.',
                
                'jenis_barang.required' => 'Jenis barang harus dipilih.',
                'jenis_barang.exists' => 'Jenis barang yang dipilih tidak valid.',
                
                'jumlah.required' => 'Jumlah barang harus diisi.',
                'jumlah.integer' => 'Jumlah barang harus berupa angka.',
                'jumlah.min' => 'Jumlah barang minimal 1.',
                
                'negara_asal.required' => 'Negara asal harus diisi.',
                'negara_asal.string' => 'Negara asal harus berupa teks.',
                'negara_asal.max' => 'Negara asal maksimal 100 karakter.',
                
                'pelabuhan_masuk.required' => 'Pelabuhan masuk harus diisi.',
                'pelabuhan_masuk.string' => 'Pelabuhan masuk harus berupa teks.',
                'pelabuhan_masuk.max' => 'Pelabuhan masuk maksimal 100 karakter.',
                
                'perkiraan_nilai.required' => 'Perkiraan nilai harus diisi.',
                'perkiraan_nilai.numeric' => 'Perkiraan nilai harus berupa angka.',
                'perkiraan_nilai.min' => 'Perkiraan nilai tidak boleh kurang dari 0.',
                
                'doc_surat_permohonan.required' => 'Surat permohonan wajib diunggah.',
                'doc_surat_permohonan.file' => 'Surat permohonan harus berupa file.',
                'doc_surat_permohonan.mimes' => 'Surat permohonan harus berformat PDF.',
                'doc_surat_permohonan.max' => 'Ukuran surat permohonan maksimal 10 MB.',
                
                'doc_surat_pernyataan.required' => 'Surat pernyataan wajib diunggah.',
                'doc_surat_pernyataan.file' => 'Surat pernyataan harus berupa file.',
                'doc_surat_pernyataan.mimes' => 'Surat pernyataan harus berformat PDF.',
                'doc_surat_pernyataan.max' => 'Ukuran surat pernyataan maksimal 10 MB.',
            ]);


            $validatedData['id_lk'] = $id;

            $validatedData['path_surat_permohonan'] = $request->file('doc_surat_permohonan')->store('public/uploads/barang_konservasi/surat_permohonan');
            $validatedData['doc_surat_permohonan'] = $request->file('doc_surat_permohonan')->getClientOriginalName();

            $validatedData['path_surat_pernyataan'] = $request->file('doc_surat_pernyataan')->store('public/uploads/barang_konservasi/surat_pernyataan');
            $validatedData['doc_surat_pernyataan'] = $request->file('doc_surat_pernyataan')->getClientOriginalName();
            
            $perkiraan_nilai = str_replace('.', '', $request->input('perkiraan_nilai'));
            $validatedData['perkiraan_nilai'] = $perkiraan_nilai;

            
            // dd($validatedData);
            $data = BarangKonservasi::create($validatedData);
            // dd($data);
            Verifikasi::create([
                'id_user' => Auth::user()->id,
                'id_barang_konservasi' => $data->id,
                'status' => 'in progress',
                'keterangan' => "Permohonan masuk"
            ]);

            session()->flash('notification',[
                'success' => true,
                'message' => 'Permohonan Telah Berhasil Diinput',
            ]);

            DB::commit();
         
            return redirect()->route('daftar-pengajuan-barang');


        }catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            if ($request->hasFile('doc_surat_permohonan')) {
                session()->put('doc_surat_permohonan', $request->file('doc_surat_permohonan')->getClientOriginalName());
            }
            if ($request->hasFile('doc_surat_pernyataan')) {
                session()->put('doc_surat_pernyataan', $request->file('doc_surat_pernyataan')->getClientOriginalName());
            } 

            return redirect()->back()->withErrors($e->validator)->withInput();
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            session()->flash('notification', [
                'success' => false,
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
    
            return redirect()->back()->withInput();
        }
    }
    
    public function edit(BarangKonservasi $id)
    {
        $this->authorize('create');
        session(['update'=>true]);
        session()->forget('doc_surat_pernyataan');
        session()->forget('doc_surat_permohonan');
        $listjenisbarang = ListJenisBarang::select('id','nama')->get();
        $lk = LembagaKonservasi::where('id',Auth::user()->id_lk)->first();
        $data =$id;


        return view('pages.LK.form-pengajuan-barang', compact(['data','lk','listjenisbarang']));
    }

    public function update(BarangKonservasi $id, Request $request)
    {
        $this->authorize('view',BarangKonservasi::class);
        DB::beginTransaction();
        // dd($request->all());
        try{
            $validateData = $request->validate([
                'nama' => 'required|string|max:255',
                'jenis_barang' => 'required|exists:list_jenis_barangs,id',
                'jumlah' => 'required|integer|min:1',
                'negara_asal' => 'required|string|max:100',
                'pelabuhan_masuk' => 'required|string|max:100',
                'perkiraan_nilai' => 'required|min:0',
                'doc_surat_permohonan' => 'nullable|file|mimes:pdf|max:10240',
                'doc_surat_pernyataan' => 'nullable|file|mimes:pdf|max:10240',
            ], [
                'nama.required' => 'Nama lembaga konservasi wajib diisi.',
                'nama.string' => 'Nama lembaga konservasi harus berupa teks.',
                'nama.max' => 'Nama lembaga konservasi maksimal 255 karakter.',
                
                'jenis_barang.required' => 'Jenis barang harus dipilih.',
                'jenis_barang.exists' => 'Jenis barang yang dipilih tidak valid.',
                
                'jumlah.required' => 'Jumlah barang harus diisi.',
                'jumlah.integer' => 'Jumlah barang harus berupa angka.',
                'jumlah.min' => 'Jumlah barang minimal 1.',
                
                'negara_asal.required' => 'Negara asal harus diisi.',
                'negara_asal.string' => 'Negara asal harus berupa teks.',
                'negara_asal.max' => 'Negara asal maksimal 100 karakter.',
                
                'pelabuhan_masuk.required' => 'Pelabuhan masuk harus diisi.',
                'pelabuhan_masuk.string' => 'Pelabuhan masuk harus berupa teks.',
                'pelabuhan_masuk.max' => 'Pelabuhan masuk maksimal 100 karakter.',
                
                'perkiraan_nilai.required' => 'Perkiraan nilai harus diisi.',
                'perkiraan_nilai.numeric' => 'Perkiraan nilai harus berupa angka.',
                'perkiraan_nilai.min' => 'Perkiraan nilai tidak boleh kurang dari 0.',
                
                'doc_surat_permohonan.required' => 'Surat permohonan wajib diunggah.',
                'doc_surat_permohonan.file' => 'Surat permohonan harus berupa file.',
                'doc_surat_permohonan.mimes' => 'Surat permohonan harus berformat PDF.',
                'doc_surat_permohonan.max' => 'Ukuran surat permohonan maksimal 10 MB.',
                
                'doc_surat_pernyataan.required' => 'Surat pernyataan wajib diunggah.',
                'doc_surat_pernyataan.file' => 'Surat pernyataan harus berupa file.',
                'doc_surat_pernyataan.mimes' => 'Surat pernyataan harus berformat PDF.',
                'doc_surat_pernyataan.max' => 'Ukuran surat pernyataan maksimal 10 MB.',
            ]);

            $perkiraan_nilai = str_replace('.', '', $request->input('perkiraan_nilai'));
            $validateData['perkiraan_nilai'] = $perkiraan_nilai;
            // dd($validatedData['perkiraan_nilai']);

            if ($request->hasFile('doc_surat_pemohonan')) {
                if ($id->doc_surat_pemohonan && file_exists(storage_path($id->doc_surat_pemohonan))) {
                    unlink(storage_path($id->doc_surat_pemohonan));
                }
                $validateData['doc_surat_pemohonan'] = $request->file('doc_surat_pemohonan')->getClientOriginalName();
                $validateData['path_surat_permohonan'] = $request->file('doc_surat_pemohonan')->store('public/uploads/barang_konservasi/surat_permohonan');
            }
            if ($request->hasFile('doc_surat_pernyataan')) {
                if ($id->doc_surat_pernyataan && file_exists(storage_path($id->doc_surat_pernyataan))) {
                    unlink(storage_path($id->doc_surat_pernyataan));
                }
                $validateData['doc_surat_pernyataan'] = $request->file('doc_surat_pernyataan')->getClientOriginalName();
                $validateData['path_surat_pernyataan'] = $request->file('doc_surat_pernyataan')->store('public/uploads/barang_konservasi/surat_pernyataan');
            }

            $datalama = $id->toArray();
            $databaru = $validateData;
            $datalama = Arr::except($datalama, ['id']);
            $changes = array_diff_assoc($databaru, $datalama);
            // dd($changes);

            if ($changes) {
                $user = Auth::user()->nama_lengkap;
                $id_user = Auth::user()->id;

                $id->update($changes);
        
                session()->flash('notification', [
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Terima kasih, ' . $user . '. Data ' . $id->nama . ' Perubahan telah disimpan ke sistem.',
                ]);

                $columnMap = [
                    'nama' => 'Nama Barang ',
                    'jenis_barang' => 'Jenis Barang',
                    'jumlah' => 'Jumlah Barang',
                    'negara_asal' => 'Negara Asal',
                    'pelabuhan_masuk' => 'Pelabuhan Masuk',
                    'perkiraan_nilai' => 'Perkiraan Nilai',
                    'doc_surat_permohonan' => 'Surat Permohonan',
                    'doc_surat_pernyataan' => 'Surat Pernyataan',
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
                    'id_barang_konservasi' => $id->id,
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
        }catch (\Exception $e) {
            DB::rollBack();
            session()->flash('notification', [
                'success' => false,
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        
            return redirect()->back()->withInput();
        }
    }

    public function destroy(BarangKonservasi $id)
    {
        $this->authorize('view',BarangKonservasi::class);
        $nama = $id->nama;
        $id_user = Auth::user()->id;
        $id->delete();
        
        // RiwayatBarang::create([
        //     'id_user' => $id_user,
        //     'action' => 'delete',
        //     'keterangan' => 'Menghapus Pengajuan barang Konservasi ' . $nama,
        // ]);

        session()->flash('notification',[
            'type' => 'success',
            'success' =>true,
            'message' => 'Pengajuan barang konservasi telah dihapus',
        ]);

        return response()->json([
            'type' => 'success',
            'success' => true,
            'message' => 'Pengajuan barang konservasi telah dihapus',
        ]);
    }

    public function getPelabuhan(Request $request){
        // Ambil parameter query
        $query = $request->input('query');
        $results = $this->findPelabuhan($query);

        if (count($results) > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $results
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'data tidak ditemukan',
                'data' => []
            ], 404); 
        }
    
    }

    private function findPelabuhan($query){
        $file = resource_path('data/pelabuhan-indonesia-filtered.json');
        $json = file_get_contents($file);
        $data =json_decode($json,true);

        $results = array_filter($data, function ($item) use ($query) {
            return stripos($item['nama'], $query) !== false || stripos($item['wilayah'], $query) !== false;
        });        

        return array_values($results);
    }
}
