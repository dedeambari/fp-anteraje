<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Staf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StafAuthController extends Controller
{
    /**
     * Summary of login
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'min:3'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        $staf = Staf::where('username', $request->username)->first();

        if (!$staf || !Hash::check($request->password, $staf->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password salah'],
            ]);
        }

        $token = $staf->createToken('staf-token')->plainTextToken;

        return response()->json([
            "statusCode" => 200,
            'token' => $token,
            'staf' => $staf,
            'message' => 'Login berhasil',
        ], 200);
    }

    /**
     * Summary of logout
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "statusCode" => 200,
            'message' => 'Logout berhasil'
        ], 200);
    }


    /**
     * Summary of forgotPassword
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $staf = Staf::where('username', $request->username)->first();

        if (!$staf) {
            return response()->json(['message' => 'Username tidak ditemukan'], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'Silakan minta kode OTP ke admin.',
            'username' => $staf->username
        ], 200);
    }

    // Step 2: Verifikasi OTP
    /**
     * Summary of forgotPasswordVerifyOtp
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function forgotPasswordVerifyOtp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'otp' => 'required|string'
        ]);

        $staf = Staf::where('username', $request->username)->first();

        if (
            !$staf ||
            $staf->reset_otp !== $request->otp ||
            !$staf->reset_otp_expired_at ||
            Carbon::now()->greaterThan($staf->reset_otp_expired_at)
        ) {
            return response()->json([
                'statusCode' => 400,
                'message' => 'OTP tidak valid atau sudah kedaluwarsa'
            ], 400);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'OTP valid. Silakan lanjutkan ubah password.',
            'username' => $staf->username
        ], 200);
    }

    /**
     * Summary of forgotPasswordReset
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function forgotPasswordReset(Request $request)
    {
        // Validasi
        $request->validate([
            'username' => 'required|string',
            'otp' => 'required|string',
            'new_password' => 'required|string|min:8|max:255',
            'new_password_confirmation' => 'required|string|min:8|max:255|same:new_password',
        ]);

        // Cek OTP
        $staf = Staf::where('username', $request->username)->first();

        if (
            !$staf ||
            $staf->reset_otp !== $request->otp ||
            !$staf->reset_otp_expired_at ||
            Carbon::now()->greaterThan($staf->reset_otp_expired_at)
        ) {
            return response()->json(['message' => 'OTP tidak valid atau sudah kedaluwarsa'], 400);
        }

        // Reset password
        $staf->password = Hash::make($request->new_password);
        $staf->reset_otp = null;
        $staf->reset_otp_expired_at = null;
        $staf->save();

        // Kirim response
        return response()->json([
            'statusCode' => 200,
            'message' => 'Password berhasil diubah'
        ], 200);
    }

    /**
     * Summary of checkAuth
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function checkAuth(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        return response()->json([
            "statusCode" => 200,
            "message" => "Success",
            "token" => $token,
            "staf" => auth("staf")->user()
        ], 200);
    }
}
