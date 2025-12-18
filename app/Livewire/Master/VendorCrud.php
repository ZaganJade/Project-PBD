<?php
namespace App\Livewire\Master;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VendorCrud extends Component
{
    public $nama_vendor, $badan_hukum, $status = 1, $idvendor, $isEdit = false;

    protected $rules = [
        'nama_vendor' => 'required|string|max:100',
        'badan_hukum' => 'required|in:P,S,U',
        'status'      => 'required|in:0,1'
    ];

    public function render()
    {
        $semuaData = DB::select('SELECT * FROM semua_vendor');
        $DataAktif = DB::select('SELECT * FROM vendor_aktif');
        return view('livewire.master.vendor-crud', [
            'semuaData' => $semuaData,
            'DataAktif' => $DataAktif
        ]);
    }

    public function resetForm()
    {
        $this->nama_vendor = '';
        $this->badan_hukum = '';
        $this->status = 1;
        $this->idvendor = null;
        $this->isEdit = false;

        $this->dispatch('show-modal');
    }

    public function store()
    {
        $this->validate();
        DB::insert('INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES (?, ?, ?)', [
            $this->nama_vendor,
            $this->badan_hukum,
            $this->status
        ]);

        session()->flash('ok', 'Vendor ditambahkan');
        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $m = DB::select('SELECT * FROM vendor WHERE idvendor = ? LIMIT 1', [$id]);

        if ($m) {
            $this->idvendor     = $m[0]->idvendor;
            $this->nama_vendor  = $m[0]->nama_vendor;
            $this->badan_hukum  = $m[0]->badan_hukum;
            $this->status       = $m[0]->status;
            $this->isEdit       = true;
        }
        $this->dispatch('show-modal');
    }

    public function update()
    {
        $this->validate();
        DB::update('UPDATE vendor SET nama_vendor = ?, badan_hukum = ?, status = ? WHERE idvendor = ?', [
            $this->nama_vendor,
            $this->badan_hukum,
            $this->status,
            $this->idvendor
        ]);

        session()->flash('ok', 'Vendor diupdate');
        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function delete($id)
    {
        try {
            DB::delete('DELETE FROM vendor WHERE idvendor = ?', [$id]);
            db::delete("CALL `Global_Reset_Auto_Increment`()");
            session()->flash('ok', 'Vendor dihapus');
        } catch (\Throwable $e) {
            session()->flash('err', 'Gagal hapus (data mungkin dipakai tabel lain)');
        }
    }
}
