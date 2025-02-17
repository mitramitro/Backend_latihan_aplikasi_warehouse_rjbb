<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // Debugging Log
        Log::info('Incoming Registration Request', $request->all());

        // Bersihkan input untuk keamanan
        $data = $request->only(['name', 'email', 'phone_number', 'username', 'password', 'password_confirmation', 'role', 'site_id']);
        $data = array_map('trim', $data); // Hilangkan spasi
        $data = array_map('strip_tags', $data); // Hilangkan tag HTML

        // Validasi input
        $validator = Validator::make($data, [
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'username'     => 'required|string|unique:users,username',
            'password'     => 'required|min:8|confirmed',
            'role'         => 'required|in:admin,user',
            'site_id'      => 'required|integer|exists:sites,id', // Pastikan site_id valid
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction(); // Mulai transaksi

            // Pastikan site_id ada di database
            $site = Site::find($data['site_id']);
            if (!$site) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid site selected!',
                ], 400);
            }

            // Buat user baru
            $user = User::create([
                'name'         => $data['name'],
                'email'        => $data['email'],
                'phone_number' => $data['phone_number'],
                'username'     => $data['username'],
                'password'     => Hash::make($data['password']),
                'role'         => $data['role'],
                'site_id'      => $data['site_id'],
            ]);

            DB::commit(); // Simpan transaksi

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully!',
                'user'    => $user,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika ada error
            Log::error('User Registration Failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'User registration failed!',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
