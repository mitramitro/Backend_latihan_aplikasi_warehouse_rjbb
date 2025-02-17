<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            // Cek apakah token ada
            if (!$token = JWTAuth::getToken()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token not provided!',
                ], 400);
            }

            // Invalidasi token
            JWTAuth::invalidate($token);

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil!',
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token sudah expired!',
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid!',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat logout!',
            ], 500);
        }
    }
}
