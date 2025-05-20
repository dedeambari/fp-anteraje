<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class BarangDetailExport implements FromView, WithEvents, ShouldAutoSize
{
    public $barangId;

    public function __construct($barangId)
    {
        $this->barangId = $barangId;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Barang::with(['kategori', 'pemrosessan', 'payment', 'penerima', 'pengirim'])->find($this->barangId);
        return view('report.barang.detail-barang.table', [
            'data' => $data,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $range = "A1:".$highestColumn . $highestRow;

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
