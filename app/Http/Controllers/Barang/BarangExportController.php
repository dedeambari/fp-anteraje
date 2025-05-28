<?php

namespace App\Http\Controllers\Barang;

use App\Exports\BarangExport;
use App\Exports\PdfExport;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class BarangExportController extends Controller
{

    /**
     * Summary of exportBarang
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportBarang(Request $request)
    {
        $statusProsess = $request->status_prosess;
        $statusBayar = $request->status_bayar;
        $statuskategori = $request->status_kategori;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;

        $query = Barang::with([
            'kategori',
            'pengirim',
            'penerima',
            'pemrosessan',
            'payment'
        ])->orderByDesc('created_at');

        $fileNameExport = 'barang-export-' . now()->format('d-m-Y');
        $title = "Report Semua Barang";
        if (!empty($statusProsess)) {
            $title = "Report Barang status proses " . str_replace("_", "-", $statusProsess);
            $fileNameExport = "Report Barang status proses " . str_replace("_", "-", $statusProsess) . "-" . date('d-m-Y');
            $query->whereHas('pemrosessan', fn($q) => $q->where('status_proses', $statusProsess));
        }

        if (!empty($statusBayar)) {
            $title = "Report Barang " . str_replace("_", "-", $statusBayar);
            $fileNameExport = "barang-pembayaran-" . str_replace("_", "-", $statusBayar) . "-" . date('d-m-Y');
            $query->whereHas('payment', fn($q) => $q->where('status', $statusBayar));
        }

        if (!empty($statuskategori)) {
            $title = "Report Barang " . str_replace("_", "-", $statuskategori);
            $fileNameExport = "brang-kategori-index-{$statuskategori}" . "-" . date('d-m-Y');
            $query->whereHas('kategori', fn($q) => $q->where('id_kategori', $statuskategori));
        }

        // Cek apakah user memilih tanggal
        if (!empty($dateFrom) && !empty($dateTo)) {
            $start = Carbon::parse($dateFrom);
            $end = Carbon::parse($dateTo);

            $totalDays = $start->diffInDays($end);

            if ($totalDays < 7) {
                $durasi = "{$totalDays} hari";
            } elseif ($totalDays < 30) {
                $weeks = floor($totalDays / 7);
                $durasi = "{$weeks} minggu";
            } else {
                $months = $start->diffInMonths($end);
                if ($months === 0 && $totalDays >= 30) {
                    $months = 1;
                }
                $durasi = "{$months} bulan";
            }
            $title = "Report Barang ({$dateFrom} - {$dateTo}) $durasi";
            $fileNameExport = "barang-date-{$dateFrom}-{$dateTo} " . date('d-m-Y');
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        $data = $query->get();
        $pdfExport = new PdfExport($data, $fileNameExport, 'report.barang.pdf.content', $title);

        return $pdfExport->export();
    }

    public function exportBarangExcel(Request $request)
    {
        $status_prosess = $request->status_prosess;
        $status_bayar = $request->status_bayar;
        $status_kategori = $request->status_kategori;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $fileNameExport = $request->fileNameExport;

        return Excel::download(new BarangExport(
            $status_prosess,
            $status_bayar,
            $status_kategori,
            $dateFrom,
            $dateTo
        ), "$fileNameExport.xlsx");
    }

    /**
     * Summary of exportDetailBarang
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportDetailBarang(Request $request)
    {
        $nomor_resi = $request->nomor_resi;

        $data = Barang::with([
            'kategori',
            'pengirim',
            'penerima',
            'pemrosessan',
            'payment'
        ])->where('nomor_resi', $nomor_resi)->first();

        $title = "Report Detail Barang ({$data->nama_barang})";

        $name_pdf = "detail-barang-{$data->nomor_resi}";
        $pdfExport = new PdfExport(
            $data,
            $name_pdf,
            'report.barang.detail-barang.pdf.content',
            $title
        );
        return $pdfExport->export();
    }

    /**
     * Summary of exportStrukDetailBarang
     * @param mixed $id
     * @return mixed|\Illuminate\Http\Response
     */
    public function exportStrukDetailBarang($id)
    {
        $barang = Barang::with(['kategori', 'pengirim', 'penerima', 'pemrosessan.staf'])->findOrFail($id);

        $html = View::make('report.barang.detail-barang.struk.index', compact('barang'))->render();

        $mpdf = new Mpdf([
            'format' => [155, 130],
            'orientation' => 'L',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
        ]);

        $mpdf->WriteHTML($html);
        return response($mpdf->Output("struk_pengiriman_$barang->nomor_resi.pdf", 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}
