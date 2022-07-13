<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['mildware' => ['role:admin']], function() {
    Route::resource('/user','userController');
    Route::get('/user/hapus/{id}','userController@destroy');
    Route::get('/user/edit/{id}','UserController@edit');
    Route::post('/user/update','UserController@update')->name('user.update');
    Route::resource('/barang','BarangController')->middleware('role:admin');
    Route::resource('/barang','BarangController');
    Route::get('/barang/hapus/{id}','BarangController@destroy');
    Route::get('/barang/edit/{id}','BarangController@edit');
    Route::resource('/supplier', 'SupplierController');
    Route::get('/supplier/hapus/{id}','SupplierController@destroy');
    Route::get('/barang/edit/{id}','BarangController@edit');
    Route::resource('/akun', 'akunController');
    Route::get('/akun/edit/{id}','AkunController@edit');
    Route::get('/akun/hapus/{id}','akunController@destroy');
    Route::get('/setting','SettingController@index')->name('setting.transaksi')->middleware('role:admin');
    Route::post('/setting/simpan','SettingController@simpan');
});
//Pemesanan
Route::get('/transaksi', 'PemesananController@index')->name('pemesanan.transaksi');
Route::post('/sem/store', 'PemesananController@store');
Route::get('/transaksi/hapus/{kd_brg}','PemesananController@destroy');
//Detail Pesan
Route::post('/detail/store', 'DetailPesanController@store');
Route::post('/detail/simpan', 'DetailPesanController@simpan');
Route::get('/pembelian', 'PembelianController@index')->name('pembelian.transaksi');
Route::get('/pembelian-beli/{id}', 'PembelianController@edit');
Route::post('/pembelian/simpan', 'PembelianController@simpan');
Route::get('/pembelian/{id}', 'PembelianController@pdf')->name('cetak.order_pdf');
Route::post('/deletepembelian', 'PembelianController@delete');
Route::post('/pembelianreportpdf', 'PembelianController@reportPDF')->name('cetak.pembelian_pdf');
Route::get('/pembelianperiode', 'PembelianController@periodeLaporan')->name('pembelian.periode');
//Retur 
Route::get('/retur','ReturController@index')->name('retur.transaksi');
Route::get('/retur-beli/{id}', 'ReturController@edit');
Route::post('/retur/simpan', 'ReturController@simpan');
Route::post('/retur/hapus','ReturController@destroy');
//Laporan
Route::get('/laporan','LaporanController@index')->name('laporan.index');
Route::get('/laporan/detail/{no_jurnal}', 'LaporanController@detail')->name('laporan.detail');
Route::get('/laporan/detail/{jurnal_id}/barang', 'LaporanController@detailBarang')->name('laporan.detail.barang');
// Route::get('/stok','LaporanController@index')->name('stok.index');
Route::resource('/laporan' , 'LaporanController');
Route::resource('/stok' , 'LapStokController');
Route::get('/stokreportpdf', 'LapStokController@printReport')->name('cetak.stok');
Route::get('/laporan/faktur/{invoice}', 'PembelianController@pdf')->name('cetak.order_pdf');
//laporan cetak
Route::get('/laporancetak/cetak_pdf', 'LaporanController@cetak_pdf');