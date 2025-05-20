<?php

namespace App\Http\Livewire\Barang;

use App\Exports\BarangExport;
use \App\Models\Barang as DataBarang;
use App\Models\KategoriBarang;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Barang extends Component
{
    // listener
    protected $listeners = [
        'statusFilterProsess',
        'statusFilterBayar',
        'statusFilterKategori',
        'filterByDateRange',
    ];

    // Variable Filter Status
    public $statusProsess;
    public $statusBayar;
    public $statuskategori;
    // property filter date
    public $dateFrom, $dateTo;

    // File Name Export
    public string $fileNameExport = '';

    // Filter Listener Status Prosess
    public function statusFilterProsess($statusProsess)
    {
        $this->statusProsess = $statusProsess;
    }

    // Filter Listener Status Bayar
    public function statusFilterBayar($statusBayar)
    {
        $this->statusBayar = $statusBayar;
    }

    // Filter Listener Status Kategori
    public function statusFilterKategori($statuskategori)
    {
        $this->statuskategori = $statuskategori;
    }

    // Filter Listener Date
    public function filterByDateRange($data)
    {
        $this->dateFrom = $data['dateFrom'];
        $this->dateTo = $data['dateTo'];
    }

    // Load Data
    public function loadData()
    {
        $query = DataBarang::with([
            'kategori',
            'pengirim',
            'penerima',
            'pemrosessan',
            'payment'
        ])->orderByDesc('created_at');

        // Cek apakah user memang memilih status proses
        if (!empty($this->statusProsess)) {
            $this->fileNameExport = "barang-export-" . str_replace("_", "-", $this->statusProsess) . "-" . date('d-m-Y');
            $query->whereHas('pemrosessan', function ($q) {
                $q->where('status_proses', $this->statusProsess);
            });
        }

        // Cek apakah user memilih status bayar
        if (!empty($this->statusBayar)) {
            $this->fileNameExport = "barang-export-" . str_replace("_", "-", $this->statusBayar) . "-" . date('d-m-Y');
            $query->whereHas('payment', function ($q) {
                $q->where('status', $this->statusBayar);
            });
        }

        // Cek apakah user memilih kategori
        if (!empty($this->statuskategori)) {
            $this->fileNameExport = "barang-export-kategori-index-{$this->statuskategori}-" . date('d-m-Y');
            $query->whereHas('kategori', function ($q) {
                $q->where('id_kategori', $this->statuskategori);
            });
        }

        // Cek apakah user memilih tanggal
        if (!empty($this->dateFrom) && !empty($this->dateTo)) {
            $this->fileNameExport = "barang-date-{$this->dateFrom}-{$this->dateTo}-" . date('d-m-Y');
            $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
        }

        $this->fileNameExport = !empty($this->fileNameExport) ? $this->fileNameExport : "barang-index-" . date('d-m-Y');

        return $query->paginate(5);
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.barang.barang', [
            'barang' => $this->loadData(),
            'kategori' => KategoriBarang::all()
        ]);
    }
}
