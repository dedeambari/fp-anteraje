<?php

namespace App\Http\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Component;

class AddKategori extends Component
{
    public $nama_kategori;
    public $hitung_berat;
    public $hitung_volume;
    public $tarif_per_kg;
    public $tarif_per_m3;
    public $tarif_flat;
    public $biaya_tambahan;

    protected $rules = [
        'nama_kategori' => 'required|string|max:255|unique:kategori_barangs,nama_kategori|regex: /^[A-Za-z\s]+$/ ',
        'hitung_berat' => 'required|boolean',
        'hitung_volume' => 'required|boolean',
        'tarif_per_kg' => 'nullable|numeric|min:0',
        'tarif_per_m3' => 'nullable|numeric|min:0',
        'tarif_flat' => 'nullable|numeric|min:0',
        'biaya_tambahan' => 'nullable|numeric|min:0',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();

        KategoriBarang::create([
            'nama_kategori' => $this->nama_kategori,
            'hitung_berat' => $this->hitung_berat,
            'hitung_volume' => $this->hitung_volume,
            'tarif_per_kg' => $this->tarif_per_kg,
            'tarif_per_m3' => $this->tarif_per_m3,
            'tarif_flat' => $this->tarif_flat,
            'biaya_tambahan' => $this->biaya_tambahan,
        ]);

        session()->flash('message', "Kategori berhasil ditambahkan: {$this->nama_kategori}");

        $this->reset();
        return redirect()->route('kategori');
    }

    public function render()
    {
        return view('livewire.kategori-barang.add-kategori');
    }
}
