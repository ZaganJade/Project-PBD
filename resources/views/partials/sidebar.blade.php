<!-- Logo Area -->
<div class="h-16 flex items-center justify-center border-b border-slate-800 bg-slate-950">
    <span class="text-xl font-bold text-white tracking-wider">INVENTORY<span class="text-blue-500">APP</span></span>
</div>

<!-- Menu List -->
<nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
    
    <a href="{{ route('dashboard') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
        <!-- Icon Dashboard -->
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        <span class="font-medium">Dashboard</span>
    </a>

    <!-- Label -->
    <div class="pt-4 pb-1 pl-4 text-xs font-bold text-slate-500 uppercase">Master Data</div>

    <!-- Menu Item Biasa (Tanpa Dropdown dulu biar aman) -->
    <a href="{{ route('master.barang') }}" class="flex items-center px-4 py-2.5 text-sm rounded-lg {{ request()->routeIs('master.barang') ? 'bg-slate-800 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="mr-3">📦</span> Barang
    </a>
    <a href="{{ route('master.user') }}" class="flex items-center px-4 py-2.5 text-sm rounded-lg {{ request()->routeIs('master.user') ? 'bg-slate-800 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="mr-3">👤</span> User
    </a>
    <a href="{{ route('master.role') }}" class="flex items-center px-4 py-2.5 text-sm rounded-lg {{ request()->routeIs('master.role') ? 'bg-slate-800 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="mr-3">📌</span> Role
    </a>

    <!-- Label -->
    <div class="pt-4 pb-1 pl-4 text-xs font-bold text-slate-500 uppercase">Transaksi</div>

    <!-- Dropdown Transaksi -->
    <div x-data="{ open: false }">
        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2.5 text-sm text-slate-400 rounded-lg hover:bg-slate-800 hover:text-white">
            <div class="flex items-center"><span class="mr-3">💰</span> Transaksi</div>
            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
        </button>
        <div x-show="open" class="pl-11 mt-1 space-y-1">
            <a href="{{ route('transaction.FormPenjualan') }}" class="block py-2 text-sm text-slate-500 hover:text-white">Penjualan</a>
            <a href="{{ route('transaction.FormPenerimaan') }}" class="block py-2 text-sm text-slate-500 hover:text-white">Penerimaan</a>
        </div>
    </div>
</nav>

<!-- Tombol Logout -->
<div class="p-4 border-t border-slate-800">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-sm text-red-400 bg-slate-800 rounded hover:bg-red-600 hover:text-white transition">
            Logout
        </button>
    </form>
</div>