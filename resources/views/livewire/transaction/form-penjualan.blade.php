<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col py-8">

    {{-- ================= HEADER ================= --}}
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl mb-8">
        <div class="max-w-6xl mx-auto px-6 py-6 flex justify-between items-center">
            @auth
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">
                        Transaksi Penjualan 🧾 — {{ auth()->user()->username }}
                    </h1>
                    <p class="text-blue-100 text-sm">
                        Input penjualan, margin & stok otomatis tercatat.
                    </p>
                    <span class="text-white text-sm font-semibold">
                        {{ auth()->user()->role->nama_role ?? 'User' }}
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-blue-200 text-sm">{{ now()->format('d M Y') }}</p>
                </div>
            @endauth
        </div>
    </header>

    {{-- ================= ALERT ================= --}}
    <div class="max-w-6xl mx-auto px-6 mb-4">
        @if (session()->has('ok'))
            <div class="mb-3 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                {{ session('ok') }}
            </div>
        @endif

        @if (session()->has('err'))
            <div class="mb-3 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                {{ session('err') }}
            </div>
        @endif
    </div>

    {{-- ================= MAIN ================= --}}
    <main class="flex-1 max-w-6xl mx-auto w-full px-6 space-y-6">

        {{-- Info margin & PPn --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Margin Penjualan Aktif</h2>
                @if ($marginAktif)
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $marginAktif->persen }}%
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Dibuat oleh: <span class="font-semibold">{{ $marginAktif->username }}</span><br>
                        Sejak: {{ \Carbon\Carbon::parse($marginAktif->created_at)->format('d M Y H:i') }}
                    </p>
                @else
                    <p class="text-sm text-red-500">
                        Tidak ada margin aktif. Set dulu di menu Margin Penjualan.
                    </p>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">PPN Penjualan</h2>
                <div class="flex items-center gap-2">
                    <input type="number" readonly wire:model="ppn"
                        class="w-20 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        min="0">
                    <span class="text-sm text-gray-700">%</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    Berlaku untuk total transaksi ini.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Ringkasan</h2>
                <p class="text-xs text-gray-500">Subtotal</p>
                <p class="text-lg font-semibold text-gray-800">
                    Rp {{ number_format($subtotal_penjualan, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-2">Total + PPN</p>
                <p class="text-xl font-bold text-blue-600">
                    Rp {{ number_format($total_penjualan, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- ================= FORM ITEM + KERANJANG ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- FORM ITEM --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 space-y-4">
                    <h2 class="text-lg font-bold text-gray-800 mb-2">
                        Tambah Item Penjualan
                    </h2>

                    {{-- Barang --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Barang
                        </label>
                        <select wire:model="idbarang"
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barangList as $b)
                                <option value="{{ $b->idbarang }}">
                                    [{{ $b->idbarang }}] {{ $b->nama }} — {{ $b->nama_satuan }}
                                    (Rp {{ number_format($b->harga, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('idbarang')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga Modal & Harga Jual --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div wire:poll.keep-alive.1ms>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Harga Modal
                            </label>
                            <input type="text" readonly
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-700"
                                value="{{ $harga_modal ? 'Rp ' . number_format($harga_modal, 0, ',', '.') : '-' }}">
                        </div>
                        <div wire:poll.keep-alive.1ms>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Harga Jual (setelah margin)
                            </label>
                            <input type="number" wire:model="harga_satuan"
                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('harga_satuan')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Jumlah --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah
                        </label>
                        <input type="number" wire:model="jumlah" min="1"
                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('jumlah')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="button" wire:click="addItem"
                            class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-blue-600 text-white text-sm font-semibold px-4 py-2.5 shadow hover:bg-blue-700 transition">
                            + Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>

            {{-- KERANJANG --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-800">
                            Keranjang Penjualan
                        </h2>
                        <span class="text-xs text-gray-500">
                            {{ count($keranjang) }} item
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600">
                                    <th class="px-3 py-2 text-left">Barang</th>
                                    <th class="px-3 py-2 text-right">Harga Jual</th>
                                    <th class="px-3 py-2 text-center">Qty</th>
                                    <th class="px-3 py-2 text-right">Subtotal</th>
                                    <th class="px-3 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($keranjang as $index => $item)
                                    <tr class="border-b last:border-0">
                                        <td class="px-3 py-2">
                                            <div class="font-semibold text-gray-800">
                                                {{ $item['nama_barang'] }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                ID: {{ $item['idbarang'] }} • {{ $item['nama_satuan'] }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 text-right">
                                            Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            {{ $item['jumlah'] }}
                                        </td>
                                        <td class="px-3 py-2 text-right">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <button type="button" wire:click="removeItem({{ $index }})"
                                                class="inline-flex items-center text-xs font-semibold text-red-600 hover:text-red-700">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-4 text-center text-sm text-gray-500">
                                            Keranjang masih kosong. Tambahkan barang di sebelah kiri.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer total + tombol simpan --}}
                    <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <p class="text-xs text-gray-500">
                                Subtotal:
                                <span class="font-semibold text-gray-800">
                                    Rp {{ number_format($subtotal_penjualan, 0, ',', '.') }}
                                </span>
                            </p>
                            <p class="text-xs text-gray-500">
                                Total + PPN ({{ $ppn }}%):
                                <span class="font-semibold text-blue-600">
                                    Rp {{ number_format($total_penjualan, 0, ',', '.') }}
                                </span>
                            </p>
                        </div>

                        <button type="button" wire:click="simpanPenjualan"
                            class="inline-flex justify-center items-center rounded-xl bg-emerald-600 text-white text-sm font-semibold px-5 py-2.5 shadow hover:bg-emerald-700 transition">
                            Simpan Transaksi Penjualan
                        </button>
                    </div>
                </div>
            </div>

            {{-- ================= BACK BUTTON ================= --}}
            <div class="text-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    Kembali ke Dashboard
                </a>
            </div>


        </div>

    </main>
</div>
