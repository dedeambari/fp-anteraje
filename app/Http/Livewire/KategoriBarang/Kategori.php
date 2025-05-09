<?php

namespace App\Http\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Component;

class Kategori extends Component
{
    protected $listeners = ['deleteKategori'];

    public function deleteKategori($kategoriId)
    {
        $kategori = KategoriBarang::withCount('barang')->findOrFail($kategoriId);

        if ($kategori->barang_count > 0) {
            return session()->flash('error', 'Tidak bisa menghapus kategori, masih digunakan oleh barang.');
        }

        $kategori->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }



    public function render()
    {
        return view('livewire.kategori-barang.kategori', [
            'kategori' => KategoriBarang::paginate(5)
        ]);
    }
}
