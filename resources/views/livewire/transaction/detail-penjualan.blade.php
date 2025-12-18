<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">

    {{-- ============== HEADER ============== --}}
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl">
        <div class="max-w-5xl mx-auto px-6 py-6 flex justify-between items-center">
            @auth
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">
                        Detail Penjualan #{{ $header->idpenjualan }} 🧾
                    </h1>
                    <p class="text-blue-100 text-sm">
                        Informasi lengkap transaksi penjualan
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-blue-200 text-sm">{{ now()->format('d M Y') }}</p>
                </div>
            @endauth
        </div>
    </header>

    {{-- ============== MAIN ============== --}}
    <main class="flex-1">
        <div class="max-w-5xl mx-auto px-4 py-6 space-y-4">

            {{-- Info Header --}}
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-indigo-50 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Transaksi</p>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($header->created_at)->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Petugas</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $header->username }}</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Margin Keuntungan</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $header->margin }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Detail Barang --}}
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-indigo-50">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center space-x-3">
                    <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Daftar Barang</h2>
                        <p class="text-xs text-gray-500">Item yang terjual dalam transaksi ini</p>
                    </div>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-indigo-50 text-indigo-900 text-xs uppercase tracking-wide">
                                <th class="px-3 py-2 text-left rounded-l-lg">Nama Barang</th>
                                <th class="px-3 py-2 text-left">Satuan</th>
                                <th class="px-3 py-2 text-right">Harga Satuan</th>
                                <th class="px-3 py-2 text-center">Jumlah</th>
                                <th class="px-3 py-2 text-right rounded-r-lg">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($detail as $d)
                                <tr class="hover:bg-indigo-50/40">
                                    <td class="px-3 py-2 font-semibold text-gray-800">{{ $d->nama }}</td>
                                    <td class="px-3 py-2 text-gray-700">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium">
                                            {{ $d->nama_satuan }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-right text-gray-700">
                                        Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                                            {{ $d->jumlah }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-right font-semibold text-gray-800">
                                        Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Summary Total --}}
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-indigo-50 p-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Subtotal Nilai</span>
                        <span class="text-sm font-semibold text-gray-800">
                            Rp {{ number_format($header->subtotal_nilai, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">PPN ({{ $header->ppn }}%)</span>
                        <span class="text-sm font-semibold text-gray-800">
                            Rp {{ number_format($header->total_nilai - $header->subtotal_nilai, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-lg font-bold text-gray-800">Total Nilai</span>
                        <span class="text-2xl font-bold text-indigo-600">
                            Rp {{ number_format($header->total_nilai, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= BACK BUTTON ================= --}}
        <div class="text-center mt-6 pb-8">
            <a href="{{ route('transaction.Penjualan') }}"
                class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Penjualan
            </a>
        </div>
    </main>

</div>