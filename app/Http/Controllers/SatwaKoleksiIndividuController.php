<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tagging;
use App\Models\ListSpecies;
use Illuminate\Support\Arr;
use App\Models\RiwayatSatwa;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\DB;
use App\Models\SatwaKoleksiIndividu;
use Illuminate\Support\Facades\Auth;
use App\Models\ListCaraPerolehanKoleksi;


class SatwaKoleksiIndividuController extends Controller
{
    

    public function index(Request $request){
        session()->forget('satwaKoleksi');
        session()->forget('url');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);

        $satwaKoleksi = SatwaKoleksiIndividu::with(['lk','spesies','tagging','list_cara_perolehan_koleksi']);

        if(Auth::user()->id_lk){
            $satwaKoleksi->where('id_lk', Auth::user()->id_lk);
        }
        if(Auth::user()->id_spesies){
            $satwaKoleksi->where('id_spesies', Auth::user()->id_spesies);
        }


        $satwaKoleksi = $satwaKoleksi->paginate(50);

        return view('pages.satwa.daftar-koleksi-individu', compact('satwaKoleksi'));
    }

    public function create(Request $request){ 
        $this->authorize('create',SatwaKoleksiIndividu::class);
        
        $users = User::with('lk','role', 'upt', 'spesies')->find(Auth::id());
        // $namaIlmiah = ListSpecies::select('nama_ilmiah')->distinct()->pluck('nama_ilmiah');
        $namaIlmiah = ListSpecies::select('id', 'nama_ilmiah')->distinct()->get();
        $lks = LembagaKonservasi::select('id','nama')->get();
        $tagging = Tagging::select('id','jenis_tagging')->get();
        $perolehanKoleksiIndividu = ListCaraPerolehanKoleksi::select('id','nama')->get();
        return view('pages.satwa.form-koleksi-individu', compact('lks','users','namaIlmiah','tagging','perolehanKoleksiIndividu'));

    }

    public function store(Request $request) {
        $this->authorize('create',SatwaKoleksiIndividu::class);

        $id_user = Auth::user()->id;
        $id_lk = Auth::user()->id_lk;
        $nama_user = Auth::user()->nama_lengkap;
        // dd($request->all());
        DB::beginTransaction();

        try {
            // Validasi data
            $validateData = $request->validate([
                'id_lk' => 'required',
                'id_spesies' => 'required',
                // 'status_hukum' => 'required', //opsional dari similki lama
                'cara_perolehan_koleksi' => 'required',
                'nama_ilmiah' => 'required|string',
                'nama_panggilan' => 'required',
                'asal_usul' => 'required|string',
                'jenis_kelamin' => 'required|in:1,0',
                'bentuk_tagging' => 'required|in:1,2,3,4',
                'kode_tagging' => 'required|string',
                'umur' => 'required|integer',
                'doc_asal_usul' => 'required|file|max:10240',
                'doc_bap_kelahiran' => 'required|file|max:10240',
                'status_perlindungan_satwa' => 'required|in:1,0',
                'asal_satwa' => 'required|in:1,0',
                'sk_perolehan_koleksi_dirjen' => 'string|nullable',
                'sk_perolehan_koleksi_kepala_balai' => 'string|nullable',
            ], [
                'required' => 'Wajib diisi',
                'string' => 'Tolong isi dengan karakter (a-z, A-Z, 0-9)',
                'file.mimes' => 'File harus berformat PDF',
                'file.max' => 'Ukuran file maksimal 10 MB'
            ]);
    
            // penyimpanan file
            $validateData['path_asal_usul'] = $request->file('doc_asal_usul')->store('public/uploads/asal_usul');
            $validateData['path_bap_kelahiran'] = $request->file('doc_bap_kelahiran')->store('public/uploads/bap_kelahiran');
    
            //nama file
            $validateData['doc_asal_usul'] = $request->file('doc_asal_usul')->getClientOriginalName();
            $validateData['doc_bap_kelahiran'] = $request->file('doc_bap_kelahiran')->getClientOriginalName();
            
            $validateData['kondisi_satwa'] = 'hidup'; //default

            if(empty($validateData['tanggal_lahir'])){
                $validateData['tanggal_lahir'] = Carbon::now();
                // dd($validateData['tanggal_lahir']);
            }


            SatwaKoleksiIndividu::create($validateData);

            
            RiwayatSatwa::create([
                'id_user' => $id_user,
                 'jenis_satwa' => 'koleksi',
                'id_lk' => $id_lk,
                'action' => 'create',
                'keterangan' => 'Menambah satwa ' . $validateData['nama_ilmiah'],
            ]);

            session()->flash('notification', [
                'success' => true,
                'type'=>'success',
                'message' => 'Terima kasih, ' . $nama_user . '. Data ' . $validateData['nama_ilmiah'] . ' telah diinput ke sistem.',  
            ]);

            
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Terima kasih, ' . $nama_user . '. Data ' . $validateData['nama_ilmiah'] . ' telah diinput ke sistem.'
            // ]);

            DB::commit();
            return redirect()->route('satwa-koleksi.index');
    
        }  catch (\Illuminate\Validation\ValidationException $e) {
            // dd($e->errors());
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors()) 
                ->withInput();  
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(SatwaKoleksiIndividu $id){
        $this->authorize('create',SatwaKoleksiIndividu::class);

        try{
            $nama_panggilan = $id->nama_panggilan;
            $id->delete();

            return response()->json([
                'success' => true,
                'type' =>'success',
                'message' => $nama_panggilan . '(Satwa Koleksi individu) Berhasil dihapus',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'gagal menghapus',
                'error' => $e -> getMessage(),
            ],500);
        }
    }

    public function search(Request $request){
        $this->authorize('create',SatwaKoleksiIndividu::class);

        session()->forget('url');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);

        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query');

        $satwaKoleksi = SatwaKoleksiIndividu::where('nama_panggilan', 'like', "%$query%")
        ->orWhere('kode_tagging', 'like', "%$query%")
        ->orWhere('sk_perolehan_koleksi_dirjen', 'like', "%$query%")
        ->orWhere('sk_perolehan_koleksi_kepala_balai', 'like', "%$query%")        
        ->orWhere('kondisi_satwa', 'like', "%$query%")        
        ->orWhereHas('species', function ($queryRelasi) use ($query) {
            $queryRelasi->where('spesies', 'like', "%$query%"); 
        })
        ->orWhereHas('species', function ($queryRelasi) use ($query) {
            $queryRelasi->where('nama_ilmiah', 'like', "%$query%"); 
        })
        ->orWhereHas('lk', function ($queryRelasi) use ($query) {
            $queryRelasi->where('nama', 'like', "%$query%"); 
        });

        if(Auth::user()->id_lk){
            $satwaKoleksi->where('id_lk', Auth::user()->id_lk);
        }
        if(Auth::user()->id_spesies){
            $satwaKoleksi->where('id_spesies', Auth::user()->id_spesies);
        }

        $satwaKoleksi = $satwaKoleksi->paginate(50);

        session(['satwaKoleksi' => $satwaKoleksi]);

        return view('pages.satwa.daftar-koleksi-individu', compact(['satwaKoleksi', 'query']));


    }

    public function edit(SatwaKoleksiIndividu $id){
        $this->authorize('create',SatwaKoleksiIndividu::class);

        $takson = ListSpecies::select('nama_ilmiah', 'nama_lokal', 'nama_internasional')->findOrFail($id->id_spesies);
        $namaIlmiah = ListSpecies::select('id', 'nama_ilmiah')->distinct()->get();
        $lks = LembagaKonservasi::select('id','nama')->get();
        $tagging = Tagging::select('id','jenis_tagging')->get();
        $perolehanKoleksiIndividu = ListCaraPerolehanKoleksi::select('id','nama')->get();
        $data = $id;

        
        return view('pages.satwa.update-koleksi-individu', compact('data','takson','lks','namaIlmiah','tagging','perolehanKoleksiIndividu'));
        // return view('pages.satwa.update-koleksi-individu', compact('data','lks','tagging','perolehanKoleksiIndividu','takson'));
    }

    public function update(Request $request, SatwaKoleksiIndividu $id){
        $this->authorize('create',SatwaKoleksiIndividu::class);

        DB::beginTransaction();

        try {
            $datalama = $id->toArray();
            $validateData = $request->validate([
                'id_lk' => 'required',
                'id_spesies' => 'required',
                'cara_perolehan_koleksi' => 'required',
                'kondisi_satwa'=> 'required',
                'nama_ilmiah' => 'required|string',
                'nama_panggilan' => 'required',
                'asal_usul' => 'required|string',
                'jenis_kelamin' => 'required|in:1,0',
                'bentuk_tagging' => 'required|in:1,2,3,4',
                'kode_tagging' => 'required|string',
                'umur' => 'required|integer',
                'doc_asal_usul' => 'file|max:10240|nullable',
                'doc_bap_kelahiran' => 'file|max:10240|nullable',
                'status_perlindungan_satwa' => 'required|in:1,0',
                'asal_satwa' => 'required|in:1,0',
                'sk_perolehan_koleksi_dirjen' => 'string|nullable',
                'sk_perolehan_koleksi_kepala_balai' => 'string|nullable',
            ], [
                'required' => 'Wajib diisi',
                'string' => 'Tolong isi dengan karakter (a-z, A-Z, 0-9)',
                'file.mimes' => 'File harus berformat PDF',
                'file.max' => 'Ukuran file maksimal 10 MB'
            ]);
            
            
            
            if ($request->hasFile('doc_asal_usul')) {
                if ($id->doc_asal_usul && file_exists(storage_path($id->doc_asal_usul))) {
                    unlink(storage_path($id->doc_asal_usul));
                }
                $validateData['path_asal_usul'] = $request->file('doc_asal_usul')->store('public/uploads/asal_usul');
                $validateData['doc_asal_usul'] = $request->file('doc_asal_usul')->getClientOriginalName();
            }
    
            if ($request->hasFile('doc_bap_kelahiran')) {
                if ($id->doc_bap_kelahiran && file_exists(storage_path($id->doc_bap_kelahiran))) {
                    unlink(storage_path($id->doc_bap_kelahiran));
                }
                $validateData['path_bap_kelahiran'] = $request->file('doc_bap_kelahiran')->store('public/uploads/bap_kelahiran');
                $validateData['doc_bap_kelahiran'] = $request->file('doc_bap_kelahiran')->getClientOriginalName();
            }

            $databaru = $validateData;
            $datalama = Arr::except($datalama, ['id']);
            $changes = array_diff_assoc($databaru, $datalama);

            if($changes){
                $nama_user = Auth::user()->nama_lengkap;
                $id->update($changes);
                session()->flash('notification', [
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Terima kasih, ' . $nama_user . '. Data ' . $id->spesies->nama_ilmiah . ' Perubahan telah disimpan ke sistem.',
                ]);
                DB::commit();
                $url = session('url');
                session()->forget('url');
                return redirect($url);

            }else{
                session()->flash('notification', [
                    'success' => true,
                    'type' => '',
                    'message' => 'Tidak ada perubahan data',
                ]);

                $url = session('url');
                session()->forget('url');
                return redirect($url);
            }

    
            
            DB::rollBack();
            return redirect()->back()->with(['back' => true, 'refresh' => true]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan perubahan data: ' . $e->getMessage())
                ->withInput();
        }
    }
    

    

}
