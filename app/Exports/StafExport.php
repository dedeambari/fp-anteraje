<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;

class StafExport implements FromView
{
    protected $status_deactive_staf;

    public function __construct($status_deactive_staf)
    {
        $this->status_deactive_staf = $status_deactive_staf;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        if ($this->status_deactive_staf === 1) {
            $staf = \App\Models\Staf::get();
        } elseif ($this->status_deactive_staf === 0) {
            $staf = \App\Models\Staf::onlyTrashed()->get();
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
}
