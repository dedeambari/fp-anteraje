<?php

namespace App\Http\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Component;

class Kategori extends Component
{
    // Listener
    protected $listeners = ['deleteKategori'];

    // delete kategori
    public function deleteKategori($kategoriId)
    {
        // get kategori
        $kategori = KategoriBarang::withCount('barang')->findOrFail($kategoriId);

        // check barang
        if ($kategori->barang_count > 0) {
            return session()->flash('error', 'Tidak bisa menghapus kategori, masih digunakan oleh barang.');
        }

        // delete
        $kategori->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.kategori-barang.kategori', [
            'kategori' => KategoriBarang::paginate(5)
        ]);
    }
}
