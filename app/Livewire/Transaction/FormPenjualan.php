<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FormPenjualan extends Component
{
    public $barangList = [];
    public $marginAktif;
    public $ppn = 10;
    public $idbarang;
    public $harga_modal;
    public $harga_satuan;
    public $jumlah = 1;

    public $keranjang = [];
    public $subtotal_penjualan = 0;
    public $total_penjualan = 0;

    public function mount()
    {
        $this->barangList = DB::select("
            SELECT * from views_barang_stok
        ");

        $this->marginAktif = DB::selectOne("
            SELECT *
            FROM views_margin_penjualan_aktif
            LIMIT 1
        ");

        $this->jumlah = 1;
        $this->updateTotals();
    }

    public function updatedIdbarang($value)
    {
        if (!$value) {
            $this->harga_modal = null;
            $this->harga_satuan = null;
            $this->dispatch('refresh');
            return;
        }
        $barang = collect($this->barangList)->firstWhere('idbarang', (int) $value);
        if ($barang) {
            $this->harga_modal = $barang->harga;
            $this->harga_satuan = $this->hitungHargaJual($barang->harga);
        } else {
            $this->harga_modal = null;
            $this->harga_satuan = null;
        }
    }
    protected function hitungHargaJual($hargaModal)
    {
        if (!$this->marginAktif) {
            return (int) $hargaModal;
        }
        $margin = (float) $this->marginAktif->persen;
        return (int) round($hargaModal + ($hargaModal * $margin / 100));
    }
    public function addItem()
    {
        $this->validate([
            'idbarang' => 'required|integer',
            'harga_satuan' => 'required|integer|min:0',
            'jumlah' => 'required|integer|min:1',
        ], [
            'idbarang.required' => 'Pilih barang terlebih dahulu.',
        ]);

        $barang = collect($this->barangList)->firstWhere('idbarang', (int) $this->idbarang);

        if (!$barang) {
            session()->flash('err', 'Barang tidak ditemukan.');
            return;
        }

        $subtotal = $this->jumlah * $this->harga_satuan;
        $index = collect($this->keranjang)->search(function ($row) {
            return $row['idbarang'] == $this->idbarang;
        });

        if ($index !== false) {
            $this->keranjang[$index]['jumlah'] += $this->jumlah;
            $this->keranjang[$index]['subtotal'] += $subtotal;
        } else {
            $this->keranjang[] = [
                'idbarang' => (int) $this->idbarang,
                'nama_barang' => $barang->nama,
                'nama_satuan' => $barang->nama_satuan,
                'harga_modal' => (int) $this->harga_modal,
                'harga_satuan' => (int) $this->harga_satuan,
                'jumlah' => (int) $this->jumlah,
                'subtotal' => (int) $subtotal,
            ];
        }
        $this->reset(['idbarang', 'harga_modal', 'harga_satuan', 'jumlah']);
        $this->jumlah = 1;

        $this->updateTotals();
    }
    public function removeItem($index)
    {
        if (isset($this->keranjang[$index])) {
            unset($this->keranjang[$index]);
            $this->keranjang = array_values($this->keranjang);
            $this->updateTotals();
        }
    }

    protected function updateTotals()
    {
        $this->subtotal_penjualan = collect($this->keranjang)->sum('subtotal');
        $this->total_penjualan = $this->subtotal_penjualan
            + (int) round($this->subtotal_penjualan * $this->ppn / 100);
    }

    public function simpanPenjualan()
    {
        if (empty($this->keranjang)) {
            session()->flash('err', 'Keranjang masih kosong.');
            return;
        }

        if (!$this->marginAktif) {
            session()->flash('err', 'Tidak ada margin penjualan aktif.');
            return;
        }

        DB::beginTransaction();
        try {
            $this->updateTotals();

            DB::insert("
                INSERT INTO penjualan (subtotal_nilai, ppn, total_nilai, iduser, idmargin_penjualan)
                VALUES (?, ?, ?, ?, ?)
            ", [
                $this->subtotal_penjualan,
                $this->ppn,
                $this->total_penjualan,
                auth()->id(),
                $this->marginAktif->idmargin_penjualan,
            ]);

            $idpenjualan = DB::getPdo()->lastInsertId();

            foreach ($this->keranjang as $item) {
                DB::insert("
                    INSERT INTO detail_penjualan (harga_satuan, jumlah, penjualan_idpenjualan, idbarang)
                    VALUES (?, ?, ?, ?)
                ", [
                    $item['harga_satuan'],
                    $item['jumlah'],
                    $idpenjualan,
                    $item['idbarang'],
                ]);
            }

            DB::commit();

            $this->keranjang = [];
            $this->updateTotals();

            session()->flash('ok', 'Transaksi penjualan berhasil disimpan. ID Penjualan: ' . $idpenjualan);
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('err', 'Gagal menyimpan penjualan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transaction.Form-penjualan', [
            'barangList' => $this->barangList,
            'marginAktif' => $this->marginAktif,
        ]);
    }
}
