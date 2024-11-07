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
        ],[
            'required' => ':attribute harus diisi.',
            'string' => ':attribute harus berupa string.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'min' => ':attribute harus minimal :min karakter.',
            'unique' => ':attribute sudah terdaftar.',
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
            'message' => 'Registrasi berhasil step 2'
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
        ], [
            'required' => ':attribute harus diisi.',
            'string' => ':attribute harus berupa string.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'min' => ':attribute harus minimal :min karakter.'
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
            'message' => 'Registrasi berhasil step 2',
        ]);
    }

    public function register3(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'min:8','same:password'],

        ], [
            'required' => ':attribute harus diisi.',
            'string' => ':attribute harus berupa string.',
            'email' => ':attribute harus berupa alamat email yang valid.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'min' => ':attribute harus minimal :min karakter.',
            'unique' => ':attribute sudah terdaftar.',
            'same' => ':attribute harus sama dengan password.'
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


    public function login(Request $request){
    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string|min:8'
    ]);

    // Cek login menggunakan via email/username     
    $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $credentials = [
        $field => $request->input('login'),
        'password' => $request->input('password')
    ];

    if (Auth::attempt($credentials)) {
        try {
            $auth = Auth::user();
            $token = $auth->createToken('auth_token')->plainTextToken;
            $cookie = cookie('auth_token', $token, null, null, null, true, true);
            $response = [
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [
                    // 'user' => $auth,
                    'token' => $token
                ],
                'redirect' => '/dashboard'];

            // Mengembalikan response JSON dan mengatur cookie tanpa redirect
            // return response()->json($response)->withCookie($cookie);
            return view('dashboard');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal saat menggenerate token: ' . $e->getMessage()
            ], 500);
        }
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Email/Username atau password salah, silakan coba lagi'
        ], 401);
    }
}


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