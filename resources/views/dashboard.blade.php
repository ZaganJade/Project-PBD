<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">

        {{-- ================= HEADER ================= --}}
        <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl">
            <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
                @auth
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-xl md:text-2xl font-bold text-white mb-1">
                            Selamat Datang di Menu Dashboard {{ auth()->user()->role->nama_role ?? 'User' }} 👋,
                            {{ auth()->user()->username }}
                        </h1>
                        <p class="text-blue-100 text-sm">Kelola user dan akses sistem</p>
                    </div>

                    <div class="flex items-start md:items-end space-x-4">
                        <div class="text-right">
                            <p class="text-white font-semibold text-sm leading-tight">
                                Role: {{ auth()->user()->role->nama_role ?? 'User' }}
                            </p>
                            <p class="text-blue-200 text-[11px] leading-tight">{{ now()->format('d M Y') }}</p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="border border-blue-500 text-white hover:bg-blue-100 hover:border-blue-400 hover:text-blue-600 text-sm px-4 py-2 rounded-lg shadow-sm transition duration-200">
                                    Logout
                                </button>
                        </div>
                    </div>
                @endauth
            </div>
        </header>

        {{-- ================= MAIN CONTENT ================= --}}
        <main class="flex-1 w-full">
            <div class="max-w-7xl mx-auto px-6 py-10">
                <h2 class="text-lg font-semibold text-gray-700 mb-6">📂 Navigasi Menu</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- === CARD: ROLE === --}}
                    <a href="{{ route('master.role') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-blue-500
                                hover:border-blue-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">📌</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-700">Role</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola data role pengguna sistem.</p>
                    </a>

                    {{-- === CARD: USER === --}}
                    <a href="{{ route('master.user') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-indigo-500
                               hover:border-indigo-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">👤</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-700">User</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola data user sistem.</p>
                    </a>

                    {{-- === CARD: BARANG === --}}
                    <a href="{{ route('master.barang') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-emerald-500
                               hover:border-emerald-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">📦</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700">Barang</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola data barang dan stok.</p>
                    </a>

                    {{-- === CARD: SATUAN === --}}
                    <a href="{{ route('master.satuan') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-amber-500
                               hover:border-amber-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">⚖️</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-amber-700">Satuan</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola data satuan barang.</p>
                    </a>

                    {{-- === CARD: Kartu Stok === --}}
                    <a href="{{ route('master.kartuStock') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-amber-500
                               hover:border-amber-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">⚖️</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-amber-700">Kartu Stok</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola data Kartu Stok barangmu.</p>
                    </a>

                    {{-- === CARD: VENDOR === --}}
                    <a href="{{ route('master.vendor') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-purple-500
                               hover:border-purple-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">🏢</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-700">Vendor</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola data vendor / supplier.</p>
                    </a>

                    {{-- === CARD: TRANSACTION === --}}
                    <a href="{{ route('master.marginPenjualan') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-purple-500
                                hover:border-purple-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">🏢</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-700">Margin Penjualan
                            </h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola Margin Penjualan.</p>
                    </a>

                    <a href="{{ route('transaction.pengadaan') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-purple-500
                                hover:border-purple-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">🏢</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-700">Pengadaan Barang
                            </h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola Pengadaan barangmu.</p>
                    </a>

                    <a href="{{ route('transaction.Penerimaan') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-purple-500
                                hover:border-purple-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">🏢</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-700">Penerimaan Barang
                            </h3>
                        </div>
                        <p class="text-sm text-gray-600">Data Penerimaan.</p>
                    </a>

                    <a href="{{ route('transaction.FormPenerimaan') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-purple-500
                                hover:border-purple-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">🏢</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-700">Terima Barangmu</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola Penerimaan barangmu.</p>
                    </a>

                    {{-- === CARD: Penjualan === --}}
                    <a href="{{ route('transaction.FormPenjualan') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-emerald-500
                hover:border-emerald-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">📦</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700">Form Penjualan</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola Penjualan.</p>
                    </a>

                    {{-- === CARD: Penjualan === --}}
                    <a href="{{ route('transaction.Penjualan') }}"
                        class="group p-6 rounded-2xl bg-white shadow-md hover:shadow-xl border-t-4 border-emerald-500
                hover:border-emerald-600 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <span class="text-2xl">📦</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700">Penjualan</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola Penjualan.</p>
                    </a>

                </div>
            </div>
        </main>
    </div>

</x-layouts.app>
