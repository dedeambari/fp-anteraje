<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;

class DetailBarang extends Component
{
    public $detailBarang = null;
    public function mount($barangId)
    {
        $barang = Barang::with(['kategori', 'pemrosessan', 'payment', 'penerima', 'pengirim'])->find($barangId);
        if (!$barang) {
            session()->flash('error', "Barang tidak ditemukan!");
            to_route('barang');
        }
        $this->detailBarang = $barang;
    }
    public function render()
    {
        return view('livewire.barang.detail-barang');
    }
}
