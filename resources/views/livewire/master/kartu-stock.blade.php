<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">

    {{-- ================= HEADER ================= --}}
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl">
        <div class="max-w-6xl mx-auto px-6 py-6">
            <h1 class="text-3xl font-bold text-white">Kartu Stok 📦</h1>
            <p class="text-blue-100 mt-1 text-sm">Monitoring stok barang secara lengkap dan terstruktur</p>
        </div>
    </header>

    {{-- ================= MAIN ================= --}}
    <main class="flex-1">
        <div class="max-w-6xl mx-auto px-4 py-8 space-y-6">
            {{-- ========== FILTER ========== --}}
            <div class="bg-white/80 backdrop-blur-md shadow-md rounded-xl border border-gray-100 p-5 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Cari Nama --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nama Barang</label>
                        <input wire:model.live="searchNama" type="text"
                            class="mt-1 w-full px-3 py-2 border rounded-lg bg-gray-50 focus:ring focus:ring-indigo-300 focus:outline-none">
                    </div>
                </div>
            </div>

            {{-- ========== TABEL REKAP PER BARANG ========== --}}
            <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-indigo-50 text-indigo-900 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 text-left">Barang</th>
                            <th class="px-4 py-3 text-center">Masuk</th>
                            <th class="px-4 py-3 text-center">Keluar</th>
                            <th class="px-4 py-3 text-center">Stok Akhir</th>
                            <th class="px-4 py-3 text-left">Tanggal Terakhir</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($rekap as $r)
                            <tr class="hover:bg-indigo-50/40 transition">
                                {{-- Nama barang --}}
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900">{{ $r->nama_barang }}</p>
                                    <p class="text-[12px] text-gray-500">
                                        ID: {{ $r->idbarang }} — {{ $r->nama_satuan }}
                                    </p>
                                </td>

                                {{-- Masuk --}}
                                <td class="px-4 py-3 text-center text-green-600 font-semibold">
                                    {{ number_format($r->total_masuk, 0, ',', '.') }}
                                </td>

                                {{-- Keluar --}}
                                <td class="px-4 py-3 text-center text-red-600 font-semibold">
                                    {{ number_format($r->total_keluar, 0, ',', '.') }}
                                </td>

                                {{-- Stok akhir --}}
                                <td class="px-4 py-3 text-center font-bold text-gray-900">
                                    {{ number_format($r->stok_akhir, 0, ',', '.') }}
                                </td>

                                {{-- Tanggal terakhir --}}
                                <td class="px-4 py-3 text-gray-700">
                                    @if ($r->tanggal)
                                        {{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y H:i') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                {{-- Tombol detail --}}
                                <td class="px-4 py-3 text-center">
                                    <button wire:click="lihatDetail({{ $r->idbarang }})"
                                        class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition">
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    Tidak ada data barang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- ========== DETAIL LOG ========== --}}
            @if ($detailBarangId)
                <div class="bg-white shadow-xl rounded-2xl border border-gray-200 p-6 mt-6">

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900">
                            Detail Riwayat — ID Barang {{ $detailBarangId }}
                        </h2>

                        <button wire:click="tutupDetail"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-xl text-sm font-semibold shadow">
                            Tutup
                        </button>
                    </div>

                    {{-- TABEL --}}
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Keterangan</th>
                                <th class="px-4 py-3 text-center">Masuk</th>
                                <th class="px-4 py-3 text-center">Keluar</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($detailLog as $d)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">
                                        {{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y H:i') }}
                                    </td>

                                    <td class="px-4 py-2 font-medium text-gray-800">
                                        {{ $d->keterangan }}
                                    </td>

                                    <td class="px-4 py-2 text-center text-green-600 font-bold">
                                        {{ $d->masuk > 0 ? $d->masuk : '-' }}
                                    </td>

                                    <td class="px-4 py-2 text-center text-red-600 font-bold">
                                        {{ $d->keluar > 0 ? $d->keluar : '-' }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    {{-- FOOTER STOK AKHIR --}}
                    <div class="mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-xl text-center">
                        <span class="text-gray-700 font-semibold">Stok Akhir:</span>
                        <span class="text-indigo-700 font-bold text-lg">
                            {{ number_format($stokAkhir, 0, ',', '.') }}
                        </span>
                    </div>

                </div>
            @endif
        </div>
        {{-- ================= BACK BUTTON ================= --}}
            <div class="text-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
    </main>

</div>
