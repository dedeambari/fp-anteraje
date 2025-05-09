<?php

namespace App\Http\Livewire;

use App\Models\customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    // total sales
    public $totalSales;

    // calculate percentage change
    public $percentageChange;

    public $totalUser;
    public $tglUserLama;
    public $tglUserBaru;

    public $totalOrders;
    public $tglOrdersLama;
    public $tglOrdersBaru;

    public $totalYetPaid;
    public $tglYetPaidLama;
    public $tglYetPaidBaru;

    public $totalPaid;
    public $tglPaidLama;
    public $tglPaidBaru;


    // mount
    public function mount()
    {
        // Tanggal user lama
        // $firstCreatedUserDate = User::orderBy('created_date_tmuld', 'asc')->first()->created_date_tmuld;

        // // Tanggal user terbaru
        // $lastCreatedUserDate = User::orderBy('created_date_tmuld', 'desc')->first()->created_date_tmuld;

        // $this->tglUserLama = Carbon::parse($firstCreatedUserDate)->format('y/m/j');
        // $this->tglUserBaru = Carbon::parse($lastCreatedUserDate)->format('M j');


        // // Total orders
        // $this->totalOrders = customer::count();
        // // Tanggal orders lama
        // $firstCreatedOrder = DB::table('customer')->orderBy('created_at', 'asc')->first();
        // $lastCreatedOrder = DB::table('customer')->orderBy('created_at', 'desc')->first();
        // $this->tglOrdersLama = Carbon::createFromFormat('Y-m-d H:i:s', $firstCreatedOrder->created_at)
        //     ->format('y/m/j');
        // $this->tglOrdersBaru = Carbon::createFromFormat('Y-m-d H:i:s', $lastCreatedOrder->created_at)
        //     ->format('M j');


        // // Total yet paid
        // $this->totalYetPaid = customer::where('status_bayar', 0)->count();
        // // Tanggal yet paid lama
        // $firstCreatedYetPaid = DB::table('customer')->where('status_bayar', 0)->orderBy('created_at', 'asc')->first();
        // $lastCreatedYetPaid = DB::table('customer')->where('status_bayar', 0)->orderBy('created_at', 'desc')->first();
        // $this->tglYetPaidLama = Carbon::createFromFormat('Y-m-d H:i:s', $firstCreatedYetPaid->created_at)
        //     ->format('y/m/j');
        // $this->tglYetPaidBaru = Carbon::createFromFormat('Y-m-d H:i:s', $lastCreatedYetPaid->created_at)
        //     ->format('M j');



        // // Total paid
        // $this->totalPaid = customer::where('status_bayar', 1)->count();
        // // Tanggal paid lama
        // $firstCreatedPaid = DB::table('customer')->where('status_bayar', 1)->orderBy('created_at', 'asc')->first();
        // $lastCreatedPaid = DB::table('customer')->where('status_bayar', 1)->orderBy('created_at', 'desc')->first();
        // $this->tglPaidLama = Carbon::createFromFormat('Y-m-d H:i:s', $firstCreatedPaid->created_at)
        //     ->format('y/m/j');
        // $this->tglPaidBaru = Carbon::createFromFormat('Y-m-d H:i:s', $lastCreatedPaid->created_at)
        //     ->format('M j');


        // // total penjualan
        // $this->totalSales = customer::sum('bayar');
        // $this->percentageChange = $this->calculatePercentageChange();
        // $this->totalUser = User::count();

    }

    // calculate percentage change
    public function calculatePercentageChange()
    {
        // $previousSales = customer::whereDate('created_at', '<', now()->subDay()->toDateString())->sum('bayar');
        // if ($previousSales == 0)
        //     return 0;
        // return (($this->totalSales - $previousSales) / $previousSales) * 100;
    }

    // render
    public function render()
    {
        return view('dashboard');
    }
}
