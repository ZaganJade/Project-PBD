<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Master\RoleCrud;
use App\Livewire\Master\UserCrud;
use App\Livewire\Master\BarangCrud;
use App\Livewire\Master\VendorCrud;
use App\Livewire\Master\SatuanCrud;
use App\Livewire\Master\MarginPenjualan;
use App\Livewire\Master\KartuStock;
use App\Livewire\Transaction\Pengadaan;
use App\Livewire\Transaction\DetailPengadaan;
use App\Livewire\Transaction\Penerimaan;
use App\Livewire\Transaction\DetailPenerimaan;
use App\Livewire\Transaction\FormPenerimaan;
use App\Livewire\Transaction\Penjualan;
use App\Livewire\Transaction\FormPenjualan;
use App\Livewire\Transaction\DetailPenjualan;



Route::get('/', function() {
    return view('welcome');
});

Route::get('/login', LoginForm::class)->name('login')->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');


Route::middleware(['auth', 'preventBackHistory'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // MASTER
    Route::prefix('master')->group(function () {
        Route::get('role',   RoleCrud::class)->name('master.role');
        Route::get('user',   UserCrud::class)->name('master.user');
        Route::get('vendor', VendorCrud::class)->name('master.vendor');
        Route::get('satuan', SatuanCrud::class)->name('master.satuan');
        Route::get('barang', BarangCrud::class)->name('master.barang');
        Route::get('MarginPenjualan', MarginPenjualan::class)->name('master.marginPenjualan');
        Route::get('KartuStock', KartuStock::class)->name('master.kartuStock');
    });

    // TRANSACTION
    Route::prefix('transaction')->group(function () {
        Route::get('pengadaan', Pengadaan::class)->name('transaction.pengadaan');
        Route::get('pengadaan/{idpengadaan}/detail', DetailPengadaan::class)->name('transaction.pengadaan.detail');
        Route::get('Penerimaan', Penerimaan::class)->name('transaction.Penerimaan');
        Route::get('penerimaan/{idpenerimaan}/detail', DetailPenerimaan::class)->name('transaction.penerimaan.detail');
        route::get('FormPenerimaan', FormPenerimaan::class)->name('transaction.FormPenerimaan');
        route::get('FormPenjualan', FormPenjualan::class)->name('transaction.FormPenjualan');
        route::get('Penjualan', Penjualan::class)->name('transaction.Penjualan');
        Route::get('penjualan/{idpenjualan}/detail', DetailPenjualan::class)->name('transaction.penjualan.detail');
    });

});

require __DIR__.'/auth.php';
