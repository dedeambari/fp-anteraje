<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Payment;
use App\Models\PemrosessanBarang;
use App\Models\PenerimaBarang;
use App\Models\PengirimBarang;
use App\Models\Staf;
use Livewire\Component;

/**
 * Summary of AddBarang
 * @author Firstname Lastname
 */
class AddBarang extends Component
{
    // current page
    public $currentPage = 1;

    // visible wire variable input
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
    $keterangan,
    $pembayaranYangBayar,
    $statusBayaran;

    // kategori barang
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
        ],
        5 => [
            'title' => 'Information & Pembayaran',
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
                "estimasiPengantaran" => ["required"],
                "keterangan" => ["nullable", "max:255", "min:3", "regex:/^[A-Za-z0-9\s.,?!]+$/"],
            ],
            5 => [
                "pembayaranYangBayar" => ["required"],
                "statusBayaran" => ["required"],
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

    public function totalTarif()
    {
        return $this->kategoriTerpilih->hitungTarif($this->volumeBarang, $this->beratBarang);
    }

    public function namaStaf()
    {
        return Staf::find($this->stafPengantaran)->nama;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getValidationRules()[$this->currentPage]);
    }

    public function store()
    {
        $rules = collect($this->getValidationRules())->collapse()->toArray();
        $this->validate($rules);

        // Simpan pengirim
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

        // Simpan barang
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
                "total_tarif" => $this->totalTarif(),
            ]);

        // update staf
        $stafPengantaran = Staf::find($this->stafPengantaran);
        $stafPengantaran->qty_task -= 1;
        $stafPengantaran->save();

        // Simpan pemrosesan
        PemrosessanBarang::create([
            "id_barang" => $barang->id,
            "id_staf" => $stafPengantaran->id,
            "status_proses" => "diproses",
        ]);

        // Simpan pembayaran
        Payment::create([
            "id_barang" => $barang->id,
            "pays" => $this->pembayaranYangBayar,
            "status_bayar" => $this->statusBayaran,
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