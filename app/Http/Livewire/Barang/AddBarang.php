<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\PemrosessanBarang;
use App\Models\PenerimaBarang;
use App\Models\PengirimBarang;
use App\Models\Staf;
use Livewire\Component;

class AddBarang extends Component
{

    public $currentPage = 1;
    public
    $namaBarang,
    $volumeBarang,
    $beratBarang,
    $type_kategori,
    $namaPengirim,
    $alamatPengirim,
    $noHpPengirim,
    $namaPenerima,
    $alamatPenerima,
    $stafPengantaran,
    $noHpPenerima,
    $estimasiPengantaran,
    $keterangan;

    public $kategoriTerpilih;

    protected $listeners = ['selectKategori', 'storeBarang'];


    public $page = [
        1 => [
            'title' => 'Informasi Barang',
        ],
        2 => [
            'title' => 'Informasi Pengirim',
        ],
        3 => [
            'title' => 'Informasi Penerima',
        ],
        4 => [
            'title' => 'Staf pengantaran',
        ]
    ];

    private function getValidationRules()
    {
        return [
            1 => [
                "namaBarang" => ["required", "regex:/^[A-Za-z\s]+$/"],
                "volumeBarang" => [$this->kategoriTerpilih && $this->kategoriTerpilih->hitung_volume ? "required" : "nullable", "numeric"],
                "beratBarang" => [$this->kategoriTerpilih && $this->kategoriTerpilih->hitung_berat ? "required" : "nullable", "numeric"],
                "type_kategori" => ["required", "exists:kategori_barangs,id_kategori"],
            ],
            2 => [
                "namaPengirim" => ["required", "regex:/^[A-Za-z\s]+$/", "max:255", "min:3"],
                "alamatPengirim" => ["required", "max:255"],
                "noHpPengirim" => ["required", "regex:/^08[0-9]{9,11}$/"]
            ],
            3 => [
                "namaPenerima" => ["required", "regex:/^[A-Za-z\s]+$/", "max:255", "min:3"],
                "alamatPenerima" => ["required", "max:255"],
                "noHpPenerima" => ["required", "regex:/^08[0-9]{9,11}$/"]
            ],
            4 => [
                "stafPengantaran" => ["required"],
            ]
        ];
    }



    public function nextStepPage()
    {
        $this->validate($this->getValidationRules()[$this->currentPage]);
        $this->currentPage++;
    }

    public function previousStepPage()
    {
        $this->currentPage--;
    }

    public function selectKategori($value)
    {
        $this->kategoriTerpilih = KategoriBarang::find($value);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getValidationRules()[$this->currentPage]);
    }

    public function store()
    {
        $rules = collect($this->getValidationRules())->collapse()->toArray();
        $this->validate($rules);

        $pengirim = PengirimBarang::firstOrCreate(
            [
                'nama' => $this->namaPengirim,
                'no_hp' => $this->noHpPengirim
            ],
            ['alamat' => $this->alamatPengirim]
        );

        // Simpan penerima
        $penerima = PenerimaBarang::firstOrCreate(
            ['nama' => $this->namaPenerima, 'no_hp' => $this->noHpPenerima],
            ['alamat' => $this->alamatPenerima]
        );

        $kategori = KategoriBarang::find($this->type_kategori);
        $tarif = $kategori->hitungTarif($this->volumeBarang, $this->beratBarang);

        $barang = Barang::create(
            [
                "nama_barang" => $this->namaBarang,
                "deskripsi_barang" => $this->keterangan,
                "berat" => $this->beratBarang,
                "volume" => $this->volumeBarang,
                "estimasi_waktu" => $this->estimasiPengantaran,
                "nomor_resi" => generateNoResi(),
                "id_kategori" => $this->type_kategori,
                "id_pengirim" => $pengirim->id,
                "id_penerima" => $penerima->id,
                "total_tarif" => $tarif,
            ]);

        $stafPengantaran = Staf::find($this->stafPengantaran);
        $stafPengantaran->qty_task -= 1;
        $stafPengantaran->save();

        PemrosessanBarang::create([
            "id_barang" => $barang->id,
            "id_staf" => $stafPengantaran->id,
            "status_proses" => "diproses",
        ]);

        session()->flash('message', "Barang $this->namaBarang created successfully!");

        $this->reset();

        return to_route('barang');
    }

    public function render()
    {
        return view('livewire.barang.add-barang', [
            'kategori' => KategoriBarang::all(),
            'staf' => Staf::where('qty_task', '>', 0)
                ->select('id', 'nama')
                ->get()
        ]);
    }
}