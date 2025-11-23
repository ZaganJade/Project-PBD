<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Penjualan extends Component
{
    public $listPenjualan = [];

    public function mount()
    {
        $this->listPenjualan = DB::select("SELECT * FROM views_penjualan");
    }

    public function render()
    {
        return view('livewire.transaction.penjualan');
    }
}
