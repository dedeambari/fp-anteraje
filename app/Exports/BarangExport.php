<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromView;

class BarangExport implements FromView
{
    public function view(): \Illuminate\Contracts\View\View
    {
        return Barang::all();
    }
}
