<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class BarangExport implements FromView, WithEvents, ShouldAutoSize
{

    protected $statusProsess, $statusBayar, $statuskategori, $dateFrom, $dateTo;

    public function __construct(
        $statusProsess,
        $statusBayar,
        $statuskategori,
        $dateFrom = null,
        $dateTo = null
    ) {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->statusProsess = $statusProsess;
        $this->statusBayar = $statusBayar;
        $this->statuskategori = $statuskategori;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $statusProsess = $this->statusProsess;
        $statusBayar = $this->statusBayar;
        $statuskategori = $this->statuskategori;
        $dateFrom = $this->dateFrom;
        $dateTo = $this->dateTo;

        $query = Barang::with([
            'kategori',
            'pengirim',
            'penerima',
            'pemrosessan',
            'payment'
        ])->orderByDesc('created_at');


        if (!empty($statusProsess)) {
            $query->whereHas('pemrosessan', fn($q) => $q->where('status_proses', $statusProsess));
        }
        if (!empty($statusBayar)) {
            $query->whereHas('payment', fn($q) => $q->where('status', $statusBayar));
        }
        if (!empty($statuskategori)) {
            $query->whereHas('kategori', fn($q) => $q->where('id_kategori', $statuskategori));
        }
        if (!empty($dateFrom) && !empty($dateTo)) {
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        $data = $query->get();
        return view('report.barang.table', [
            'data' => $data,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $range = "A1:" . $highestColumn . $highestRow;

                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => Color::COLOR_BLACK],
                        ],
                    ],
                ]);
            },
        ];
    }
}
