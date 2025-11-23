<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class KartuStock extends Component
{
    public $searchNama = '';
    public $rekap = [];
    public $stokAkhir = 0;

    public $detailBarangId = null;
    public $detailLog = [];

    public function mount()
    {
        $this->loadRekap();
    }

    public function updatedSearchNama()
    {
        $this->loadRekap();
    }

    public function loadRekap()
    {
        $this->rekap = DB::select("
            SELECT *
            FROM views_kartu_stock_rekap
            WHERE nama_barang LIKE ?
            ORDER BY idbarang
        ", [
            '%' . $this->searchNama . '%'
        ]);
    }

    public function lihatDetail($idbarang)
    {
        $this->detailBarangId = $idbarang;
        $this->detailLog = DB::select("
        SELECT *
        FROM views_kartu_stock
        WHERE idbarang = ?
        ORDER BY tanggal DESC
    ", [$idbarang]);

        $this->stokAkhir = count($this->detailLog) > 0
            ? $this->detailLog[0]->stok_akhir
            : 0;
    }


    public function tutupDetail()
    {
        $this->detailBarangId = null;
        $this->detailLog = [];
    }

    public function render()
    {
        return view('livewire.master.kartu-stock');
    }
}
