<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">

    {{-- ============== HEADER ============== --}}
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl">
        <div class="max-w-6xl mx-auto px-6 py-6 flex justify-between items-center">
            @auth
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">
                        Penerimaan Barang dari Pengadaan 📥
                    </h1>
                    <p class="text-blue-100 text-sm">
                        Pilih pengadaan lalu proses barang yang diterima
                    </p>
                    <span class="text-white text-sm font-semibold">
                        {{ auth()->user()->username }} — {{ auth()->user()->role->nama_role ?? 'User' }}
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-blue-200 text-sm">{{ now()->format('d M Y') }}</p>
                </div>
            @endauth
        </div>
    </header>

    {{-- ============== MAIN ============== --}}
    <main class="flex-1">
        <div class="max-w-6xl mx-auto px-4 py-6 space-y-4">

            {{-- Alert Success --}}
            @if (session('ok'))
                <div
                    class="px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700 flex items-start space-x-2">
                    <span class="mt-0.5">✅</span>
                    <span>{{ session('ok') }}</span>
                </div>
            @endif

            {{-- Alert Error --}}
            @if (session('err'))
                <div
                    class="px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700 flex items-start space-x-2">
                    <span class="mt-0.5">⚠️</span>
                    <span>{{ session('err') }}</span>
                </div>
            @endif

            {{-- Header Section --}}
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Daftar Pengadaan</h2>
                    <p class="text-xs text-gray-500">Pilih pengadaan untuk memproses penerimaan barang</p>
                </div>
            </div>

            {{-- ================== CARD GRID PENGADAAN ================== --}}
            <div class="grid md:grid-cols-2 gap-4">
                @foreach ($pengadaanList as $pg)
                    <div class="bg-white/80 backdrop-blur-sm border border-indigo-50 shadow-lg rounded-2xl p-5 hover:shadow-xl transition-all">

                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-indigo-700">
                                        Pengadaan #{{ $pg->idpengadaan }}
                                    </h3>
                                </div>
                                
                                <div class="space-y-1.5 ml-10">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-gray-600 text-sm">{{ $pg->nama_vendor }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="font-semibold text-gray-800 text-sm">
                                            Rp {{ number_format($pg->total_nilai, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <span class="px-3 py-1.5 rounded-xl text-xs font-semibold
                                {{ $pg->status == 'S' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $pg->status == 'S' ? '✔ Selesai' : '🔄 Proses' }}
                            </span>
                        </div>

                        <button wire:click="open({{ $pg->idpengadaan }})"
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                            Proses Penerimaan
                        </button>
                    </div>
                @endforeach
            </div>

            {{-- ================== MODAL ================== --}}
            @if ($showModal)
                <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50 p-4">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden border border-indigo-100 flex flex-col">

                        {{-- MODAL HEADER --}}
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-800">
                                            Penerimaan Pengadaan #{{ $idpengadaan }}
                                        </h2>
                                        <p class="text-sm text-gray-600">Vendor: {{ $header->nama_vendor }}</p>
                                    </div>
                                </div>
                                <button wire:click="$set('showModal', false)" 
                                    class="text-gray-400 hover:text-gray-600 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- MODAL BODY (Scrollable) --}}
                        <div class="flex-1 overflow-y-auto p-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="sticky top-0 bg-white">
                                        <tr class="bg-indigo-50 text-indigo-900 text-xs uppercase tracking-wide">
                                            <th class="px-3 py-2 text-left rounded-l-lg">Nama Barang</th>
                                            <th class="px-3 py-2 text-right">Sisa</th>
                                            <th class="px-3 py-2 text-right">Harga DP</th>
                                            <th class="px-3 py-2 text-right">Harga Terima</th>
                                            <th class="px-3 py-2 text-right rounded-r-lg">Jumlah Terima</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($items as $brg)
                                            <tr class="hover:bg-indigo-50/40">
                                                <td class="px-3 py-3">
                                                    <div class="font-semibold text-gray-800">{{ $brg->nama_barang }}</div>
                                                    <div class="text-[11px] text-gray-500 mt-0.5">
                                                        ID Detail: #{{ $brg->iddetail_pengadaan }}
                                                    </div>
                                                </td>

                                                <td class="px-3 py-3 text-right">
                                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                                                        {{ $brg->sisa }}
                                                    </span>
                                                </td>

                                                <td class="px-3 py-3 text-right text-gray-700">
                                                    Rp {{ number_format($brg->harga_satuan, 0, ',', '.') }}
                                                </td>

                                                <td class="px-3 py-3 text-right">
                                                    <input type="number"
                                                        wire:model="input.{{ $brg->iddetail_pengadaan }}.harga"
                                                        class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-right focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                                        placeholder="0">
                                                </td>

                                                <td class="px-3 py-3 text-right">
                                                    <input type="number"
                                                        wire:model="input.{{ $brg->iddetail_pengadaan }}.jumlah"
                                                        max="{{ $brg->sisa }}"
                                                        class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-right focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                                        placeholder="0">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- MODAL FOOTER --}}
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                            <button wire:click="$set('showModal', false)"
                                class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition">
                                Batal
                            </button>

                            <button wire:click="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                Simpan Penerimaan
                            </button>
                        </div>

                    </div>
                </div>
            @endif

        </div>

        {{-- ================= BACK BUTTON ================= --}}
        <div class="text-center mt-6 pb-8">
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