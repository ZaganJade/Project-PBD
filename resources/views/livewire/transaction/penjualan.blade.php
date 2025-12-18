<div wire:poll.1ms class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">

    {{-- ============== HEADER ============== --}}
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl">
        <div class="max-w-6xl mx-auto px-6 py-6 flex justify-between items-center">
            @auth
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">
                        Manajemen Penjualan 🧾
                    </h1>
                    <p class="text-blue-100 text-sm">
                        Daftar transaksi penjualan barang
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

            {{-- Alert --}}
            @if (session('ok'))
                <div
                    class="px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700 flex items-start space-x-2">
                    <span class="mt-0.5">✅</span>
                    <span>{{ session('ok') }}</span>
                </div>
            @endif

            @if (session('err'))
                <div
                    class="px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700 flex items-start space-x-2">
                    <span class="mt-0.5">⚠️</span>
                    <span>{{ session('err') }}</span>
                </div>
            @endif

            {{-- Card utama --}}
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-indigo-50">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Daftar Penjualan</h2>
                            <p class="text-xs text-gray-500">Data transaksi penjualan</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-indigo-50 text-indigo-900 text-xs uppercase tracking-wide">
                                <th class="px-3 py-2 text-left rounded-l-lg">ID Penjualan</th>
                                <th class="px-3 py-2 text-left">Tanggal</th>
                                <th class="px-3 py-2 text-left">User</th>
                                <th class="px-3 py-2 text-right">Subtotal</th>
                                <th class="px-3 py-2 text-center">PPN</th>
                                <th class="px-3 py-2 text-right">Total Nilai</th>
                                <th class="px-3 py-2 text-center rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($listPenjualan as $p)
                                <tr class="hover:bg-indigo-50/40">
                                    <td class="px-3 py-2 font-semibold text-gray-800">
                                        #{{ $p->idpenjualan }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ $p->username }}
                                    </td>
                                    <td class="px-3 py-2 text-right text-gray-700">
                                        Rp {{ number_format($p->subtotal_nilai, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                                            {{ $p->ppn }}%
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-right font-semibold text-gray-800">
                                        Rp {{ number_format($p->total_nilai, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <a href="{{ route('transaction.penjualan.detail', $p->idpenjualan) }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-4 text-center text-gray-500 text-sm">
                                        Belum ada data penjualan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- ================= BACK BUTTON ================= --}}
        <div class="text-center mt-6">
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