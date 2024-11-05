<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ListUpt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class  AuthController extends Controller
{

    public function register1(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:0,1'],
            'nomor_telepon' => ['required', 'string', 'min:12', 'unique:users'],
            'nip' => ['required', 'string', 'min:18', 'max:18','unique:users'],
            'id_role' => ['required', 'integer'],
            'id_lk' => ['nullable', 'integer'],
            'bentuk_upt' => ['nullable', 'string'],
            'wilayah_upt' => ['nullable', 'string'],
            'id_spesies' => ['nullable', 'string'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $validatedData = $validator->validated();
    
        $sessionData = $request->only([
            'nama_lengkap', 'jenis_kelamin', 'nomor_telepon', 'nip', 
            'id_role', 'id_lk', 'id_upt', 'id_spesies'
        ]);
    
        if(isset($validatedData['bentuk_upt']) && isset($validatedData['wilayah_upt'])){
            $upt = ListUpt::where('bentuk', $validatedData['bentuk_upt'])
                        ->where('wilayah', $validatedData['wilayah_upt'])
                        ->first();
    
            if ($upt) {
                $sessionData['id_list_lk'] = $upt->id;
            } 
        } 
    
        $request->session()->put('register1', $sessionData);
    
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil step 1.'
        ]);
    }

    public function register2(Request $request){
        $validator = Validator::make($request->all(), [
            'kodepos' => ['required', 'string','min:5', 'max:5'],
            'provinsi' => ['required', 'string'],
            'kota/kab' => ['required', 'string'],
            'kecamatan' => ['required', 'string'],
            'kelurahan' => ['required', 'string'],
            'alamat_lengkap' => ['required', 'string'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
    
        $sessionData = $request->only([
            'kodepos', 'provinsi', 'kabupaten', 'kecamatan', 
            'kelurahan', 'alamat_lengkap'
        ]);

    
        $request->session()->put('register2', $sessionData);
    
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil step 1.',
        ]);
    }

    public function register3(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'min:8','same:password'],

        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $register1 = $request->session()->get('register1');
        $register2 = $request->session()->get('register2');
    
        if (!$register1 || !$register2) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan ulangi proses registrasi.'
            ], 400);
        }
    
        $data = array_merge(
            $register1,
            $register2,
            $validator->validated()
        );
        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);
    
        $user = User::create($data);
    
        $request->session()->forget(['register1', 'register2']);
    
        // Return response sukses
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
        ]);
    }
    
    // public function register(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'username' => ['required', 'string', 'max:255','unique:users'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'kode_pos' => ['required', 'string', 'max:5', 'min:5'],
    //         'provinsi' => ['required', 'string'],
    //         'kabupaten' => ['required', 'string'],
    //         'kecamatan' => ['required', 'string'],
    //         'kelurahan' => ['required', 'string'],
    //         'alamat_lengkap' => ['required', 'string'],
           
    //         'password' => ['required', 'min:8'],
    //         'confirm_password' => ['required', 'min:8','same:password'],
    //     ]);

    //     $validated = $validator->validated();

    //     $role = Role::find($validated['id_role']); 

    //     $status_permission = 0; 

    //     if ($role && $role->tag === 'KKHSG') {
    //         $status_permission = 1; 
    //     }

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Ada kesalahan',
    //             'data' => $validator->errors()
    //         ]);
    //     }

    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $input['status_permission'] = $status_permission;
    //     $user = User::create($input);
        
        
    //     // $success['token'] = $user->createToken('auth_token')->plainTextToken;
    //     // $success['name'] = $user->name;

    //     // return response()->json([
    //     //     'success' => true,
    //     //     'message' => 'Sukses register',
    //     //     'data' => $success,
    //     //     'redirect' => '/dashboard'
    //     // ]);
        

    //     return redirect('/');
    // }

    public function getWilayahUPT(Request $request){
        try {
            $bentukUpt = $request->input('bentuk');
            $wilayah = ListUpt::where('bentuk', $bentukUpt)
                            ->select('wilayah','slug')
                            ->get();
            return response()->json(['data' => $wilayah]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // public function login(Request $request){
    //     $request->validate([
    //         'login' => 'required|string',
    //         'password' => 'required|string|min:8'
    //     ]);
    
    //     $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
    //     $credentials = [
    //         $field => $request->input('login'),
    //         'password' => $request->input('password')
    //     ];
    
    //     if (Auth::attempt($credentials)) {
    //         try {
    //             $auth = Auth::user();
    //             $token = $auth->createToken('auth_token')->plainTextToken;
    //             $cookie = cookie('auth_token', $token, null, null, null, true, true); 

    //             $response = [
    //                 'success' => true,
    //                 'message' => 'Login successful',
    //                 'data' => [
    //                     'user' => $auth,
    //                     'token' => $token
    //                 ],
    //                 'redirect' => '/dashboard'
    //             ];
    
    //             // Return JSON response and set cookie
    //             // return response()->json($response)->withCookie($cookie);
    
    //             return redirect('/dashboard')->withCookie($cookie);
    //         } catch (\Exception $e) {
    //             return back()->withErrors(['login' => 'Gagal saat menggenerate token: ' . $e->getMessage()]);
    //         }
    //     } else {
    //         return redirect('/login')->withErrors([
    //             'login' => 'Email/Username atau password salah, silakan coba lagi'
    //         ])->withInput($request->except('password'));
    //     }
    // }

    public function logout(Request $request){
        $user = Auth::user();

        if ($user) {
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $cookie = Cookie::forget('auth_token');

        return redirect('/login')->withCookie($cookie)->with('message', 'Successfully logged out.');
    }
    
}