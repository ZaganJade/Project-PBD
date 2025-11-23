<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">

    <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-md border border-gray-100">

        <h1 class="text-2xl font-bold mb-4">
            Detail Penjualan #{{ $header->idpenjualan }}
        </h1>

        <p class="text-sm text-gray-600 mb-6">
            Tanggal: {{ \Carbon\Carbon::parse($header->created_at)->format('d M Y H:i') }} <br>
            User: <span class="font-semibold">{{ $header->username }}</span> <br>
            Margin: {{ $header->margin }}%
        </p>

        <table class="min-w-full text-sm mb-4">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="px-3 py-2">Barang</th>
                    <th class="px-3 py-2">Satuan</th>
                    <th class="px-3 py-2 text-right">Harga</th>
                    <th class="px-3 py-2 text-center">Jumlah</th>
                    <th class="px-3 py-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $d)
                    <tr class="border-b">
                        <td class="px-3 py-2">{{ $d->nama }}</td>
                        <td class="px-3 py-2">{{ $d->nama_satuan }}</td>
                        <td class="px-3 py-2 text-right">Rp {{ number_format($d->harga_satuan) }}</td>
                        <td class="px-3 py-2 text-center">{{ $d->jumlah }}</td>
                        <td class="px-3 py-2 text-right">
                            Rp {{ number_format($d->subtotal) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right text-sm">
            <p>Subtotal: <b>Rp {{ number_format($header->subtotal_nilai) }}</b></p>
            <p>PPN ({{ $header->ppn }}%): </p>
            <p class="text-lg font-bold">
                Total: Rp {{ number_format($header->total_nilai) }}
            </p>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('transaction.Penjualan') }}"
                class="px-5 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold">
                Kembali
            </a>
        </div>

    </div>
</div>
