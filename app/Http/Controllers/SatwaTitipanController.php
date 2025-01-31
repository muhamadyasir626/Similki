<?php

namespace App\Http\Controllers;

use App\Models\ListSpecies;
use Illuminate\Support\Arr;
use App\Models\RiwayatSatwa;
use App\Models\SatwaTitipan;
use Illuminate\Http\Request;
use App\Models\LembagaKonservasi;
use Illuminate\Support\Facades\DB;
use App\Models\ListAsalSatwaTitipan;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSatwaTitipanRequest;
use App\Http\Requests\UpdateSatwaTitipanRequest;

class SatwaTitipanController extends Controller
{
    
    public function index(Request $request){
        session()->forget('satwaTitipan');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);

        $satwaTitipan = SatwaTitipan::with(['lk','spesies','asal_satwa']);
        $asal_satwa_titipan = ListAsalSatwaTitipan::all();

        if(Auth::user()->id_lk){
            $satwaTitipan->where('id_lk', Auth::user()->id_lk);
        }
        if(Auth::user()->id_spesies){
            $satwaTitipan->where('id_spesies', Auth::user()->id_spesies);
        }

        $satwaTitipan = $satwaTitipan ->paginate(50);

        return view('pages.satwa.daftar-titipan', compact('satwaTitipan','asal_satwa_titipan'));
    }

    public function create(){
        $this->authorize('create',SatwaTitipan::class);
        session()->forget('update');
        $lks = LembagaKonservasi::select('id','nama')->get();
        $asaltitipan = ListAsalSatwaTitipan::get();
        $namaIlmiah = ListSpecies::select('id', 'nama_ilmiah')->distinct()->get();
        return view('pages.satwa.form-titipan', compact('lks','namaIlmiah','asaltitipan'));
    }

    public function store(Request $request){
        $this->authorize('create', SatwaTitipan::class);
        $user = Auth::user()->nama_lengkap;
        $id = Auth::user()->id;
        // dd($request->all());
        DB::beginTransaction();
        try{

            $validateData = $request->validate([
            'id_lk' => 'nullable|required_if:nama_asal_titipan,lk',
            'id_spesies' => 'required',
            'nama_asal_titipan' => 'required|string',
            'no_bap_titipan' => 'required|string',
            'asal_satwa_titipan' => 'required',
            'jumlah_jantan' => 'integer|required',
            'jumlah_betina' => 'integer|required',
            'jumlah_unknown' => 'integer|required',
            'doc_bap_titipan' => 'required|file|mimes:pdf|max:10240',
            ],[
                'required' => 'Wajib diisi',
                'string' => 'Tolong isi dengan karakter (a-z, A-Z, 0-9)',
                'file.mimes' => 'File harus berformat PDF',
                'file.max' => 'Ukuran file maksimal 10 MB'
            ]);

            
            $validateData['path_bap_titipan'] = $request->file('doc_bap_titipan')->store('public/uploads/bap_titipan');
            $validateData['doc_bap_titipan'] = $request->file('doc_bap_titipan')->getClientOriginalName();
            
            // dd($validateData);
            $data = SatwaTitipan::create($validateData);
            
            RiwayatSatwa::create([
                'id_user' => $id,
                'id_satwa' => $data->id,
                'jenis_satwa' => 'titipan',
                'action' => 'create',
                'keterangan' => 'Menambah satwa '. $request->input('nama_ilmiah'),
            ]);
                        
            session()->flash('notification', [
                'success' => true,
                'message' => 'Terima kasih, ' . $user . '. Data ' . $request->input('nama_ilmiah') . ' telah diinput ke sistem.',  
            ]);

            DB::commit();

            return redirect()->route('satwa-titipan.index');


        }catch (\Illuminate\Validation\ValidationException $e) {
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

    public function destroy(SatwaTitipan $id){
        $this->authorize('create', SatwaTitipan::class);
        $nama_ilmiah = $id->spesies->nama_ilmiah;
        $id_user = Auth::user()->id;
        $id->delete();

        RiwayatSatwa::create([
            'id_user' => $id_user,
            'jenis_satwa' =>'titipan',
            'action' => 'delete',
            'keterangan' => 'Menghapus satwa ' . $nama_ilmiah ,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'satwa titipan '. $nama_ilmiah . ' telah dihapus', 
        ]);
    }

    public function search(Request $request){
        session()->forget('url');
        $urls = $request->fullUrl();
        session(['url' =>$urls ]);

        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query');
        // dd($query);

        $satwaTitipan = SatwaTitipan::Where('no_bap_titipan', 'like', "%$query%")
        ->orWhereHas('spesies', function ($queryRelasi) use ($query) {
            $queryRelasi->where('spesies', 'like', "%$query%"); 
        })
        ->orWhereHas('asal_satwa', function ($queryRelasi) use ($query) {
            $queryRelasi->where('nama', 'like', "%$query%"); 
        })
        ->orWhereHas('spesies', function ($queryRelasi) use ($query) {
            $queryRelasi->where('nama_lokal', 'like', "%$query%"); 
        })
        ->orWhereHas('spesies', function ($queryRelasi) use ($query) {
            $queryRelasi->where('nama_ilmiah', 'like', "%$query%"); 
        })
        ->orWhereHas('spesies', function ($queryRelasi) use ($query) {
            $queryRelasi->where('nama_internasional', 'like', "%$query%"); 
        })
        ->orWhereHas('lk', function ($queryRelasi) use ($query) {
            $queryRelasi->where('nama', 'like', "%$query%"); 
        });

        if(Auth::user()->id_lk){
            $satwaTitipan->where('id_lk', Auth::user()->id_lk);
        }
        if(Auth::user()->id_spesies){
            $satwaTitipan->where('id_spesies', Auth::user()->id_spesies);
        }
        $satwaTitipan = $satwaTitipan->paginate(50);

        session(['satwaTitipan' => $satwaTitipan]);

        return view('pages.satwa.daftar-titipan', compact(['satwaTitipan', 'query']));

    }

    public function edit(SatwaTitipan $id){
        $this->authorize('create',SatwaTitipan::class);
        session(['update' => true]);
        $lks = LembagaKonservasi::select('id','nama')->get();
        $asaltitipan = ListAsalSatwaTitipan::get();
        $namaIlmiah = ListSpecies::select('id', 'nama_ilmiah')->distinct()->get();
        $data = $id;
        // dd($data->lk->nama);

        return view('pages.satwa.form-titipan', compact(['lks','asaltitipan','namaIlmiah','data']));
    }
    
    public function update(Request $request, SatwaTitipan $id){  
        $this->authorize('create',SatwaTitipan::class);
        DB::beginTransaction();

        try {
            $validateData = $request->validate([
                'id_lk' => 'nullable|required_if:nama_asal_titipan,lk',
                'id_spesies' => 'required',
                'nama_asal_titipan' => 'required|string',
                'no_bap_titipan' => 'required|string',
                'asal_satwa_titipan' => 'required',
                'jumlah_jantan' => 'integer|required',
                'jumlah_betina' => 'integer|required',
                'jumlah_unknown' => 'integer|required',
                'doc_bap_titipan' => 'nullable|file|mimes:pdf|max:10240',
                ],[
                    'required' => 'Wajib diisi',
                    'string' => 'Tolong isi dengan karakter (a-z, A-Z, 0-9)',
                    'file.mimes' => 'File harus berformat PDF',
                    'file.max' => 'Ukuran file maksimal 10 MB'
                ]);
            $user = Auth::user()->nama_lengkap;
            
            if ($request->hasFile('doc_bap_titipan')) {
                if ($id->doc_bap_titipan && file_exists(storage_path($id->doc_bap_titipan))) {
                    unlink(storage_path($id->doc_bap_titipan));
                }
                $validateData['doc_bap_titipan'] = $request->file('doc_bap_titipan')->getClientOriginalName();
                $validateData['path_bap_titipan'] = $request->file('doc_bap_titipan')->store('public/uploads/bap_titipan');
            }

            if($request->input('nama_asal_satwa_titipan') != 'lk'){
                $validateData['id_lk']=  null;
            }
        
            $datalama = $id->toArray();
            $databaru = $validateData;
            $datalama = Arr::except($datalama, ['id']);
            $changes = array_diff_assoc($databaru, $datalama);
            // dd($changes);
            
            if ($changes) {
                $id->update($changes);
        
                session()->flash('notification', [
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Terima kasih, ' . $user . '. Data ' . $id->spesies->nama_ilmiah . ' Perubahan telah disimpan ke sistem.',
                ]);

                DB::commit();
                
               
            }
             $url = session('url');
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

}
