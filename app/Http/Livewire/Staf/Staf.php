<?php

namespace App\Http\Livewire\Staf;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Staf extends Component
{
    use WithPagination;

    // set status deactive
    public $status_deactive_staf;
    // set date
    public $dateFrom, $dateTo;

    public $fileNameExport;

    public $otp;

    // listener event
    protected $listeners = [
        'activedStaf',
        'deactiveStaf',
        'deletedStaf',
        'filterStatus',
        'filterByDateRange',
        'generateResetOtp'
    ];

    // mount
    public function mount()
    {
        $this->status_deactive_staf = null;
    }

    // delete staf inactive
    public function deactiveStaf($stafId)
    {
        $staf = \App\Models\Staf::find($stafId);
        if ($staf) {
            $staf->delete();
            session()->flash('message', "Staf $staf->nama inactive successfully!");
        } else {
            session()->flash('error', 'Staf not found!');
        }
    }

    // restore staf active
    public function activedStaf($stafId)
    {
        $staf = \App\Models\Staf::onlyTrashed()->find($stafId);
        if ($staf) {
            $staf->restore();
            session()->flash('message', "Staf $staf->nama active successfully!");
        } else {
            session()->flash('error', 'Staf not found!');
        }
    }

    // delete permanen staf
    public function deletedStaf($stafId)
    {
        $staf = \App\Models\Staf::with(['pemrosesanBarangs'])->withTrashed()->find($stafId);

        if (!$staf) {
            session()->flash('error', 'Staf tidak ditemukan!');
            return;
        }

        // Cek jika masih ada proses yang belum "diterima"
        $masihBerlangsung = $staf->pemrosesanBarangs->contains(fn($item) => $item->status_proses !== 'diterima');

        if ($masihBerlangsung) {
            session()->flash('error', 'Staf tidak bisa dihapus karena masih ada proses barang yang belum selesai.');
            return;
        }

        // Hapus semua pemrosesan barang jika sudah selesai
        $staf->pemrosesanBarangs->each->delete();

        // Hapus staf secara permanen
        $staf->forceDelete();

        session()->flash('message', "Staf berhasil dihapus permanen!");
    }

    // filtering status
    public function filterStatus($status)
    {
        if ($status === '1') {
            $this->status_deactive_staf = 1;
        } elseif ($status === '0') {
            $this->status_deactive_staf = 0;
        } else {
            $this->status_deactive_staf = null;
        }
    }

    // filtering date
    public function filterByDateRange($data)
    {
        $this->dateFrom = $data['dateFrom'];
        $this->dateTo = $data['dateTo'];
    }

    // data staf
    public function dataStaf()
    {
        if ($this->status_deactive_staf === 1) {
            $this->fileNameExport = "report-staf-active-" . date('d-m-Y');
            $staf = \App\Models\Staf::orderByDesc('created_at')->paginate(5);
        } elseif ($this->status_deactive_staf === 0) {
            $this->fileNameExport = "report-staf-inactive-" . date('d-m-Y');
            $staf = \App\Models\Staf::orderByDesc('created_at')->onlyTrashed()->paginate(5);
        } elseif ($this->dateFrom && $this->dateTo) {
            $this->fileNameExport = "report-staf-date-{$this->dateFrom}-{$this->dateTo}-" . date('d-m-Y');
            $staf = \App\Models\Staf::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->orderByDesc('created_at')->paginate(5);
        } else {
            $this->fileNameExport = "report-staf-all-" . date('d-m-Y');
            $staf = \App\Models\Staf::orderByDesc('created_at')->withTrashed()->paginate(5);
        }

        return $staf->through(function ($staf) {
            $staf->profile = $staf->profile ??= "default.jpeg";
            $staf->created_at_human = $staf->created_at->diffForHumans();
            $staf->status_deactive_staf = $staf->deleted_at === null ? 1 : 0;
            return $staf;
        });
    }

    // generate reset otp
    public function generateResetOtp($id)
    {
        $staf = \App\Models\Staf::findOrFail($id);

        // Cek apakah ada OTP dan masih aktif
        if ($staf->reset_otp && $staf->reset_otp_expired_at && now()->lessThan($staf->reset_otp_expired_at)) {
            session()->flash('message', 'OTP masih aktif. Silakan gunakan OTP yang sudah ada.');
            $this->emit("valueOtp", [
                "id" => $staf->id,
                "otp" => $staf->reset_otp,
                'expired_at' => Carbon::parse($staf->reset_otp_expired_at)->toIso8601String(),
                'nama' => $staf->nama
            ]);
            return;
        }

        // Buat OTP baru
        $otp = random_int(100000, 999999);

        $staf->update([
            'reset_otp' => $otp,
            'reset_otp_expired_at' => now()->addMinutes(10),
        ]);

        session()->flash('message', 'OTP berhasil dibuat dan berlaku 10 menit.');

        $this->emit("valueOtp", [
            "id" => $staf->id,
            "otp" => $otp,
            'expired_at' => Carbon::now()->addMinutes(10)->toIso8601String(),
            'nama' => $staf->nama
        ]);
    }


    // render
    public function render()
    {
        return view('livewire.staf.staf', [
            'staf' => $this->dataStaf()
        ]);
    }
}
