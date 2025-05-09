<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;

class Barang extends Component
{
    protected $listeners = ['deleteKategori'];

    public function deleteKategori($kategoriId)
    {
        $kategori = \App\Models\KategoriBarang::withCount('barang')->findOrFail($kategoriId);

        if ($kategori->barang_count > 0) {
            return session()->flash('error', 'Tidak bisa menghapus kategori, masih digunakan oleh barang.');
        }

        $kategori->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }



    public function render()
    {
        $data = \App\Models\Barang::with(['kategori', 'pemrosessan'])->paginate(5);
        return view('livewire.barang.barang', [
            'barang' => $data
        ]);
    }
}
