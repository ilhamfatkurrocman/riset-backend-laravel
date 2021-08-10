<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{
    // Register ini memvalidasi semua data
    public function register(Request $request)
    {
        try {
            // Create Validation
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'max:255'],
                'password' => ['required', 'string', new Password], // Pakai yang Password (Laravel\Fortify\Rules\Password) - bawaan dari laravel jstream

            ]);

            // Untuk Create User
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),

            ]);

            // Untuk mengambil data yang di inputkan berdasarkan email (id) karena email = unique
            $user = User::where('email', $request->email)->first();

            // Untuk create Token agar tidak login berulang kali
            // plainTextToken (untuk mengembalikan token yang ada)
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user

            ], 'User Registered'); // Pesan Berhasil

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error

            ], 'Authentication Failed', 500); // Pesan Gagal

        }
    }

    // Login ini memvalidasi data yang sudah tersedia didatabase
    public function login(Request $request)
    {
        // Validasi email login
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'

            ]);

            // Menyimpan credential didalam satu variabel
            $credentials = request(['email', 'password']);

            // Cek email login valid atau tidak
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'

                ], 'Authentication Failed', 500); // Data email tidak valid
            }

            // Data email valid
            $user = User::where('email', $request->email)->first();

            // Cek password login valid atau tidak
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials'); // Data password tidak valid
            }

            // Data password valid
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user

            ], 'Authenticated');

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error

            ], 'Authentication Failed', 500);

        }
    }

    // Mengambil data user
    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data profil user berhasil diambil');
    }
}
