<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Pengadaan extends Component
{
    public $vendor_idvendor;
    public $status = 'P', $ppn = 10, $vendors = [], $data = [];

    public function mount()
    {
        $this->vendors = DB::select("SELECT * from vendor_aktif");

        $this->loadData();
    }

    public function loadData()
    {
        $this->data = DB::select("select * from view_pengadaan");
    }

    public function store()
    {
        if (!$this->vendor_idvendor) {
            session()->flash('err', 'Vendor wajib dipilih!');
            return;
        }

        DB::insert("
            INSERT INTO pengadaan (vendor_idvendor, user_iduser, status, ppn)
            VALUES (?, ?, ?, ?)
        ", [
            $this->vendor_idvendor,
            auth()->id(),
            $this->status,
            $this->ppn ?? 10
        ]);

        $this->reset(['vendor_idvendor', 'status', 'ppn']);
        session()->flash('ok', 'Pengadaan berhasil ditambahkan!');
        $this->dispatch('close-modal');

        $this->loadData();
    }

    public function delete($id)
    {
        try {
            DB::delete("DELETE FROM pengadaan where idpengadaan = ?", [$id]);
            db::delete("CALL `Global_Reset_Auto_Increment`()");
            session()->flash('ok', 'pengadaan berhasil dihapus!');
        } catch (\Throwable $e) {
            session()->flash('err', 'Gagal menghapus pengadaan: ' . $e->getMessage());
        }
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.transaction.pengadaan');
    }
}
