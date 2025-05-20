<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrackingResiController extends Controller
{
    public function trackResi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'error' => true,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $nomorResi = $request->resi;

        $barang = Barang::with([
            'kategori',
            'pemrosessan.staf:id,nama,no_hp,transportasi',
            'payment',
            'penerima',
            'pengirim',
            'historyProgressBarang'
        ])->where('nomor_resi', $nomorResi)->first();

        if (!$barang) {
            return response()->json([
                'statusCode' => 404,
                'error' => true,
                'message' => 'Nomor Resi Tidak Valid!',
                'data' => null
            ], 404);
        }


        return response()->json([
            'statusCode' => 200,
            'error' => false,
            'message' => 'Berhasil!',
            'data' => $barang
        ], 200);

    }
}
