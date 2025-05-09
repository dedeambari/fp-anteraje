<?php

namespace App\Http\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Component;

class EditKategori extends Component
{
    public $nama_kategori;
    public $hitung_berat;
    public $hitung_volume;
    public $tarif_per_kg;
    public $tarif_per_m3;
    public $tarif_flat;
    public $biaya_tambahan;

    public $test;
    public $kategoriId;

    protected function rules()
    {
        return [
            'nama_kategori' => "required|string|max:255|regex:/^[A-Za-z\s]+$/|unique:kategori_barangs,id_kategori,$this->kategoriId,id_kategori",
            'hitung_berat' => 'required|in:0,1',
            'hitung_volume' => 'required|in:0,1',
            'tarif_per_kg' => 'nullable|numeric',
            'tarif_per_m3' => 'nullable|numeric',
            'tarif_flat' => 'nullable|numeric',
            'biaya_tambahan' => 'nullable|numeric',
        ];
    }


    public function mount($kategoriId)
    {
        $this->kategoriId = $kategoriId;
        $kategori = KategoriBarang::findOrFail($kategoriId);

        if($kategori) {
            $this->nama_kategori = $kategori->nama_kategori;
            $this->hitung_berat = $kategori->hitung_berat;
            $this->hitung_volume = $kategori->hitung_volume;
            $this->tarif_per_kg = $kategori->tarif_per_kg;
            $this->tarif_per_m3 = $kategori->tarif_per_m3;
            $this->tarif_flat = $kategori->tarif_flat;
            $this->biaya_tambahan = $kategori->biaya_tambahan;
        }
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function edit()
    {
        $this->validate();

        $kategori = KategoriBarang::find($this->kategoriId);
        $biaya_tambahan = $this->biaya_tambahan ?: null;
        $kategori->update([
            'nama_kategori' => $this->nama_kategori,
            'hitung_berat' => $this->hitung_berat,
            'hitung_volume' => $this->hitung_volume,
            'tarif_per_kg' => $this->tarif_per_kg,
            'tarif_per_m3' => $this->tarif_per_m3,
            'tarif_flat' => $this->tarif_flat,
            'biaya_tambahan' => $biaya_tambahan,
        ]);


        session()->flash('message', "Kategori $this->nama_kategori berhasil diperbarui.");
        return to_route('kategori');
    }

    public function render()
    {
        return view('livewire.kategori-barang.edit-kategori');
    }
}
