<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class StafExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $status_deactive_staf;
    protected $dateFrom, $dateTo;

    public function __construct($status_deactive_staf, $dateFrom = null, $dateTo = null)
    {
        $this->status_deactive_staf = $status_deactive_staf;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        if ($this->status_deactive_staf == 1) {
            $staf = \App\Models\Staf::get();
                } elseif ($this->status_deactive_staf == 0 && $this->status_deactive_staf !== null) {
            $staf = \App\Models\Staf::onlyTrashed()->get();
        } elseif ($this->dateFrom && $this->dateTo) {
            $staf = \App\Models\Staf::whereBetween(
                'created_at',
                [$this->dateFrom, $this->dateTo]
            )->orderByDesc('created_at')->get();
        } else {
            $staf = \App\Models\Staf::withTrashed()->get();
        }

        $data = $staf->map(function ($staf) {
            $staf->profile = $staf->profile ??= "default.jpeg";
            $staf->created_at_human = $staf->created_at->diffForHumans();
            $staf->status_deactive_staf = $staf->deleted_at === null ? 1 : 0;
            return $staf;
        });

        return view('report.staf.table', [
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
