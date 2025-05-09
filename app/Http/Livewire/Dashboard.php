<?php

namespace App\Http\Livewire;


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
        

    }

    // calculate percentage change
    public function calculatePercentageChange()
    {
       
    }

    // render
    public function render()
    {
        return view('dashboard');
    }
}
