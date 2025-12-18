<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">

        {{-- ================= HEADER ================= --}}
        <header class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg rounded-b-2xl">
            <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
                @auth
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">
                            Selamat Datang, {{ auth()->user()->username }} 👋
                        </h1>
                        <p class="text-blue-100 text-sm">
                            Dashboard {{ auth()->user()->role->nama_role ?? 'User' }}
                        </p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden md:block">
                            <p class="text-white font-semibold text-sm">
                                {{ auth()->user()->role->nama_role ?? 'User' }}
                            </p>
                            <p class="text-blue-200 text-xs">{{ now()->format('d M Y') }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold rounded-xl border border-white/30 shadow-sm transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        {{-- ================= MAIN CONTENT ================= --}}
        <main class="flex-1 w-full">
            <div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

                {{-- Welcome Card --}}
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-indigo-50 p-8">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-1">Management Dashboard</h2>
                            <p class="text-gray-600">Kelola seluruh data master dan transaksi sistem dengan mudah</p>
                        </div>
                    </div>
                </div>

                {{-- ================= MASTER DATA SECTION ================= --}}
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Master Data</h2>
                            <p class="text-xs text-gray-500">Kelola data referensi sistem</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                        {{-- Card: Role --}}
                        <a href="{{ route('master.role') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-blue-500 hover:border-blue-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition">
                                    <span class="text-2xl">📌</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-blue-700">Role</h3>
                                    <p class="text-xs text-gray-500">Data role user</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: User --}}
                        <a href="{{ route('master.user') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-indigo-500 hover:border-indigo-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition">
                                    <span class="text-2xl">👤</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-indigo-700">User</h3>
                                    <p class="text-xs text-gray-500">Data pengguna</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Barang --}}
                        <a href="{{ route('master.barang') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-emerald-500 hover:border-emerald-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center group-hover:bg-emerald-200 transition">
                                    <span class="text-2xl">📦</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-emerald-700">Barang
                                    </h3>
                                    <p class="text-xs text-gray-500">Data barang</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Satuan --}}
                        <a href="{{ route('master.satuan') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-amber-500 hover:border-amber-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center group-hover:bg-amber-200 transition">
                                    <span class="text-2xl">⚖️</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-amber-700">Satuan
                                    </h3>
                                    <p class="text-xs text-gray-500">Data satuan</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Kartu Stok --}}
                        <a href="{{ route('master.kartuStock') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-teal-500 hover:border-teal-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center group-hover:bg-teal-200 transition">
                                    <span class="text-2xl">📊</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-teal-700">Kartu Stok
                                    </h3>
                                    <p class="text-xs text-gray-500">Kelola stok</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Vendor --}}
                        <a href="{{ route('master.vendor') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-purple-500 hover:border-purple-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition">
                                    <span class="text-2xl">🏢</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-purple-700">Vendor
                                    </h3>
                                    <p class="text-xs text-gray-500">Data vendor</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Margin Penjualan --}}
                        <a href="{{ route('master.marginPenjualan') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-pink-500 hover:border-pink-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center group-hover:bg-pink-200 transition">
                                    <span class="text-2xl">💹</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-pink-700">Margin
                                        Penjualan</h3>
                                    <p class="text-xs text-gray-500">Kelola margin</p>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>

                {{-- ================= TRANSACTION SECTION ================= --}}
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Transaction</h2>
                            <p class="text-xs text-gray-500">Kelola transaksi operasional</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        {{-- Card: Pengadaan Barang --}}
                        <a href="{{ route('transaction.pengadaan') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-blue-500 hover:border-blue-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition">
                                    <span class="text-2xl">📋</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-blue-700">Pengadaan
                                        Barang</h3>
                                    <p class="text-xs text-gray-500">Kelola pengadaan</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Terima Barang --}}
                        <a href="{{ route('transaction.FormPenerimaan') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-indigo-500 hover:border-indigo-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition">
                                    <span class="text-2xl">📥</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-indigo-700">Terima
                                        Barang</h3>
                                    <p class="text-xs text-gray-500">Form penerimaan</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Data Penerimaan --}}
                        <a href="{{ route('transaction.Penerimaan') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-emerald-500 hover:border-emerald-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center group-hover:bg-emerald-200 transition">
                                    <span class="text-2xl">📦</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-emerald-700">Data
                                        Penerimaan</h3>
                                    <p class="text-xs text-gray-500">List penerimaan</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Form Penjualan --}}
                        <a href="{{ route('transaction.FormPenjualan') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-amber-500 hover:border-amber-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center group-hover:bg-amber-200 transition">
                                    <span class="text-2xl">🧾</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-amber-700">Form
                                        Penjualan</h3>
                                    <p class="text-xs text-gray-500">Transaksi penjualan</p>
                                </div>
                            </div>
                        </a>

                        {{-- Card: Data Penjualan --}}
                        <a href="{{ route('transaction.Penjualan') }}"
                            class="group p-5 rounded-2xl bg-white/80 backdrop-blur-sm shadow-md hover:shadow-xl border-l-4 border-purple-500 hover:border-purple-600 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition">
                                    <span class="text-2xl">💰</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-purple-700">Data
                                        Penjualan</h3>
                                    <p class="text-xs text-gray-500">List penjualan</p>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>

            </div>
        </main>
    </div>

</x-layouts.app>
