<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StafTaskController extends Controller
{
    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get Staf in Auth
        $staf = Auth::guard('staf')->user()->load('pemrosessan.barang.kategori');
        // Check Staf
        abort_if(!$staf, 401, 'Unauthorized');

        $formatPemrosesan = fn($item) => [
            "id" => $item->id,
            "nomor_resi" => $item->barang->nomor_resi,
            "id_barang" => $item->barang->id,
            "nama_barang" => $item->barang->nama_barang,
            "deskripsi_barang" => $item->barang->deskripsi_barang,
            "kategori" => $item->barang->kategori->nama_kategori,
            "estimasi_waktu" => $item->estimasi_waktu,
            "status_proses" => $item->status_proses,
            "bukti" => $item->bukti,
            "catatan" => $item->catatan,
            "created_at" => $item->created_at,
            "updated_at" => $item->updated_at
        ];

        $task_prosess = $staf->pemrosessan->where('status_proses', 'diproses')->map($formatPemrosesan)->values();
        $task_diantar = $staf->pemrosessan->where('status_proses', 'diantar')->map($formatPemrosesan)->values();
        $task_diterima = $staf->pemrosessan->where('status_proses', 'diterima')->map($formatPemrosesan)->values();

        // Data Staf Task
        $data = [
            'diproses' => $task_prosess,
            'diantar' => $task_diantar,
            'diterima' => $task_diterima,
        ];

        // Response Success
        return response()->json([
            "statusCode" => 200,
            "message" => "Success",
            'data' => $data
        ], 200);
    }


    /**
     * Summary of detailBarang
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function detailBarang(Request $request)
    {
        // Validasi
        $request->validate([
            'id_barang' => 'required|integer',
        ]);

        // Ambil id barang
        $id = $request->id_barang;

        // Ambil user staf beserta relasi barang dan relasi dalam barang
        $staf = Auth::guard('staf')->user()->load([
            'pemrosessan',
            'pemrosessan.barang.kategori',
            'pemrosessan.barang.payment',
            'pemrosessan.barang.penerima',
            'pemrosessan.barang.pengirim',
            'pemrosessan.barang.historyProgressBarang'
        ]);

        // Check Staf
        abort_if(!$staf, 401, 'Unauthorized');

        // Ambil barang
        $allBarang = $staf->pemrosessan->pluck('barang');

        // Cari barang
        $barang = $allBarang->firstWhere('id', $id);

        // Check barang
        if (!$barang) {
            return response()->json([
                "statusCode" => 404,
                "message" => "barang tidak ditemukan"
            ], 404);
        }

        // Data Detail baran + ExceptCollect
        $data = [
            'pemrosessan' => exceptCollect($barang->pemrosessan, [
                'id_barang',
                'id_staf',
                'created_at',
                'updated_at'
            ]),
            'barang' => exceptCollect($barang, [
                "id_kategori",
                "id_pengirim",
                "id_penerima",
                'created_at',
                'updated_at',
                'deleted_at',
                'kategori',
                'payment',
                'pengirim',
                'penerima',
                'history_progress_barang',
                'pemrosessan'
            ]),
            'kategori' => exceptCollect($barang->kategori, [
                'created_at',
                'updated_at',
            ]),
            'payment' => exceptCollect($barang->payment, ['created_at', 'updated_at']),
            'pengirim' => exceptCollect($barang->pengirim, ['created_at', 'updated_at', 'deleted_at']),
            'penerima' => exceptCollect($barang->penerima, ['created_at', 'updated_at', 'deleted_at']),
            'history' => exceptCollect($barang->historyProgressBarang, ['created_at', 'updated_at']),
        ];

        return response()->json([
            "statusCode" => 200,
            "message" => "success",
            "data" => $data
        ], 200);
    }

    public function updateProsessBarang(Request $request)
    {
        // Validasi
        $request->validate([
            'id_barang' => ['required', 'integer'],
            'status_prosess' => ['required', 'string', 'in:diproses,diantar,diterima'],
            'catatan' => ['nullable', 'string', 'max:500', 'regex:/^[A-Za-z0-9\s.,?!]+$/'],
            'bukti' => ['nullable', 'image', 'max:2048', 'mimetypes:image/jpeg,image/png,image/jpg,image/webp', 'required_if:status_prosess,diterima'],
        ]);

        $id = $request->id_barang;

        // Ambil user staf beserta relasi pemrosessan dan barang terkait
        $staf = Auth::guard('staf')->user()->load([
            'pemrosessan.barang.kategori',
            'pemrosessan.barang.payment',
            'pemrosessan.barang.penerima',
            'pemrosessan.barang.pengirim',
            'pemrosessan.barang.historyProgressBarang',
        ]);

        abort_if(!$staf, 401, 'Unauthorized');

        // Cari pemrosessan yang terkait dengan id barang
        $pemrosesan = $staf->pemrosessan->first(function ($p) use ($id) {
            return $p->barang && $p->barang->id == $id;
        });

        if (!$pemrosesan) {
            return response()->json([
                "statusCode" => 404,
                "message" => "barang tidak ditemukan"
            ], 404);
        }

        // Update data pemrosessan
        $pemrosesan->status_proses = $request->status_prosess;
        $pemrosesan->catatan = $request->catatan;

        // Jika status diterima, proses upload bukti
        if ($request->status_prosess == 'diterima' && $request->hasFile('bukti')) {
            // Hapus file lama jika ada
            if ($pemrosesan->bukti && Storage::disk('public')->exists($pemrosesan->bukti)) {
                Storage::disk('public')->delete($pemrosesan->bukti);
            }

            // Simpan file baru
            $buktiPath = $request->file('bukti')->store('bukti-barang', 'public');
            $pemrosesan->bukti = $buktiPath;
        }

        // Simpan pemrosessan
        $pemrosesan->save();

        // Response
        return response()->json([
            "statusCode" => 200,
            "message" => "Barang " . $pemrosesan->barang->nama . "berhasil diupdate"
        ]);
    }



}
