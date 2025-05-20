<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Staf;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpParser\Node\Stmt\TryCatch;

class EditBarang extends Component
{
    use WithFileUploads;

    public $nama_barang;
    public $id_kategori;
    public $berat;
    public $volume;
    public $deskripsi_barang;

    public $pays;
    public $status;

    public $penerima_nama;
    public $penerima_alamat;
    public $penerima_no_hp;

    public $pengirim_nama;
    public $pengirim_alamat;
    public $pengirim_no_hp;

    public $id_staf;
    public $status_proses;
    public $estimasi_waktu;
    public $catatan;
    public $bukti;

    public $dataBarang;
    public $kategoriTerpilih;
    public $stafTerpilih;
    public $buktiPreview;


    protected $listeners = ['selectKategori'];

    public function mount($nomorResi = null)
    {
        $this->dataBarang = Barang::with(['kategori', 'pengirim', 'penerima', 'pemrosessan', 'payment'])
            ->where('nomor_resi', $nomorResi)
            ->first();

        if (!$this->dataBarang) {
            session()->flash('error', 'Barang tidak ditemukan!');
            return redirect()->route('barang');
        }

        // Set kategori dan staf dulu agar bisa dipakai untuk validasi
        $this->kategoriTerpilih = $this->dataBarang->kategori;
        $this->stafTerpilih = $this->dataBarang->staf;

        // Info Barang
        $this->nama_barang = $this->dataBarang->nama_barang;
        $this->id_kategori = $this->dataBarang->id_kategori;
        $this->berat = $this->dataBarang->berat;
        $this->volume = number_format($this->dataBarang->volume, 0);
        $this->deskripsi_barang = $this->dataBarang->deskripsi_barang;

        // Pengiriman / pemrosessan barang
        $this->id_staf = $this->dataBarang->pemrosessan->id_staf;
        $this->status_proses = optional($this->dataBarang->pemrosessan)->status_proses;
        $this->estimasi_waktu = optional($this->dataBarang->pemrosessan)->estimasi_waktu;
        $this->catatan = optional($this->dataBarang->pemrosessan)->catatan;
        $this->buktiPreview = optional($this->dataBarang->pemrosessan)->bukti;

        // Penerima dan Pengirim
        $this->penerima_nama = optional($this->dataBarang->penerima)->nama;
        $this->penerima_alamat = optional($this->dataBarang->penerima)->alamat;
        $this->penerima_no_hp = optional($this->dataBarang->penerima)->no_hp;

        $this->pengirim_nama = optional($this->dataBarang->pengirim)->nama;
        $this->pengirim_alamat = optional($this->dataBarang->pengirim)->alamat;
        $this->pengirim_no_hp = optional($this->dataBarang->pengirim)->no_hp;

        // Pembayaran
        $this->pays = optional($this->dataBarang->payment)->pays;
        $this->status = optional($this->dataBarang->payment)->status;
    }

    // Validasi
    private function rulesMap()
    {
        $kategori = $this->kategoriTerpilih ?? KategoriBarang::find($this->id_kategori);

        return [
            'nama_barang' => ["required", "string", "max:255"],
            'id_kategori' => ["required", "exists:kategori_barangs,id_kategori"],
            'volume' => [$kategori && $kategori->hitung_volume ? 'required' : 'nullable', 'numeric'],
            'berat' => [$kategori && $kategori->hitung_berat ? 'required' : 'nullable', 'numeric'],
            'deskripsi_barang' => ["nullable", "string", "regex:/^[A-Za-z0-9\s.,?!]+$/", "max:500"],
            'id_staf' => ["required", "exists:stafs,id"],
            'estimasi_waktu' => ["required", "date", "after:now"],
            'catatan' => ["nullable", "string", "regex:/^[A-Za-z0-9\s.,?!]+$/", "max:500"],
            'status_proses' => ["required", "string", "in:diproses,diantar,diterima"],
            'bukti' => ["nullable", "image", "max:2048", "mimetypes:image/jpeg,image/png,image/jpg,image/webp"],
            'pengirim_nama' => ["required", "string", "max:255"],
            'pengirim_no_hp' => ['required', "regex:/^08[0-9]{9,11}$/"],
            'pengirim_alamat' => ["required", "string", "max:500"],
            'penerima_nama' => ["required", "string", "max:255"],
            'penerima_no_hp' => ['required', "regex:/^08[0-9]{9,11}$/"],
            'penerima_alamat' => ["required", "string", "max:500"],
            'pays' => ["required", "string", "in:pengirim,penerima"],
            'status' => ["required", "string", "in:belum_bayar,sudah_bayar"],
        ];
    }

    protected function getValidationAttributes()
    {
        return collect($this->rulesMap())
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rulesMap());
    }

    public function selectKategori($value)
    {
        $this->id_kategori = $value;
        $this->kategoriTerpilih = KategoriBarang::find($value);
    }

    public function updateAllData()
    {
        try {
            $this->validate($this->rulesMap());

            // 1. Update Barang
            $this->dataBarang->update([
                'nama_barang' => $this->nama_barang,
                'id_kategori' => $this->id_kategori,
                'berat' => $this->berat,
                'volume' => $this->volume,
                'deskripsi_barang' => $this->deskripsi_barang,
                'id_staf' => $this->id_staf,
            ]);

            // 2. Update Pemrosessan (Pengiriman)
            $pemrosesan = $this->dataBarang->pemrosessan;
            $id_staf_lama = $pemrosesan->id_staf ?? null;

            if ($id_staf_lama !== $this->id_staf) {
                if ($id_staf_lama) {
                    $stafLama = Staf::find($id_staf_lama);
                    $stafLama?->updateQtyTask(1); // kembalikan kapasitas
                }

                $stafBaru = Staf::find($this->id_staf);
                if ($stafBaru && $stafBaru->qty_task > 0) {
                    $stafBaru->updateQtyTask(-1); // kurangi kapasitas
                } else {
                    session()->flash('error', "Staf $stafBaru->nama yang dipilih sudah penuh habis!");
                    return;
                }
            }

            $pemrosesan = $this->dataBarang->pemrosessan;

            // Upload file baru jika ada
            if ($this->bukti && is_object($this->bukti)) {
                // Hapus file lama jika ada
                if ($pemrosesan->bukti && Storage::disk('public')->exists($pemrosesan->bukti)) {
                    Storage::disk('public')->delete($pemrosesan->bukti);
                }

                // Simpan file baru
                $path = $this->bukti->store('bukti-barang', 'public');
                $pemrosesan->bukti = $path;
            }

            // Update pemrosesan
            $pemrosesan->update([
                'id_staf' => $this->id_staf,
                'status_proses' => $this->status_proses,
                'estimasi_waktu' => $this->estimasi_waktu,
                'catatan' => $this->catatan,
            ]);

            // 3. Update Pengirim
            $this->dataBarang->pengirim->update([
                'nama' => $this->pengirim_nama,
                'alamat' => $this->pengirim_alamat,
                'no_hp' => $this->pengirim_no_hp,
            ]);

            // 4. Update Penerima
            $this->dataBarang->penerima->update([
                'nama' => $this->penerima_nama,
                'alamat' => $this->penerima_alamat,
                'no_hp' => $this->penerima_no_hp,
            ]);

            // 5. Update Pembayaran
            $this->dataBarang->payment->update([
                'pays' => $this->pays,
                'status' => $this->status,
            ]);

            to_route('barang.detail', $this->dataBarang->nomor_resi)
                ->with('message', 'Barang berhasil diupdate!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.barang.edit-barang', [
            'kategori' => KategoriBarang::all(),
            'staf' => Staf::all(),
            'kategoriTerpilih' => $this->id_kategori ? KategoriBarang::find($this->id_kategori) : null,
            'stafTerpilih' => $this->id_staf ? Staf::find($this->id_staf) : null,
        ]);
    }
}
