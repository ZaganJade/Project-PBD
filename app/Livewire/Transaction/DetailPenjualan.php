<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DetailPenjualan extends Component
{
    public $idpenjualan;
    public $header;
    public $detail = [];

    public function mount($idpenjualan)
    {
        $this->idpenjualan = $idpenjualan;

        $this->header = DB::selectOne("
            SELECT * FROM views_penjualan WHERE idpenjualan = ?
        ", [$idpenjualan]);

        $this->detail = DB::select("
            SELECT * FROM views_detail_penjualan WHERE idpenjualan = ?
        ", [$idpenjualan]);
    }

    public function render()
    {
        return view('livewire.transaction.Detail-penjualan');
    }
}
