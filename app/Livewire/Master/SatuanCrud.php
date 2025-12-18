<?php
namespace App\Livewire\Master;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SatuanCrud extends Component
{
    public $nama_satuan, $status = 1, $idsatuan, $isEdit = false;

    protected $rules = [
        'nama_satuan' => 'required|string|max:45',
        'status' => 'required|in:0,1'
    ];

    public function render()
    {
        // $data = DB::select('SELECT * FROM satuan ORDER BY idsatuan ASC');

        $data = db::select("select * from view_satuan");
        $dataaktif = db::select("select * from viewsatuan_aktif");
        return view('livewire.master.satuan-crud', [
            'data' => $data,
            'dataaktif' => $dataaktif
        ]);
    }

    public function resetForm()
    {
        $this->nama_satuan = '';
        $this->status = 1;
        $this->idsatuan = null;
        $this->isEdit = false;

        $this->dispatch('show-modal');
    }

    public function store()
    {
        $this->validate();
        DB::insert('INSERT INTO satuan (nama_satuan, status) VALUES (?, ?)', [
            $this->nama_satuan,
            $this->status
        ]);

        session()->flash('ok', 'Satuan ditambahkan');
        $this->resetForm();

        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $m = DB::select('SELECT * FROM satuan WHERE idsatuan = ? LIMIT 1', [$id]);

        if ($m) {
            $this->idsatuan = $m[0]->idsatuan;
            $this->nama_satuan = $m[0]->nama_satuan;
            $this->status = $m[0]->status;
            $this->isEdit = true;
        }
        $this->dispatch('show-modal');
    }

    public function update()
    {
        $this->validate();
        DB::update('UPDATE satuan SET nama_satuan = ?, status = ? WHERE idsatuan = ?', [
            $this->nama_satuan,
            $this->status,
            $this->idsatuan
        ]);

        session()->flash('ok', 'Satuan diupdate');
        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function delete($id)
    {
        try {
            // Hapus data
            DB::delete('DELETE FROM satuan WHERE idsatuan = ?', [$id]);
            db::delete("CALL `Global_Reset_Auto_Increment`()");
            session()->flash('ok', 'Satuan dihapus');
        } catch (\Throwable $e) {
            session()->flash('err', 'Gagal hapus (dipakai di barang)');
        }
    }
}
