<?php

namespace App\Http\Livewire;


use App\Models\Barang;
use App\Models\Payment;
use App\Models\Staf;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    // total sales
    public $totalSales, $totalRupiah;

    // calculate percentage change
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


    // mount
    public function mount()
    {
        $barang = Barang::with(['kategori', 'pemrosessan', 'payment', 'penerima', 'pengirim'])->get();
        $this->totalSales = format_rupiah($barang->sum('total_tarif'));
        $this->totalRupiah = $barang->sum('total_tarif');
        $this->totalBarang = $barang->count();

        $firstCreatedBarang = Barang::orderBy('created_at', 'asc')->first();
        $lastCreatedBarang = Barang::orderBy('created_at', 'desc')->first();
        $this->tglOrdersLama = Carbon::createFromFormat('Y-m-d H:i:s', $firstCreatedBarang->created_at)
            ->format('y/m/j');
        $this->tglOrdersBaru = Carbon::createFromFormat('Y-m-d H:i:s', $lastCreatedBarang->created_at)
            ->format('M j');


        $this->totalUser = Staf::count();
        $firstCreatedUserDate = Staf::orderBy('created_at', 'asc')->first()->created_date_tmuld;
        $lastCreatedUserDate = Staf::orderBy('created_at', 'desc')->first()->created_date_tmuld;
        $this->tglUserLama = Carbon::parse($firstCreatedUserDate)->format('y/m/j');
        $this->tglUserBaru = Carbon::parse($lastCreatedUserDate)->format('M j');


        $this->totalYetPaid = Payment::where('status', "belum_bayar")->count();
        $firstCreatedYetPaid = Payment::where('status', "belum_bayar")->orderBy('created_at', 'asc')->first();
        $lastCreatedYetPaid = Payment::where('status', "belum_bayar")->orderBy('created_at', 'desc')->first();
        $this->tglYetPaidLama = Carbon::createFromFormat('Y-m-d H:i:s', $firstCreatedYetPaid->created_at)
            ->format('y/m/j');
        $this->tglYetPaidBaru = Carbon::createFromFormat('Y-m-d H:i:s', $lastCreatedYetPaid->created_at)
            ->format('M j');


        $this->totalPaid = Payment::where('status', "sudah_bayar")->count();
        $firstCreatedPaid = Payment::where('status', "sudah_bayar")->orderBy('created_at', 'asc')->first();
        $lastCreatedPaid = Payment::where('status', "sudah_bayar")->orderBy('created_at', 'desc')->first();
        $this->tglPaidLama = Carbon::createFromFormat('Y-m-d H:i:s', $firstCreatedPaid->created_at)
            ->format('y/m/j');
        $this->tglPaidBaru = Carbon::createFromFormat('Y-m-d H:i:s', $lastCreatedPaid->created_at)
            ->format('M j');


        $this->percentageChange = $this->calculatePercentageChange();

        $this->monthData = $this->getAvailableMonthlyChartData();
        $this->weekData = $this->getLastWeekChartData();
    }

    // calculate percentage change
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
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        // Ambil semua tanggal transaksi di bulan itu
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
        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay(); // 7 total, termasuk hari ini
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





    // render
    public function render()
    {
        return view('dashboard');
    }
}
