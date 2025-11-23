<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">

    {{-- ================= HEADER ================= --}}
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl">
        <div class="max-w-6xl mx-auto px-6 py-6 flex justify-between items-center">
            @auth
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">
                        Detail Pengadaan 📋 — {{ auth()->user()->username }}
                    </h1>
                    <p class="text-blue-100 text-sm">Detail informasi pengadaan dan item barang</p>
                    <span class="text-white text-sm font-semibold">{{ auth()->user()->role->nama_role ?? 'User' }}</span>
                </div>
                <div class="text-right">
                    <p class="text-blue-200 text-sm">{{ now()->format('d M Y') }}</p>
                </div>
            @endauth
        </div>
    </header>

    {{-- ================= MAIN ================= --}}
    <main class="flex-1 w-full">
        <div class="max-w-7xl mx-auto px-6 py-8 space-y-8">

            {{-- ========== FLASH MESSAGE ========== --}}
            @if (session()->has('ok'))
                <div
                    class="bg-emerald-50 border-l-4 border-emerald-500 rounded-xl p-4 shadow-sm flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-emerald-700">Berhasil!</p>
                        <p class="text-sm text-emerald-600">{{ session('ok') }}</p>
                    </div>
                </div>
            @endif

            @if (session()->has('err'))
                <div class="bg-rose-50 border-l-4 border-rose-500 rounded-xl p-4 shadow-sm flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-rose-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-rose-700">Terjadi Kesalahan!</p>
                        <p class="text-sm text-rose-600">{{ session('err') }}</p>
                    </div>
                </div>
            @endif

            {{-- ========== INFO PENGADAAN ========== --}}
            <section class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600">
                <div
                    class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Informasi Pengadaan</h2>
                            <p class="text-xs text-gray-600">ID Pengadaan: <span
                                    class="font-semibold">#{{ $pengadaan->idpengadaan ?? '-' }}</span></p>
                        </div>
                    </div>
                    @php
                        $statusConfig = [
                            'P' => ['label' => 'Process', 'class' => 'bg-amber-100 text-amber-700'],
                            'S' => ['label' => 'Selesai', 'class' => 'bg-emerald-100 text-emerald-700'],
                            'C' => ['label' => 'Canceled', 'class' => 'bg-rose-100 text-rose-700'],
                        ];
                        $status = $statusConfig[$pengadaan->status ?? 'P'] ?? [
                            'label' => 'Unknown',
                            'class' => 'bg-gray-100 text-gray-700',
                        ];
                    @endphp
                    <span class="px-4 py-2 rounded-full text-sm font-bold {{ $status['class'] }}">
                        {{ $status['label'] }}
                    </span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                            <p class="text-xs font-semibold text-gray-600 mb-1">Vendor</p>
                            <p class="text-lg font-bold text-gray-900">{{ $pengadaan->nama_vendor ?? '-' }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $pengadaan->badan_hukum ?? '-' }}</p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                            <p class="text-xs font-semibold text-gray-600 mb-1">Tanggal Pengadaan</p>
                            <p class="text-lg font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($pengadaan->timestamp ?? now())->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-600 mt-1">
                                {{ \Carbon\Carbon::parse($pengadaan->timestamp ?? now())->format('H:i') }} WIB</p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                            <p class="text-xs font-semibold text-gray-600 mb-1">Dibuat Oleh</p>
                            <p class="text-lg font-bold text-gray-900">{{ $pengadaan->username ?? '-' }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $pengadaan->nama_role ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ========== Tombol Tambah Item ========== --}}

            @if ($pengadaan->status !== 'S')
            <div class="flex justify-end">
                <button wire:click="resetForm" @click="$wire.resetForm().then(() => openModal())"
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Item Barang</span>
                </button>
            </div>

            @endif
            
            {{-- ========== Tabel Detail Pengadaan ========== --}}
            <section class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600">
                <div
                    class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Item Barang</h2>
                            <p class="text-xs text-gray-600">Total: <span
                                    class="font-semibold">{{ count($detailPengadaan ?? []) }}</span> item</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th
                                    class="px-4 py-3 border-b-2 border-gray-200 text-left font-bold text-xs text-gray-700 uppercase">
                                    No</th>
                                <th
                                    class="px-4 py-3 border-b-2 border-gray-200 text-left font-bold text-xs text-gray-700 uppercase">
                                    Nama Barang</th>
                                <th
                                    class="px-4 py-3 border-b-2 border-gray-200 text-left font-bold text-xs text-gray-700 uppercase">
                                    Satuan</th>
                                <th
                                    class="px-4 py-3 border-b-2 border-gray-200 text-center font-bold text-xs text-gray-700 uppercase">
                                    Jumlah</th>
                                <th
                                    class="px-4 py-3 border-b-2 border-gray-200 text-right font-bold text-xs text-gray-700 uppercase">
                                    Harga Satuan</th>
                                <th
                                    class="px-4 py-3 border-b-2 border-gray-200 text-right font-bold text-xs text-gray-700 uppercase">
                                    Sub Total</th>
                                <th
                                    class="px-4 py-3 border-b-2 border-gray-200 text-center font-bold text-xs text-gray-700 uppercase">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($detailPengadaan ?? [] as $index => $d)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $d->nama_barang ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $d->nama_satuan ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center font-semibold text-gray-700">
                                        {{ number_format($d->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-gray-700">Rp
                                        {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-900">Rp
                                        {{ number_format($d->sub_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            @if (($pengadaan->status ?? 'P') !== 'S')
                                                <button wire:click="edit({{ $d->iddetail_pengadaan }})"
                                                    @click="$wire.edit({{ $d->iddetail_pengadaan }}).then(() => openModal())"
                                                    class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg shadow transition">
                                                    ✏️ Edit
                                                </button>

                                                <button wire:click="delete({{ $d->iddetail_pengadaan }})"
                                                    class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg shadow transition">
                                                    🗑️ Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center text-gray-500">Belum ada item
                                        barang</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- ========== TOTAL SECTION ========== --}}
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t-2 border-gray-200">
                    <div class="max-w-md ml-auto space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-gray-700">Subtotal:</span>
                            <span class="text-sm font-bold text-gray-900">Rp
                                {{ number_format($pengadaan->subtotal_nilai ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-gray-700">PPN
                                ({{ $pengadaan->ppn ?? 10 }}%):</span>
                            <span class="text-sm font-bold text-gray-900">Rp
                                {{ number_format((($pengadaan->subtotal_nilai ?? 0) * ($pengadaan->ppn ?? 10)) / 100, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t-2 border-gray-300">
                            <span class="text-base font-bold text-gray-800">TOTAL:</span>
                            <span class="text-xl font-bold text-indigo-700">Rp
                                {{ number_format($pengadaan->total_nilai ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ========== BACK BUTTON ========== --}}
            <div class="text-center">
                <a href="{{ route('transaction.pengadaan') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-sm rounded-xl border-2 border-gray-300 shadow-sm hover:shadow transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Daftar Pengadaan</span>
                </a>
            </div>

        </div>
    </main>

    <!-- ================= BACKDROP ================= -->
    <div id="modalBackdrop" wire:ignore class="fixed inset-0 hidden z-40 transition-opacity duration-300 opacity-0"
        style="background-color: rgba(0, 0, 0, 0.3); backdrop-filter: blur(6px);">
    </div>

    <!-- ================= MODAL FORM ================= -->
    <div id="modalContainer" wire:ignore.self class="fixed inset-0 flex justify-center items-center hidden z-50 p-4">

        <div id="modalContent" wire:ignore.self
            class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all duration-300 
                scale-95 opacity-0 border-t-4 border-blue-600"
            onclick="event.stopPropagation()">

            <div
                class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5 border-b border-gray-200 rounded-t-2xl flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $isEdit ? 'Edit Item Pengadaan' : 'Tambah Item Pengadaan' }}
                    </h3>
                    <p class="text-xs text-gray-500">
                        {{ $isEdit ? 'Perbarui data item pengadaan' : 'Tambah item baru' }}
                    </p>
                </div>
                <button type="button" onclick="closeModal()"
                    class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-all">
                    ❌
                </button>
            </div>

            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="p-6 space-y-4">

                <!-- Dropdown Barang -->
                <select wire:model.live="idbarang"
                    class="w-full px-3 py-2 bg-gray-50 border-2 border-gray-200 rounded-xl 
                        focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangList as $b)
                        <option value="{{ $b->idbarang }}">{{ $b->nama }}</option>
                    @endforeach
                </select>

                <!-- Nama Satuan -->
                <div wire:poll 1ms>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Satuan</label>
                    <input type="text" wire:model="nama_satuan"
                        class="w-full px-3 py-2 bg-gray-100 border-2 border-gray-200 rounded-xl"
                        value="{{ $nama_satuan }}" readonly>
                </div>

                <!-- Harga Satuan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Satuan</label>
                    <input type="text" wire:model="harga_satuan"
                        class="w-full px-3 py-2 bg-gray-100 border-2 border-gray-200 rounded-xl"
                        value="Rp {{ number_format($harga_satuan, 0, ',', '.') }}" readonly>
                </div>

                <!-- Jumlah -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah</label>
                    <input type="number" wire:model.live="jumlah" min="0"
                        class="w-full px-3 py-2 bg-gray-50 border-2 border-gray-200 rounded-xl
                            focus:border-blue-500 focus:ring-blue-100">
                </div>

                <!-- Total -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Total</label>
                    <input type="text" wire:model="total_harga" readonly
                        class="w-full px-3 py-2 bg-indigo-50 border-2 border-indigo-200 
                            rounded-xl font-bold text-indigo-700"
                        value="Rp {{ number_format($total_harga, 0, ',', '.') }}">
                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold 
                            rounded-xl hover:bg-gray-50">
                        Batal
                    </button>

                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white 
                            px-5 py-2.5 rounded-xl shadow hover:shadow-xl">
                        {{ $isEdit ? 'Update Item' : 'Simpan Item' }}
                    </button>
                </div>

            </form>

        </div>
    </div>



    {{-- ================= MODAL KONFIRMASI HAPUS ================= --}}
    <div id="deleteModalBackdrop" wire:ignore
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 transition-opacity duration-300 opacity-0"
        style="background-color: rgba(0, 0, 0, 0.3); backdrop-filter: blur(6px);">
    </div>

    <div id="deleteModalContainer" wire:ignore.self
        class="fixed inset-0 flex justify-center items-center hidden z-50 p-4">
        <div id="deleteModalContent"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 border-t-4 border-rose-600"
            onclick="event.stopPropagation()">

            <div class="p-6">
                {{-- Icon Warning --}}
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                {{-- Content --}}
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 text-center mb-2">
                    Apakah Anda yakin ingin menghapus item <br>
                    <span id="deleteItemName" class="font-bold text-gray-900"></span>?
                </p>
                <div class="bg-rose-50 border-l-4 border-rose-500 rounded-lg p-3 mb-6">
                    <p class="text-sm text-rose-700 text-center">
                        ⚠️ Data yang sudah dihapus tidak dapat dikembalikan!
                    </p>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="button" id="confirmDeleteBtn"
                        class="flex-1 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <span class="inline-flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Ya, Hapus
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Modal Form Functions
    function openModal() {
        const backdrop = document.getElementById('modalBackdrop');
        const container = document.getElementById('modalContainer');
        const content = document.getElementById('modalContent');

        if (!backdrop || !container || !content) return;

        backdrop.classList.remove('hidden');
        container.classList.remove('hidden');
        void backdrop.offsetWidth;

        requestAnimationFrame(() => {
            backdrop.classList.add('opacity-100');
            backdrop.classList.remove('opacity-0');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');

            setTimeout(() => {
                const firstInput = document.getElementById('focusBarang');
                if (firstInput) firstInput.focus();
            }, 100);
        });
    }

    function closeModal() {
        const backdrop = document.getElementById('modalBackdrop');
        const container = document.getElementById('modalContainer');
        const content = document.getElementById('modalContent');

        if (!backdrop || !container || !content) return;
        if (container.classList.contains('hidden')) return;

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');

        setTimeout(() => {
            backdrop.classList.add('hidden');
            container.classList.add('hidden');
        }, 300);
    }

    // Modal Delete Functions
    let deleteItemId = null;

    function confirmDelete(id, name) {
        deleteItemId = id;
        const deleteNameEl = document.getElementById('deleteItemName');
        if (deleteNameEl) deleteNameEl.textContent = name;

        const backdrop = document.getElementById('deleteModalBackdrop');
        const container = document.getElementById('deleteModalContainer');
        const content = document.getElementById('deleteModalContent');

        if (!backdrop || !container || !content) return;

        backdrop.classList.remove('hidden');
        container.classList.remove('hidden');
        void backdrop.offsetWidth;

        requestAnimationFrame(() => {
            backdrop.classList.add('opacity-100');
            backdrop.classList.remove('opacity-0');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        });
    }

    function closeDeleteModal() {
        const backdrop = document.getElementById('deleteModalBackdrop');
        const container = document.getElementById('deleteModalContainer');
        const content = document.getElementById('deleteModalContent');

        if (!backdrop || !container || !content) return;
        if (container.classList.contains('hidden')) return;

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');

        setTimeout(() => {
            backdrop.classList.add('hidden');
            container.classList.add('hidden');
            deleteItemId = null;
        }, 300);
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                if (deleteItemId) {
                    const component = window.Livewire?.find(document.querySelector('[wire\\:id]')
                        ?.getAttribute('wire:id'));
                    if (component) {
                        component.call('delete', deleteItemId);
                    }
                    closeDeleteModal();
                }
            });
        }

        const modalBackdrop = document.getElementById('modalBackdrop');
        const deleteBackdrop = document.getElementById('deleteModalBackdrop');

        if (modalBackdrop) {
            modalBackdrop.addEventListener('click', function(e) {
                if (e.target === modalBackdrop) closeModal();
            });
        }

        if (deleteBackdrop) {
            deleteBackdrop.addEventListener('click', function(e) {
                if (e.target === deleteBackdrop) closeDeleteModal();
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modalContainer = document.getElementById('modalContainer');
                const deleteModalContainer = document.getElementById('deleteModalContainer');

                const modalShown = modalContainer && !modalContainer.classList.contains('hidden');
                const deleteModalShown = deleteModalContainer && !deleteModalContainer.classList
                    .contains('hidden');

                if (modalShown) closeModal();
                if (deleteModalShown) closeDeleteModal();
            }
        });
    });

    // Listen for Livewire events - Compatible with Livewire 2 & 3
    if (window.Livewire) {
        // Livewire 3
        if (typeof Livewire.on === 'function') {
            Livewire.on('close-modal', () => {
                closeModal();
            });

            Livewire.on('open-modal', () => {
                openModal();
            });
        }

        // Livewire 2
        document.addEventListener('livewire:load', function() {
            window.livewire.on('close-modal', () => {
                closeModal();
            });

            window.livewire.on('open-modal', () => {
                openModal();
            });
        });
    }

    // Also listen via window events
    window.addEventListener('close-modal', () => {
        closeModal();
    });

    window.addEventListener('open-modal', () => {
        openModal();
    });
</script>
