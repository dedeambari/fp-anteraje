<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StafProfileController extends Controller
{
    public function index()
    {
        $staf = Auth::guard('staf')->user();

        $data = exceptCollect($staf, [
            "deleted_at",
            "updated_at",
            "reset_otp",
            "reset_otp_expired_at"
        ]);

        return response()->json([
            "statusCode" => 200,
            "message" => "Success",
            'data' => $data
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        // Get Staf
        $staf = Auth::guard('staf')->user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'min:3', 'regex:/^[A-Za-z\s]+$/'],
            'no_hp' => [
                'required',
                'numeric',
                'digits:12',
                Rule::unique('stafs', 'no_hp')->ignore($staf->id),
            ],
            'transportasi' => ['required', 'string', 'max:255', 'in:motor,mobil'],
            'profile' => [
                'nullable',
                'image',
                'mimetypes:image/jpeg,image/png,image/jpg,image/webp,image/heic,image/avif',
                'max:5120'
            ],
            'old_password' => ['nullable', 'min:8'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        // Update data dasar
        $staf->nama = $validated['nama'];
        $staf->no_hp = $validated['no_hp'];
        $staf->transportasi = $validated['transportasi'];

        // Handle upload file jika ada
        if ($request->hasFile('profile')) {
            // Hapus file lama kalau ada
            if ($staf->profile && Storage::disk('public')->exists($staf->profile)) {
                Storage::disk('public')->delete($staf->profile);
            }

            // Simpan file baru
            $profilePath = $request->file('profile')->store('profile-staf', 'public');
            $staf->profile = $profilePath;
        }


        // Jika password diisi, validasi dan ubah
        if (!empty($validated['old_password']) && !empty($validated['new_password'])) {
            if (!Hash::check($validated['old_password'], $staf->password)) {
                return response()->json([
                    'message' => 'Password lama salah.',
                ], 422);
            }

            $staf->password = Hash::make($validated['new_password']);
        }

        // Simpan perubahan
        $staf->save();

        return response()->json([
            'statusCode' => 200,
            'message' => 'Profil berhasil diperbarui.',
            'data' => $staf,
        ], 200);
    }

}
