<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StafHomeController extends Controller
{
    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $staf = Auth::guard('staf')->user()->load('pemrosessan.barang.kategori');
        abort_if(!$staf, 401, 'Unauthorized');

        $now = Carbon::now();
        $pemrosesan = $staf->pemrosessan;

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

        // Tugas waktu dekat ≤ 2 hari dari sekarang dan belum 'diterima'
        $tugas_berikutnya = $pemrosesan->filter(
            fn($item) =>
            Carbon::parse($item->estimasi_waktu)->between($now, $now->copy()->addDays(2)) &&
            $item->status_proses !== 'diterima'
        );

        // Ambil hanya 1 tugas diterima yang paling dekat dengan waktu sekarang
        $tugas_baru_selesai = $pemrosesan
            ->where('status_proses', 'diterima')
            ->sortByDesc('updated_at')
            ->first();


        $data = [
            "nama" => $staf->nama,
            "username" => $staf->username,
            "no_hp" => $staf->no_hp,
            "sisa_jumlah_tugas" => $staf->qty_task,
            "total_barang" => $pemrosesan->count(),
            "total_barang_diantar" => $pemrosesan->where('status_proses', 'diantar')->count(),
            "total_barang_diterima" => $pemrosesan->where('status_proses', 'diterima')->count(),
            "tugas_berikutnya" => $tugas_berikutnya->map($formatPemrosesan)->values(),
            "tugas_baru_selesai" => $tugas_baru_selesai ? $formatPemrosesan($tugas_baru_selesai) : null,
        ];

        return response()->json([
            'statusCode' => 200,
            'message' => 'Berhasil mengambil data dashboard staf',
            'data' => $data
        ]);
    }


}
