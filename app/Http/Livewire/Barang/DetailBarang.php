<?php

namespace App\Http\Livewire\Barang;

use App\Exports\BarangDetailExport;
use App\Models\Barang;
use App\Models\HistoryProsessBarang;
use App\Models\KategoriBarang;
use App\Models\Staf;
use App\Rules\DetailBarangRules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class DetailBarang extends Component
{
    use WithFileUploads;
    // Detail Barang
    public $detailBarang = null;

    // Modal Type
    public string $modalType = '';

    // Listener
    protected $listeners = ['showModal', 'closeModal', 'selectKategori', 'exportPdf', 'exportExcel', 'deleteBarang'];

    // Input Barang
    public $barang = [];
    // Input Pengirim
    public $pengirim = [];
    // Input Penerima
    public $penerima = [];
    // Input Pengiriman
    public $pengiriman = [];
    // Input Pembayaran
    public $pembayaran = [];

    public $kategoriTerpilih = null;
    public $stafTerpilih = null;
    public $buktiPreview = null;

    public $histroyPrgoress = null;

    // Validation Rules
    /**
     * Summary of rulesMap
     * @return array
     */
    private function rulesMap()
    {
        /** @var DetailBarangRules */
        $rulesObj = new DetailBarangRules($this->pengiriman, $this->kategoriTerpilih);
        return $rulesObj->rules();
    }

    // Validasi rules
    private function getValidationRules($section = null)
    {
        if ($section) {
            // Tidak perlu tambah prefix lagi
            return $this->rulesMap()[$section] ?? [];
        }

        // Jika ingin ambil semua rules dari semua section
        return collect($this->rulesMap())
            ->flatMap(fn($fields) => $fields)
            ->toArray();
    }

    // Update Validasi Attributes
    protected function getValidationAttributes($section = null)
    {
        $rules = $this->getValidationRules($section);
        return collect($rules)
            ->mapWithKeys(function ($_, $key) {
                // Mengambil bagian setelah titik pertama
                $label = collect(explode('.', $key))->last();
                // Jika terdapat "id_" di awal label, hapus "id_" tersebut
                if (strpos($label, 'id_') === 0) {
                    $label = str_replace('id_', '', $label);
                }
                // Mengganti underscore dengan spasi
                $label = str_replace('_', ' ', $label);
                // Mengubah huruf pertama menjadi kapital
                $label = ucfirst($label);

                return [$key => $label];
            })
            ->toArray();
    }

    // Update Validasi
    public function updated($propertyName)
    {
        $section = explode('.', $propertyName)[0];
        $this->validateOnly(
            $propertyName,
            $this->getValidationRules($section),
            [],
            $this->getValidationAttributes($section),
        );
    }


    // Mount
    public function mount($noResi)
    {
        $barang = Barang::with(['kategori', 'pemrosessan', 'payment', 'penerima', 'pengirim'])
            ->where('nomor_resi', $noResi)
            ->first();
        if (!$barang) {
            session()->flash('error', 'Barang tidak ditemukan!');
            to_route('barang');
        }
        $this->detailBarang = $barang;
        $this->histroyPrgoress = HistoryProsessBarang::where('id_barang', $barang->id)->get();
    }

    // Show Modal
    public function showModal($type)
    {
        $this->modalType = $type;

        if ($type === 'info-barang') {
            $this->barang = $this->detailBarang->only([
                'nama_barang',
                'id_kategori',
                'berat',
                'volume',
                'deskripsi_barang',
            ]);
            $this->barang['volume'] = number_format($this->barang['volume'], 0);
            $this->kategoriTerpilih = KategoriBarang::find($this->barang['id_kategori']);
        } elseif ($type === 'pengiriman') {
            $this->pengiriman = $this->detailBarang->pemrosessan->only([
                "id_staf",
                "status_proses",
                "catatan",
                "estimasi_waktu",
                "bukti",
            ]);
            $this->stafTerpilih = Staf::find($this->pengiriman['id_staf']);
            $this->pengiriman['estimasi_waktu'] = date('Y-m-d\TH:i', strtotime($this->pengiriman['estimasi_waktu']));
            $this->pengiriman["bukti"] = null;
            $this->buktiPreview = $this->detailBarang->pemrosessan->bukti;
        } elseif ($type === 'pengirim') {
            $this->pengirim = $this->detailBarang->pengirim->only([
                "nama",
                "no_hp",
                "alamat",
            ]);
        } elseif ($type === 'penerima') {
            $this->penerima = $this->detailBarang->penerima->only([
                "nama",
                "no_hp",
                "alamat",
            ]);
        } elseif ($type === 'pembayaran') {
            $this->pembayaran = $this->detailBarang->payment->only([
                "pays",
                "status",
            ]);
        }
    }

    // Close Modal
    public function closeModal()
    {
        $this->modalType = '';
    }

    // Select Kategori Barang
    public function selectKategori($value)
    {
        $this->barang['id_kategori'] = $value;
        $this->kategoriTerpilih = KategoriBarang::find($value);
    }

    // Update Info Barang
    public function updateInfoBarang()
    {
        $this->validate(
            $this->getValidationRules('barang'),
            [],
            $this->getValidationAttributes('barang'),
        );

        // Hitung Tarif
        $this->barang['total_tarif'] = $this->kategoriTerpilih->hitungTarif($this->barang['volume'], $this->barang['berat']);

        $this->detailBarang->update($this->barang);
        $this->detailBarang->save();
        session()->flash('message', 'Barang berhasil diubah.');
        $this->emit('closeModal');
    }

    // Update Pengiriman Barang
    public function updatePengiriman()
    {
        $this->validate(
            $this->getValidationRules('pengiriman'),
            [],
            $this->getValidationAttributes('pengiriman'),
        );
        $id_staf_lama = $this->detailBarang->pemrosessan->id_staf;
        $id_staf_baru = $this->pengiriman['id_staf'];

        if ($id_staf_lama !== $id_staf_baru) {
            $stafLama = Staf::find($id_staf_lama);
            if ($stafLama) {
                // Kembalikan kapasitas ke staf lama
                $stafLama->updateQtyTask(1);
            }

            // Kurangi kapasitas staf baru karena dapat tugas
            $stafBaru = Staf::find($id_staf_baru);
            if ($stafBaru && $stafBaru->qty_task > 0) {
                $stafBaru->updateQtyTask(-1);
            } else {
                session()->flash('error', "Staf $stafBaru->nama yang dipilih sudah penuh habis!");
                return;
            }
        }

        $pemrosesan = $this->detailBarang->pemrosessan;
        // Upload file baru 
        if ($this->pengiriman['bukti'] && is_object($this->pengiriman['bukti'])) {
            // Hapus file lama
            if ($pemrosesan->bukti && Storage::disk('public')->exists($pemrosesan->bukti)) {
                Storage::disk('public')->delete($pemrosesan->bukti);
            }
            // Simpan file baru
            $path = $this->pengiriman['bukti']->store('bukti-barang', 'public');
            $pemrosesan->bukti = $path;
        }

        // Update pemrosesan
        $pemrosesan->update([
            'id_staf' => $this->pengiriman['id_staf'],
            'status_proses' => $this->pengiriman['status_proses'],
            'estimasi_waktu' => $this->pengiriman['estimasi_waktu'],
            'catatan' => $this->pengiriman['catatan'],
        ]);

        $this->histroyPrgoress = HistoryProsessBarang::where('id_barang', $this->detailBarang->id)->get();

        session()->flash('message', 'Pengiriman barang berhasil diubah.');
        $this->emit('closeModal');
    }

    // Update si Pengirim Barang
    public function updatePengirim()
    {
        $this->validate(
            $this->getValidationRules('pengirim'),
            [],
            $this->getValidationAttributes('pengirim'),
        );
        $this->detailBarang->pengirim->update($this->pengirim);
        $this->detailBarang->pengirim->save();
        session()->flash('message', 'Pengirim barang berhasil diubah.');
        $this->emit('closeModal');
    }

    // Update si Penerima Barang
    public function updatePenerima()
    {
        $this->validate(
            $this->getValidationRules('penerima'),
            [],
            $this->getValidationAttributes('penerima'),
        );
        $this->detailBarang->penerima->update($this->penerima);
        $this->detailBarang->penerima->save();
        session()->flash('message', 'Penerima barang berhasil diubah.');
        $this->emit('closeModal');
    }

    // Update Pembayaran Barang
    public function updatePembayaran()
    {
        $this->validate(
            $this->getValidationRules('pembayaran'),
            [],
            $this->getValidationAttributes('pembayaran'),
        );
        $this->detailBarang->payment->update($this->pembayaran);
        $this->detailBarang->payment->save();
        session()->flash('message', 'Pembayaran barang berhasil diubah.');
        $this->emit('closeModal');
    }

    // delete barang
    public function deleteBarang()
    {
        $status = $this->detailBarang->pemrosessan->status_proses ?? null;

        if ($status === 'diproses') {
            session()->flash('error', 'Barang sedang diproses, tidak bisa dihapus!');
            return;
        }

        if ($status === 'diantar') {
            session()->flash('error', 'Barang sedang diantar, tidak bisa dihapus!');
            return;
        }

        // Hapus relasi satu-satu (kalau pakai cascading, ini bisa dilewat)
        $this->detailBarang->pengirim()?->delete();
        $this->detailBarang->penerima()?->delete();
        $this->detailBarang->payment()?->delete();
        $this->detailBarang->pemrosessan()?->delete();

        // Hapus barang utama
        $this->detailBarang->delete();

        to_route('barang')->with('message', 'Barang dan seluruh datanya berhasil dihapus!');
    }


    // file name Export
    private function fileNameExport($file)
    {
        return "report-barang-{$this->detailBarang->nama_barang}.{$file}";
    }

    // Pdf Export
    public function exportPdf()
    {
        return redirect()->route('barang.detail.pdf', [
            'nomor_resi' => $this->detailBarang->nomor_resi,
        ]);
    }

    // Excel Export
    public function exportExcel()
    {
        return Excel::download(new BarangDetailExport($this->detailBarang->id), $this->fileNameExport('xlsx'));
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.barang.detail-barang', [
            'kategori' => KategoriBarang::all(),
            'staf' => Staf::where('qty_task', '>', 0)->select('id', 'nama')->get(),
        ]);
    }
}
