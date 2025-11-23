<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DetailPenerimaan extends Component
{
    public $idpenerimaan;
    public $header;
    public $details = [];

    public function mount($idpenerimaan)
    {
        $this->idpenerimaan = $idpenerimaan;
        $this->loadData();
    }

    public function loadData()
    {
        $this->header = DB::selectOne("
            SELECT *
            FROM views_penerimaan
            WHERE idpenerimaan = ?
            LIMIT 1
        ", [$this->idpenerimaan]);

        $this->details = DB::select("
            SELECT *
            FROM views_detail_penerimaan
            WHERE idpenerimaan = ?
            ORDER BY iddetail_penerimaan ASC
        ", [$this->idpenerimaan]);
    }

    public function render()
    {
        return view('livewire.transaction.detail-penerimaan');
    }
}
