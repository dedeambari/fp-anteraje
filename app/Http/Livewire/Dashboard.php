<?php

namespace App\Http\Livewire;

use App\Models\Barang;
use App\Models\Payment;
use App\Models\Staf;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalSales, $totalRupiah;
    public $percentageChange;
    public $totalUser;
    public $tglUserLama;
    public $tglUserBaru;
    public $totalBarang;
    public $tglOrdersLama;
    public $tglOrdersBaru;
    public $totalYetPaid;
    public $tglYetPaidLama;
    public $tglYetPaidBaru;
    public $totalPaid;
    public $tglPaidLama;
    public $tglPaidBaru;
    public $monthData, $weekData;

    public function mount()
    {
        $barang = Barang::with(['kategori', 'pemrosessan', 'payment', 'penerima', 'pengirim'])->get();

        $this->totalSales = format_rupiah($barang->sum('total_tarif'));
        $this->totalRupiah = $barang->sum('total_tarif');
        $this->totalBarang = $barang->count();

        // Barang tanggal lama dan baru
        $firstCreatedBarang = Barang::orderBy('created_at', 'asc')->first();
        $lastCreatedBarang = Barang::orderBy('created_at', 'desc')->first();

        if ($firstCreatedBarang && $lastCreatedBarang) {
            $this->tglOrdersLama = Carbon::parse($firstCreatedBarang->created_at)->format('y/m/j');
            $this->tglOrdersBaru = Carbon::parse($lastCreatedBarang->created_at)->format('M j');
        } else {
            $this->tglOrdersLama = '-';
            $this->tglOrdersBaru = '-';
        }

        // User count dan tanggal
        $this->totalUser = Staf::count();

        $firstCreatedUser = Staf::orderBy('created_at', 'asc')->first();
        $lastCreatedUser = Staf::orderBy('created_at', 'desc')->first();

        if ($firstCreatedUser && $lastCreatedUser) {
            $this->tglUserLama = Carbon::parse($firstCreatedUser->created_date_tmuld ?? $firstCreatedUser->created_at)->format('y/m/j');
            $this->tglUserBaru = Carbon::parse($lastCreatedUser->created_date_tmuld ?? $lastCreatedUser->created_at)->format('M j');
        } else {
            $this->tglUserLama = '-';
            $this->tglUserBaru = '-';
        }

        // Payment belum bayar
        $this->totalYetPaid = Payment::where('status', "belum_bayar")->count();
        $firstCreatedYetPaid = Payment::where('status', "belum_bayar")->orderBy('created_at', 'asc')->first();
        $lastCreatedYetPaid = Payment::where('status', "belum_bayar")->orderBy('created_at', 'desc')->first();

        if ($firstCreatedYetPaid && $lastCreatedYetPaid) {
            $this->tglYetPaidLama = Carbon::parse($firstCreatedYetPaid->created_at)->format('y/m/j');
            $this->tglYetPaidBaru = Carbon::parse($lastCreatedYetPaid->created_at)->format('M j');
        } else {
            $this->tglYetPaidLama = '-';
            $this->tglYetPaidBaru = '-';
        }

        // Payment sudah bayar
        $this->totalPaid = Payment::where('status', "sudah_bayar")->count();
        $firstCreatedPaid = Payment::where('status', "sudah_bayar")->orderBy('created_at', 'asc')->first();
        $lastCreatedPaid = Payment::where('status', "sudah_bayar")->orderBy('created_at', 'desc')->first();

        if ($firstCreatedPaid && $lastCreatedPaid) {
            $this->tglPaidLama = Carbon::parse($firstCreatedPaid->created_at)->format('y/m/j');
            $this->tglPaidBaru = Carbon::parse($lastCreatedPaid->created_at)->format('M j');
        } else {
            $this->tglPaidLama = '-';
            $this->tglPaidBaru = '-';
        }

        $this->percentageChange = $this->calculatePercentageChange();
        $this->monthData = $this->getAvailableMonthlyChartData();
        $this->weekData = $this->getLastWeekChartData();
    }

    public function calculatePercentageChange()
    {
        $previousSales = Barang::whereDate('created_at', '<', now()->subDay()->toDateString())->sum('total_tarif');
        if ($previousSales == 0) {
            return 0;
        }
        $change = (($this->totalRupiah - $previousSales) / $previousSales) * 100;
        return round($change, 2);
    }

    public function getAvailableMonthlyChartData($month = null, $year = null)
    {
        $month = $month ??= now()->month;
        $year = $year ??= now()->year;

        $datesInMonth = Barang::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('date');

        if ($datesInMonth->isEmpty()) {
            return [];
        }

        $start = Carbon::parse($datesInMonth->first());
        $end = Carbon::parse($datesInMonth->last());

        $data = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $total = Barang::whereDate('created_at', $date->toDateString())->sum('total_tarif');
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'total_tarif' => (float) $total,
            ];
        }

        return $data;
    }

    public function getLastWeekChartData()
    {
        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();
        $today = Carbon::now()->endOfDay();

        $data = [];
        for ($date = $sevenDaysAgo->copy(); $date->lte($today); $date->addDay()) {
            $total = Barang::whereDate('created_at', $date->toDateString())->sum('total_tarif');
            $data[] = [
                'date' => $date->diffForHumans(),
                'total_tarif' => (float) $total,
            ];
        }

        return $data;
    }

    public function render()
    {
        return view('dashboard');
    }
}
