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
    public $namaBarang, $volumeBarang, $beratBarang, $type_kategori, $namaPengirim, $alamatPengirim, $noHpPengirim, $namaPenerima, $alamatPenerima, $stafPengantaran, $noHpPenerima, $estimasiPengantaran, $keterangan, $pembayaranYangBayar;
    public $statusBayaran = 'belum_bayar';

    // kategori barang
    public $kategoriTerpilih;

    // Listeners
    protected $listeners = ['selectKategori', 'storeBarang'];

    // page title
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
        ],
    ];

    // get validation rules
    private function getValidationRules()
    {
        return [
            1 => [
                'namaBarang' => ['required', "regex:/^[A-Za-z\s]+$/"],
                'volumeBarang' => [$this->kategoriTerpilih && $this->kategoriTerpilih->hitung_volume ? 'required' : 'nullable', 'numeric'],
                'beratBarang' => [$this->kategoriTerpilih && $this->kategoriTerpilih->hitung_berat ? 'required' : 'nullable', 'numeric'],
                'type_kategori' => ['required', 'exists:kategori_barangs,id_kategori'],
            ],
            2 => [
                'namaPengirim' => ['required', "regex:/^[A-Za-z\s]+$/", 'max:255', 'min:3'],
                'alamatPengirim' => ['required', 'max:255'],
                'noHpPengirim' => ['required', "regex:/^08[0-9]{9,11}$/"],
            ],
            3 => [
                'namaPenerima' => ['required', "regex:/^[A-Za-z\s]+$/", 'max:255', 'min:3'],
                'alamatPenerima' => ['required', 'max:255'],
                'noHpPenerima' => ['required', "regex:/^08[0-9]{9,11}$/"],
            ],
            4 => [
                'stafPengantaran' => ['required'],
                'estimasiPengantaran' => ["required", "date", "after:now"],
                'keterangan' => ['nullable', 'max:255', 'min:3', "regex:/^[A-Za-z0-9\s.,?!]+$/"],
            ],
            5 => [
                'pembayaranYangBayar' => ['required'],
                'statusBayaran' => [$this->pembayaranYangBayar == 'pengirim' ? 'required' : 'nullable'],
            ],
        ];
    }

    // validasi
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getValidationRules()[$this->currentPage]);
    }

    // next page
    public function nextStepPage()
    {
        $this->validate($this->getValidationRules()[$this->currentPage]);
        $this->currentPage++;
    }

    // previous page
    public function previousStepPage()
    {
        $this->currentPage--;
    }

    // select kategori by input select
    public function selectKategori($value)
    {
        $this->kategoriTerpilih = KategoriBarang::find($value);
    }

    // total tarif
    public function totalTarif()
    {
        return $this->kategoriTerpilih->hitungTarif($this->volumeBarang, $this->beratBarang);
    }

    // nama staf
    public function namaStaf()
    {
        return Staf::find($this->stafPengantaran)->nama;
    }

    // store
    public function store()
    {
        // validasi collect orm rules
        $rules = collect($this->getValidationRules())->collapse()->toArray();
        $this->validate($rules);

        // Simpan pengirim
        $pengirim = PengirimBarang::firstOrCreate(
            [
                'nama' => $this->namaPengirim,
                'no_hp' => $this->noHpPengirim,
            ],
            ['alamat' => $this->alamatPengirim],
        );

        // Simpan penerima
        $penerima = PenerimaBarang::firstOrCreate(['nama' => $this->namaPenerima, 'no_hp' => $this->noHpPenerima], ['alamat' => $this->alamatPenerima]);

        // Simpan barang
        $barang = Barang::create([
            'nama_barang' => $this->namaBarang,
            'deskripsi_barang' => $this->keterangan,
            'berat' => $this->beratBarang,
            'volume' => $this->volumeBarang,
            'nomor_resi' => generateNoResi(),
            'id_kategori' => $this->type_kategori,
            'id_pengirim' => $pengirim->id,
            'id_penerima' => $penerima->id,
            'total_tarif' => $this->totalTarif(),
        ]);

        // update staf
        $stafPengantaran = Staf::find($this->stafPengantaran);
        $stafPengantaran->updateQtyTask(-1);

        // Simpan pemrosesan
        PemrosessanBarang::create([
            'id_barang' => $barang->id,
            'id_staf' => $stafPengantaran->id,
            'status_proses' => 'diproses',
            'estimasi_waktu' => $this->estimasiPengantaran,
        ]);

        // Simpan pembayaran
        Payment::create([
            'id_barang' => $barang->id,
            'pays' => $this->pembayaranYangBayar,
            'status' => $this->statusBayaran,
        ]);

        // flash mesage
        session()->flash('message', "Barang $this->namaBarang created successfully!");

        // reset
        $this->reset();

        return to_route('barang');
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.barang.add-barang', [
            'kategori' => KategoriBarang::all(),
            'staf' => Staf::where('qty_task', '>', 0)->select('id', 'nama')->get(),
        ]);
    }
}
