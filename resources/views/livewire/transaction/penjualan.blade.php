<div wire.pool 1ms class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">

    <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-md border border-gray-100">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Penjualan 🧾</h1>

        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="px-3 py-2 text-left">ID</th>
                    <th class="px-3 py-2 text-left">Tanggal</th>
                    <th class="px-3 py-2 text-left">User</th>
                    <th class="px-3 py-2 text-right">Subtotal</th>
                    <th class="px-3 py-2 text-right">PPN</th>
                    <th class="px-3 py-2 text-right">Total</th>
                    <th class="px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listPenjualan as $p)
                    <tr class="border-b">
                        <td class="px-3 py-2">#{{ $p->idpenjualan }}</td>
                        <td class="px-3 py-2">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y H:i') }}</td>
                        <td class="px-3 py-2">{{ $p->username }}</td>
                        <td class="px-3 py-2 text-right">Rp {{ number_format($p->subtotal_nilai) }}</td>
                        <td class="px-3 py-2 text-right">{{ $p->ppn }}%</td>
                        <td class="px-3 py-2 text-right font-bold text-blue-600">
                            Rp {{ number_format($p->total_nilai) }}
                        </td>
                        <td class="px-3 py-2 text-center">
                            <a href="{{ route('transaction.penjualan.detail', $p->idpenjualan) }}"
                                class="px-4 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-semibold">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        

    </div>
    {{-- ================= BACK BUTTON ================= --}}
            <div class="text-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    Kembali ke Dashboard
                </a>
            </div>
</div>


