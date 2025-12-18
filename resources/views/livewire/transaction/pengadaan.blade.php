<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">

    {{-- ============== HEADER ============== --}}
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            @auth
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">
                        Manajemen Pengadaan 📋
                    </h1>
                    <p class="text-blue-100 text-sm">
                        Kelola data pengadaan barang dari vendor
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
        <div class="max-w-7xl mx-auto px-4 py-6 space-y-4">

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

            {{-- Tombol Tambah --}}
            <div class="flex justify-end">
                <button onclick="openModal()"
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pengadaan
                </button>
            </div>

            {{-- Card Tabel --}}
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-indigo-50">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Daftar Pengadaan</h2>
                            <p class="text-xs text-gray-500">Data pengadaan dari vendor</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-indigo-50 text-indigo-900 text-xs uppercase tracking-wide">
                                <th class="px-3 py-2 text-left rounded-l-lg">ID</th>
                                <th class="px-3 py-2 text-left">Tanggal</th>
                                <th class="px-3 py-2 text-left">Vendor</th>
                                <th class="px-3 py-2 text-left">User</th>
                                <th class="px-3 py-2 text-right">Subtotal</th>
                                <th class="px-3 py-2 text-center">PPN</th>
                                <th class="px-3 py-2 text-right">Total</th>
                                <th class="px-3 py-2 text-center">Status</th>
                                <th class="px-3 py-2 text-center">Detail</th>
                                <th class="px-3 py-2 text-center rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($data as $p)
                                <tr class="hover:bg-indigo-50/40">
                                    <td class="px-3 py-2 font-semibold text-gray-800">
                                        #{{ $p->idpengadaan }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ \Carbon\Carbon::parse($p->timestamp)->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ $p->nama_vendor }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ $p->username }}
                                    </td>
                                    <td class="px-3 py-2 text-right text-gray-700">
                                        Rp {{ number_format($p->subtotal_nilai ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                                            {{ $p->ppn }}%
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-right font-semibold text-gray-800">
                                        Rp {{ number_format($p->total_nilai ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        @php
                                            $statusConfig = [
                                                'P' => ['text' => '🔄 Process', 'class' => 'bg-yellow-100 text-yellow-700'],
                                                'S' => ['text' => '✔ Selesai', 'class' => 'bg-green-100 text-green-700'],
                                                'C' => ['text' => '✖ Canceled', 'class' => 'bg-red-100 text-red-700'],
                                            ];
                                            $status = $statusConfig[$p->status] ?? ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700'];
                                        @endphp
                                        <span class="px-3 py-1 rounded-xl text-[13px] font-semibold {{ $status['class'] }}">
                                            {{ $status['text'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <a href="{{ route('transaction.pengadaan.detail', $p->idpengadaan) }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                            Detail
                                        </a>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <button onclick="confirmDelete({{ $p->idpengadaan }}, '{{ $p->nama_vendor }}')"
                                            class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-red-600 text-white hover:bg-red-700 transition">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-3 py-4 text-center text-gray-500 text-sm">
                                        Belum ada data pengadaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

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

    {{-- ================= MODAL TAMBAH ================= --}}
    <div id="modalBackdrop" wire:ignore class="fixed inset-0 hidden z-40 transition-opacity duration-300 opacity-0"
        style="background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(8px);">
    </div>
    <div id="modalContainer" class="fixed inset-0 flex hidden justify-center items-center z-50">
        <div id="modalContent"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 transform scale-95 opacity-0 transition border border-indigo-100">
            
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Tambah Pengadaan Baru</h3>
            </div>

            <form wire:submit.prevent="store" class="space-y-4">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Vendor</label>
                    <select wire:model.defer="vendor_idvendor" 
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">-- Pilih Vendor --</option>
                        @foreach ($vendors as $v)
                            <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }} ({{ $v->badan_hukum }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">PPN (%)</label>
                    <input type="number" wire:model.defer="ppn" readonly 
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-gray-50" 
                        min="0" max="100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <input type="text" wire:model.defer="status" readonly 
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-gray-50">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeModal()" 
                        class="flex-1 px-4 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg transition">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ================= MODAL HAPUS ================= --}}
    <div id="deleteModalBackdrop" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden opacity-0 transition z-40"></div>

    <div id="deleteModalContainer" class="fixed inset-0 hidden justify-center items-center z-50">
        <div id="deleteModalContent"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform scale-95 opacity-0 transition border border-red-100">

            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-2">
                    Yakin ingin menghapus pengadaan dari
                </p>
                <p class="font-bold text-gray-800" id="deleteItemName"></p>
            </div>

            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" 
                    class="flex-1 px-4 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button id="confirmDeleteBtn" 
                    class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition">
                    Hapus
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
    // Modal tambah
    const modalBackdrop = document.getElementById('modalBackdrop');
    const modalContainer = document.getElementById('modalContainer');
    const modalContent = document.getElementById('modalContent');

    function openModal() {
        modalBackdrop.classList.remove('hidden');
        modalContainer.classList.remove('hidden');

        requestAnimationFrame(() => {
            modalBackdrop.classList.add('opacity-100');
            modalContent.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
        });
    }

    function closeModal() {
        modalBackdrop.classList.remove('opacity-100');
        modalContent.classList.remove('opacity-100');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modalBackdrop.classList.add('hidden');
            modalContainer.classList.add('hidden');
        }, 200);
    }

    // Modal hapus
    const deleteModalBackdrop = document.getElementById('deleteModalBackdrop');
    const deleteModalContainer = document.getElementById('deleteModalContainer');
    const deleteModalContent = document.getElementById('deleteModalContent');

    let deleteID = null;

    function confirmDelete(id, name) {
        deleteID = id;
        document.getElementById('deleteItemName').textContent = name;

        deleteModalBackdrop.classList.remove('hidden');
        deleteModalContainer.classList.remove('hidden');

        requestAnimationFrame(() => {
            deleteModalBackdrop.classList.add('opacity-100');
            deleteModalContent.classList.add('opacity-100');
            deleteModalContent.classList.remove('scale-95');
        });
    }

    function closeDeleteModal() {
        deleteModalBackdrop.classList.remove('opacity-100');
        deleteModalContent.classList.remove('opacity-100');
        deleteModalContent.classList.add('scale-95');

        setTimeout(() => {
            deleteModalBackdrop.classList.add('hidden');
            deleteModalContainer.classList.add('hidden');
        }, 200);
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteID) {
            @this.call('delete', deleteID);
            closeDeleteModal();
        }
    });
</script>