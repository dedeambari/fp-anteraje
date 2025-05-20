<?php

namespace App\Rules;

use Carbon\Carbon;

class DetailBarangRules
{
    protected $pengiriman;
    protected $kategoriTerpilih;

    public function __construct($pengiriman = [], $kategoriTerpilih = null)
    {
        $this->pengiriman = $pengiriman;
        $this->kategoriTerpilih = $kategoriTerpilih;
    }

    public function rules(): array
    {
        return [
            'barang' => [
                'barang.nama_barang' => ["required", "string", "max:255"],
                'barang.id_kategori' => ["required", "exists:kategori_barangs,id_kategori"],
                'barang.volume' => [$this->kategoriTerpilih && $this->kategoriTerpilih->hitung_volume ? 'required' : 'nullable', 'numeric'],
                'barang.berat' => [$this->kategoriTerpilih && $this->kategoriTerpilih->hitung_berat ? 'required' : 'nullable', 'numeric'],
                'barang.deskripsi_barang' => ["nullable", "string", "regex:/^[A-Za-z0-9\s.,?!]+$/", "max:500"],
            ],
            'pengiriman' => [
                'pengiriman.id_staf' => ["required", "exists:stafs,id"],
                'pengiriman.catatan' => ["nullable", "string", "regex:/^[A-Za-z0-9\s.,?!]+$/", "max:500"],
                'pengiriman.status_proses' => ["required", "string", "in:diproses,diantar,diterima"],
                'pengiriman.estimasi_waktu' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        $status = $this->pengiriman['status_proses'];

                        $now = Carbon::now();
                        $inputTime = Carbon::parse($value);

                        if ($status === 'diproses' && $inputTime->lte($now)) {
                            $fail('Estimasi waktu harus setelah waktu sekarang untuk status diproses.');
                        }

                        if ($status === 'diantar' && $inputTime->lt($now)) {
                            $fail('Estimasi waktu harus sekarang atau setelahnya untuk status diantar.');
                        }

                        if ($status === 'diterima') {
                            $diffInSeconds = $now->diffInSeconds($inputTime);
                            if ($diffInSeconds > 60) {
                                $fail('Estimasi waktu harus tepat sama dengan waktu sekarang (±1 menit) untuk status diterima.');
                            }
                        }
                    }

                ],
                'pengiriman.bukti' => ["nullable", "image", "max:2048", "mimetypes:image/jpeg,image/png,image/jpg,image/webp"],
            ],
            'pengirim' => [
                'pengirim.nama' => ["required", "string", "max:255"],
                'pengirim.no_hp' => ['required', "regex:/^08[0-9]{9,11}$/"],
                'pengirim.alamat' => ["required", "string", "max:500"],
            ],
            'penerima' => [
                'penerima.nama' => ["required", "string", "max:255"],
                'penerima.no_hp' => ['required', "regex:/^08[0-9]{9,11}$/"],
                'penerima.alamat' => ["required", "string", "max:500"],
            ],
            'pembayaran' => [
                'pembayaran.pays' => ["required", "string", "in:pengirim,penerima"],
                'pembayaran.status' => ["required", "string", "in:belum_bayar,sudah_bayar"],
            ],
        ];
    }
}
