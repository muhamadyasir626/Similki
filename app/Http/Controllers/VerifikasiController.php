<?php

namespace App\Http\Controllers;

use App\Models\BarangKonservasi;
use App\Models\LembagaKonservasi;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VerifikasiController extends Controller
{
    public function store(Request $request){
        $this->authorize('update',Verifikasi::class);
        // dd($request->all());
        $id_user = Auth::user()->id;
        DB::beginTransaction();

        try{
            $validateData = $request->validate([
                'status' => 'required|in:Approved,rejected,in progress',
                'keterangan' => 'nullable|string',
                'id_lk' => 'nullable',
                'id_satwa_koleksi_individu' => 'nullable',
                'id_satwa_perolehan' => 'nullable',
                'id_barang_konservasi' => 'nullable',
            ]);

            $validateData['id_user'] = $id_user;
            // dd($validateData);

            // if($request->input('id_lk')){

            //     if($validateData['status'] == 'Approved'){
            //         $lk = LembagaKonservasi::where('id',$validateData['id_lk'])->first();
            //         $lk->status = 1;
            //         $lk->save();
            //         // dd($lk);
            //     }
                
            //     Verifikasi::create($validateData);
    
            //     session()->flash('notification',[
            //         'success' => true,
            //         'message' => 'Verifikasi berhasil',
            //     ]);
            // }
            // elseif($request->input('id_barang_konservasi')){
            //     // dd($request->input('id_barang_konservasi'));
            //     if($validateData['status'] == 'Approved'){
            //         $bk = BarangKonservasi::where('id', $validateData['id_barang_konservasi'])->first();
            //         $bk->status = 1;
            //         // dd($bk);
            //         $bk->save();
            //     }
            //     Verifikasi::create($validateData);
                
            // }
            
            
            Verifikasi::create($validateData);
            DB::commit();
            return redirect()->back();

        }catch(ValidationException $e){
            // dd($e);
            DB::rollBack();
            session()->flash('notification',[
                'type' => 'error',
                'success' => false,
                'message' => 'Verifikasi gagal'
            ]);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
