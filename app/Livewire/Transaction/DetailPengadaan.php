<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DetailPengadaan extends Component
{
    public $idpengadaan,$pengadaan,$detailPengadaan = [],$barangList = [],$iddetail;
    public $idbarang = '';
    public $jumlah = 1;
    public $harga_satuan = 0;
    public $nama_satuan = '';
    public $total_harga = 0;
    public $isEdit = false;

    public function mount($idpengadaan)
    {
        $this->idpengadaan = $idpengadaan;
        $this->pengadaan = DB::selectOne("
            SELECT p.*, v.nama_vendor, v.badan_hukum, u.username, r.nama_role
            FROM pengadaan p
            JOIN vendor v ON v.idvendor = p.vendor_idvendor
            JOIN user u   ON u.iduser = p.user_iduser
            JOIN role r   ON r.idrole = u.idrole
            WHERE p.idpengadaan = ?
        ", [$idpengadaan]);

        $this->detailPengadaan = DB::select("
            SELECT d.*, b.nama AS nama_barang, b.harga AS harga_barang, s.nama_satuan
            FROM detail_pengadaan d
            JOIN barang b ON b.idbarang = d.idbarang
            JOIN satuan s ON s.idsatuan = b.idsatuan
            WHERE d.idpengadaan = ?
        ", [$idpengadaan]);

        $this->barangList = DB::select("
            SELECT b.*, s.nama_satuan
            FROM barang b
            JOIN satuan s ON s.idsatuan = b.idsatuan
            where b.status = 1
            ORDER BY b.nama ASC
        ");
    }


public function updated($name)
{
    if ($name === 'idbarang') {
        if (!$this->idbarang) {
            $this->harga_satuan = 0;
            $this->nama_satuan = '';
            $this->total_harga = 0;
            return;
        }

        $barang = DB::selectOne("
            SELECT b.harga, s.nama_satuan
            FROM barang b
            JOIN satuan s ON s.idsatuan = b.idsatuan
            WHERE b.idbarang = ?
        ", [$this->idbarang]);

        $this->harga_satuan = $barang->harga ?? 0;
        $this->nama_satuan = $barang->nama_satuan ?? '';
        $this->total_harga = (int)$this->jumlah * (int)$this->harga_satuan;
    }

    if ($name === 'jumlah') {
        $this->total_harga = (int)$this->jumlah * (int)$this->harga_satuan;
    }
}

    public function refreshDetail()
    {
        $this->detailPengadaan = DB::select("
            SELECT d.*, b.nama AS nama_barang, b.harga AS harga_barang,
                    s.nama_satuan
            FROM detail_pengadaan d
            JOIN barang b ON b.idbarang = d.idbarang
            JOIN satuan s ON s.idsatuan = b.idsatuan
            WHERE d.idpengadaan = ?
        ", [$this->idpengadaan]);

        $this->pengadaan = DB::selectOne("
            SELECT p.*, v.nama_vendor, u.username
            FROM pengadaan p
            JOIN vendor v ON v.idvendor = p.vendor_idvendor
            JOIN user u ON u.iduser = p.user_iduser
            WHERE p.idpengadaan = ?
        ", [$this->idpengadaan]);

    }

    public function resetForm()
    {
        $this->idbarang = '';
        $this->jumlah = 1;
        $this->harga_satuan = 0;
        $this->nama_satuan = '';
        $this->total_harga = 0;
        $this->iddetail = null;
        $this->isEdit = false;

        $this->dispatch('show-modal');
    }

    public function store()
    {
        DB::insert("
            INSERT INTO detail_pengadaan(idpengadaan, idbarang, jumlah, harga_satuan, sub_total)
            VALUES (?, ?, ?, ?, ?)
        ", [
            $this->idpengadaan,
            $this->idbarang,
            $this->jumlah,
            $this->harga_satuan,
            $this->total_harga
        ]);

        $this->resetForm();
        $this->dispatch('close-modal');
        $this->refreshDetail();
        session()->flash('ok', 'Item berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = DB::selectOne("
        SELECT d.*, b.nama, b.harga AS harga_barang, s.nama_satuan
        FROM detail_pengadaan d
        JOIN barang b ON b.idbarang = d.idbarang
        JOIN satuan s ON s.idsatuan = b.idsatuan
        WHERE iddetail_pengadaan = ?
    ", [$id]);

        if (!$item) {
            session()->flash('err', 'Item tidak ditemukan!');
            return;
        }
        $this->iddetail = $item->iddetail_pengadaan;
        $this->idbarang = $item->idbarang;
        $this->nama_satuan = $item->nama_satuan;
        $this->harga_satuan = $item->harga_barang;
        $this->jumlah = $item->jumlah;
        $this->total_harga = $this->jumlah * $this->harga_satuan;

        $this->isEdit = true;
    }
    
    public function update()
    {
        DB::update("
            UPDATE detail_pengadaan
            SET idbarang = ?,
                jumlah = ?,
                harga_satuan = ?,
                sub_total = ?
            WHERE iddetail_pengadaan = ?
        ", [
            $this->idbarang,
            $this->jumlah,
            $this->harga_satuan,
            $this->jumlah * $this->harga_satuan,
            $this->iddetail
        ]);

        $this->resetForm();
        $this->refreshDetail();
        $this->dispatch('close-modal');
        session()->flash('ok', 'Item berhasil diperbarui!');
    }

    public function delete($id)
    {
        DB::delete("DELETE FROM detail_pengadaan WHERE iddetail_pengadaan = ?", [$id]);
        DB::statement("CALL Global_Reset_Auto_Increment()");

        $this->refreshDetail();
        session()->flash('ok', 'Item berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.transaction.Detail-Pengadaan');
    }
}
