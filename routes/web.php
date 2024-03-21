<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\MasterRoleController;
use App\Http\Controllers\MasterPartController;
use App\Http\Controllers\MasterPartKelompokController;
use App\Http\Controllers\MasterPartKategoriController;
use App\Http\Controllers\MasterPartProdukController;
use App\Http\Controllers\MasterPartGroupController;
use App\Http\Controllers\MasterSalesController;
use App\Http\Controllers\MasterDiskonPartController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SuratPesananController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\BackOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\IntransitController;
use App\Http\Controllers\ValidasiSOController;
use App\Http\Controllers\StokGudangController;
use App\Http\Controllers\MasterPartHetController;
use App\Http\Controllers\PackingSheetController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\LkhController;
use App\Http\Controllers\PlafondController;
use App\Http\Controllers\AccountReceivableController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\KodeRakLokasiController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MasterTargetController;
use App\Http\Controllers\MasterTargetSpvController;
use App\Http\Controllers\MasterTargetSpvProdukController;
use App\Http\Controllers\MasterTargetSalesProductController;
use App\Http\Controllers\ReportLssController;
use App\Http\Controllers\ModalDbpController;
use App\Http\Controllers\PembayaranPiutangTokoController;
use App\Http\Controllers\ReportKasController;
use App\Http\Controllers\TransferMasukController;
use App\Http\Controllers\TransferKeluarController;
use App\Http\Controllers\BgMasukController;
use App\Http\Controllers\BGKeluarController;
use App\Http\Controllers\ExportPajakController;
use App\Http\Controllers\HistoryPesananController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\MutasiPartController;
use App\Http\Controllers\RincianTagihanController;
use App\Http\Controllers\PembayaranTokoController;
use App\Http\Controllers\MasterProvinsiController;
use App\Http\Controllers\MasterPerkiraanController;
use App\Http\Controllers\MasterAreaOutletController;
use App\Http\Controllers\MasterTokoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //USER
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/reset/{id}', [UserController::class, 'reset'])->name('user.reset');

    //PROFIL
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

    //INVENTARIS
    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
    Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
    Route::get('/inventaris/create', [InventarisController::class, 'create'])->name('inventaris.create');
    Route::get('/inventaris/show/{id}', [InventarisController::class, 'show'])->name('inventaris.show');

    //MASTER PROVINSI
    Route::get('/master-provinsi', [MasterProvinsiController::class, 'index'])->name('master-provinsi.index');
    Route::get('/master-provinsi/create', [MasterProvinsiController::class, 'create'])->name('master-provinsi.create');
    Route::post('/master-provinsi/store', [MasterProvinsiController::class, 'store'])->name('master-provinsi.store');
     Route::get('/master-provinsi/edit/{kode_prp}', [MasterProvinsiController::class, 'edit'])->name('master-provinsi.edit');
    Route::get('/master-provinsi/nonaktif/{kode_prp}', [MasterProvinsiController::class, 'nonaktif'])->name('master-provinsi.nonaktif');
    Route::post('/master-provinsi/store', [MasterProvinsiController::class, 'store'])->name('master-provinsi.store');
    Route::delete('/master-provinsi/delete/{kode_prp}', [MasterProvinsiController::class, 'delete'])->name('master-provinsi.delete');

    //MASTER PERKIRAAN
    Route::get('/master-perkiraan', [MasterPerkiraanController::class, 'index'])->name('master-perkiraan.index');
    Route::get('/master-perkiraan/create', [MasterPerkiraanController::class, 'create'])->name('master-perkiraan.create');
    Route::get('/master-perkiraan/edit/{id}', [MasterPerkiraanController::class, 'edit'])->name('master-perkiraan.edit');
    Route::get('/master-perkiraan/nonaktif/{id}', [MasterPerkiraanController::class, 'nonaktif'])->name('master-perkiraan.nonaktif');
    Route::post('/master-perkiraan/store', [MasterPerkiraanController::class, 'store'])->name('master-perkiraan.store');
    Route::delete('/master-perkiraan/delete/{id}', [MasterPerkiraanController::class, 'delete'])->name('master-perkiraan.delete');

    //MASTER AREA OUTLET
    Route::get('/master-area-outlet', [MasterAreaOutletController::class, 'index'])->name('master-area-outlet.index');
    Route::get('/master-area-outlet/create', [MasterAreaOutletController::class, 'create'])->name('master-area-outlet.create');
    Route::get('/master-area-outlet/edit/{id}', [MasterAreaOutletController::class, 'edit'])->name('master-area-outlet.edit');
    Route::post('/master-area-outlet/store', [MasterAreaOutletController::class, 'store'])->name('master-area-outlet.store');
    Route::put('/master-area-outlet/update', [MasterAreaOutletController::class, 'update'])->name('master-area-outlet.update');
    Route::delete('/master-area-outlet/delete/{id}', [MasterAreaOutletController::class, 'delete'])->name('master-area-outlet.delete');

    //MASTER PART
    Route::get('/master-part', [MasterPartController::class, 'index'])->name('master-part.index');
    Route::get('/master-part/create', [MasterPartController::class, 'create'])->name('master-part.create');
    Route::get('/master-part/edit/{id}', [MasterPartController::class, 'edit'])->name('master-part.edit');
    Route::delete('/master-part/delete/{id}', [MasterPartController::class, 'delete'])->name('master-part.delete');
    Route::get('/master-part/show/{id}', [MasterPartController::class, 'show'])->name('master-part.show');
    Route::post('/master-part/store', [MasterPartController::class, 'store'])->name('master-part.store');
    Route::post('/master-part/update/{id}', [MasterPartController::class, 'update'])->name('master-part.update');

    //MASTER PART DISKON
    Route::get('/master-diskon', [MasterDiskonPartController::class, 'index'])->name('master-diskon.index');
    Route::get('/master-diskon/create', [MasterDiskonPartController::class, 'create'])->name('master-diskon.create');
    Route::get('/master-diskon/edit/{id}', [MasterDiskonPartController::class, 'edit'])->name('master-diskon.edit');
    Route::delete('/master-diskon/delete/{id}', [MasterDiskonPartController::class, 'delete'])->name('master-diskon.delete');
    Route::get('/master-diskon/show/{id}', [MasterDiskonPartController::class, 'show'])->name('master-diskon.show');
    Route::post('/master-diskon/store', [MasterDiskonPartController::class, 'store'])->name('master-diskon.store');
    Route::post('/master-diskon/update/{id}', [MasterDiskonPartController::class, 'update'])->name('master-diskon.update');

    //MASTER ROLE
    Route::get('/master-role', [MasterRoleController::class, 'index'])->name('master-role.index');
    Route::get('/master-role/create', [MasterRoleController::class, 'create'])->name('master-role.create');
    Route::get('/master-role/update/{id}', [MasterRoleController::class, 'edit'])->name('master-role.edit');
    Route::get('/master-role/delete/{id}', [MasterRoleController::class, 'delete'])->name('master-role.delete');
    Route::get('/master-role/show/{id}', [MasterRoleController::class, 'show'])->name('master-role.show');
    Route::post('/master-role/store', [MasterRoleController::class, 'store'])->name('master-role.store');
    Route::post('/master-role/update', [MasterRoleController::class, 'update'])->name('master-role.update');

    //MASTER PLAFOND
    Route::get('/master-plafond', [PlafondController::class, 'index'])->name('master-plafond.index');
    Route::get('/master-plafond/details', [PlafondController::class, 'detail'])->name('master-plafond.detail');
    Route::get('/master-plafond/tambah/{id}', [PlafondController::class, 'tambah'])->name('master-plafond.tambah');
    Route::get('/master-plafond/kurang/{id}', [PlafondController::class, 'kurang'])->name('master-plafond.kurang');
    Route::get('/master-plafond/create', [PlafondController::class, 'create'])->name('master-plafond.create');
    Route::get('/master-plafond/show/{id}', [PlafondController::class, 'show'])->name('master-plafond.show');
    Route::post('/master-plafond/store', [PlafondController::class, 'store'])->name('master-plafond.store');
    Route::post('/master-plafond/store_tambah', [PlafondController::class, 'store_tambah'])->name('master-plafond.store_tambah');
    Route::post('/master-plafond/store_kurang', [PlafondController::class, 'store_kurang'])->name('master-plafond.store_kurang');

    Route::get('/part-kelompok', [MasterPartKelompokController::class, 'index'])->name('part-kelompok.index');
    Route::get('/part-kelompok/create', [MasterPartKelompokController::class, 'create'])->name('part-kelompok.create');
    Route::get('/part-kelompok/show/{id}', [MasterPartKelompokController::class, 'show'])->name('part-kelompok.show');
    Route::post('/part-kelompok/store', [MasterPartKelompokController::class, 'store'])->name('part-kelompok.store');
   
    Route::get('/part-kategori', [MasterPartKategoriController::class, 'index'])->name('part-kategori.index');
    Route::get('/part-kategori/create', [MasterPartKategoriController::class, 'create'])->name('part-kategori.create');
    Route::get('/part-kategori/show/{id}', [MasterPartKategoriController::class, 'show'])->name('part-kategori.show');
    Route::post('/part-kategori/store', [MasterPartKategoriController::class, 'store'])->name('part-kategori.store');
   
    Route::get('/part-produk', [MasterPartProdukController::class, 'index'])->name('part-produk.index');
    Route::get('/part-produk/create', [MasterPartProdukController::class, 'create'])->name('part-produk.create');
    Route::get('/part-produk/show/{id}', [MasterPartProdukController::class, 'show'])->name('part-produk.show');
    Route::post('/part-produk/store', [MasterPartProdukController::class, 'store'])->name('part-produk.store');

    Route::get('/part-group', [MasterPartGroupController::class, 'index'])->name('part-group.index');
    Route::get('/part-group/create', [MasterPartGroupController::class, 'create'])->name('part-group.create');
    Route::get('/part-group/show/{id}', [MasterPartGroupController::class, 'show'])->name('part-group.show');
    Route::post('/part-group/store', [MasterPartGroupController::class, 'store'])->name('part-group.store');

    //INTRANSIT
    Route::get('/intransit', [IntransitController::class, 'index'])->name('intransit.index');
    Route::post('/intransit', [IntransitController::class, 'store'])->name('intransit.store');
    Route::get('/intransit/create', [IntransitController::class, 'create'])->name('intransit.create');
    Route::get('/intransit/details/{id}', [IntransitController::class, 'details'])->name('intransit.details');
    Route::get('/intransit/show/{id}', [IntransitController::class, 'show'])->name('intransit.show');
    Route::post('/intransit/details/{id}', [IntransitController::class, 'store_details'])->name('intransit.store_details');
    Route::get('/intransit/validasi/{id}', [IntransitController::class, 'validasi'])->name('intransit.validasi');
    Route::get('/intransit/validasi-barang/{id}', [IntransitController::class, 'validasi_barang'])->name('intransit.validasi_barang');
    Route::get('/intransit/tambah-gudang/{id}', [IntransitController::class, 'tambah_gudang'])->name('intransit.tambah-gudang');
    Route::get('/intransit/stok-masuk/{id_intransit_header}', [IntransitController::class, 'stok_masuk'])->name('intransit.stok_masuk');
    Route::post('/intransit/store-stok-gudang/{part_no}', [IntransitController::class, 'store_stok_gudang'])->name('intransit.store_stok_gudang');

    //ROUTE PEMBELIAN
    Route::get('/pembelian-non-aop', [PembelianController::class, 'index'])->name('pembelian-non-aop.index');
    Route::get('/pembelian-non-aop/create', [PembelianController::class, 'create'])->name('pembelian-non-aop.create');
    Route::get('/pembelian-non-aop/show/{id}', [PembelianController::class, 'show'])->name('pembelian-non-aop.show');
    Route::post('/pembelian-non-aop/store', [PembelianController::class, 'store'])->name('pembelian-non-aop.store');
    Route::get('/pembelian-non-aop/detail/{id}/invoice/{invoice_non}', [PembelianController::class, 'detail'])->name('pembelian-non-aop.detail');
    Route::post('/pembelian-non-aop/store-details', [PembelianController::class, 'store_details'])->name('pembelian-non-aop.store_details');
    Route::get('/pembelian-non-aop/pembelian-details/{id}', [PembelianController::class, 'detail_pembelian'])->name('pembelian-non-aop.pembelian-details');

    //ROUTE PEMBAYARAN
    Route::get('/pembayaran-non-aop', [PembayaranController::class, 'index'])->name('pembayaran-non-aop.index');
    Route::get('/pembayaran-non-aop/pembayaran/{invoice_aop}', [PembayaranController::class, 'pembayaran'])->name('pembayaran-non-aop.pembayaran');
    Route::post('/pembayaran-non-aop/pembayaran', [PembayaranController::class, 'store_pembayaran'])->name('pembayaran-non-aop.pembayaran-store');
    Route::get('/pembayaran-non-aop/pembayaran/cetak/{invoice_aop}', [PembayaranController::class, 'cetak'])->name('pembayaran-non-aop.cetak');
    Route::get('/pembayaran-non-aop/pembayaran-nota/{invoice_aop}', [PembayaranController::class, 'pembayaran_nota'])->name('pembayaran-non-aop.pembayaran-nota');
    Route::post('/pembayaran-non-aop/pembayaran-nota', [PembayaranController::class, 'store_pembayaran_balance'])->name('pembayaran-non-aop.pembayaran-store-balance');

    //ROUTE SP
    Route::get('/surat-pesanan', [SuratPesananController::class, 'index'])->name('surat-pesanan.index');
    Route::get('/surat-pesanan/create', [SuratPesananController::class, 'create'])->name('surat-pesanan.create');
    Route::post('/surat-pesanan/create', [SuratPesananController::class, 'store'])->name('surat-pesanan.store');
    Route::post('/surat-pesanan/detail/nosp', [SuratPesananController::class, 'store_details'])->name('surat-pesanan.store_details');
    Route::get('/surat-pesanan/detail/nosp/{nosp}', [SuratPesananController::class, 'detail'])->name('surat-pesanan.detail');

    //ROUTE SO
    Route::get('/sales-order', [SalesOrderController::class, 'index'])->name('sales-order.index');
    Route::get('/sales-order/create', [SalesOrderController::class, 'create'])->name('sales-order.create');
    Route::get('/sales-order/details/{nosp}', [SalesOrderController::class, 'details'])->name('sales-order.details');
    Route::post('/sales-order/create', [SalesOrderController::class, 'store'])->name('sales-order.store');
    Route::get('/sales-order/approve/{nosp}', [SalesOrderController::class, 'approve'])->name('sales-order.approve');
    Route::get('/sales-order/reject/{nosp}', [SalesOrderController::class, 'reject'])->name('sales-order.reject');
    Route::get('/sales-order/list-approved-so', [SalesOrderController::class, 'so_approved'])->name('sales-order.approved');
    Route::get('/sales-order/list-rejected-so', [SalesOrderController::class, 'so_rejected'])->name('sales-order.rejected');
    Route::get('/sales-order/edit/{id}', [SalesOrderController::class, 'edit'])->name('sales-order.edit');
    Route::post('/sales-order/update/{id}', [SalesOrderController::class, 'store_edit'])->name('sales-order.store_edit');
    Route::get('/sales-order/tolak/{noso}', [SalesOrderController::class, 'tolak'])->name('sales-order.tolak');
    
    //ROUTE BO
    Route::get('/back-order', [BackOrderController::class, 'index'])->name('back-order.index');
    Route::get('/back-order/details/{kd_outlet}', [BackOrderController::class, 'details'])->name('back-order.details');
    Route::get('/back-order/show/{nobo}', [BackOrderController::class, 'show'])->name('back-order.show');
    Route::get('/back-order/store/{id}', [BackOrderController::class, 'store'])->name('back-order.store');
    Route::delete('/back-order/delete/{id}', [BackOrderController::class, 'delete'])->name('back-order.delete');

    //ROUTE BO
    Route::get('/back-order', [BackOrderController::class, 'index'])->name('back-order.index');
    Route::get('/back-order/show/{nobo}', [BackOrderController::class, 'show'])->name('back-order.show');
    Route::get('/back-order/store/{id}', [BackOrderController::class, 'store'])->name('back-order.store');
    Route::delete('/back-order/delete/{id}', [BackOrderController::class, 'delete'])->name('back-order.delete');

    //ROUTE VALIDASI SO
    Route::get('/validasi-so', [ValidasiSOController::class, 'index'])->name('validasi-so.index');
    Route::get('/validasi-so/details/{noso}', [ValidasiSOController::class, 'details'])->name('validasi-so.details');
    Route::get('/validasi-so/create', [ValidasiSOController::class, 'create'])->name('validasi-so.create');
    Route::post('/validasi-so/store', [ValidasiSOController::class, 'store'])->name('validasi-so.store');
    Route::get('/validasi-so/reset-so', [ValidasiSOController::class, 'reset'])->name('validasi-so.reset');
    Route::get('/validasi-so/reset-so-store/{noso}', [ValidasiSOController::class, 'store_reset'])->name('validasi-so.store_reset');
    Route::get('/validasi-so/validasi/{noso}', [ValidasiSOController::class, 'validasi'])->name('validasi-so.validasi');
    Route::get('/validasi-so/cetak/{noso}', [ValidasiSOController::class, 'cetak'])->name('validasi-so.cetak');
    Route::get('/validasi-so/edit/{id}', [ValidasiSOController::class, 'edit_details'])->name('validasi-so.edit_details');
    Route::post('/validasi-so/store-update/{id}', [ValidasiSOController::class, 'store_edit'])->name('validasi-so.store_edit');

    //ROUTE PACKINGSHEET
    Route::get('/packingsheet', [PackingSheetController::class, 'index'])->name('packingsheet.index');
    Route::get('/packingsheet/reset-packingsheet', [PackingSheetController::class, 'reset'])->name('packingsheet.reset');
    Route::get('/packingsheet/reset-label/{nops}', [PackingSheetController::class, 'reset_label'])->name('packingsheet.reset_label');
    Route::get('/packingsheet/details/{nops}', [PackingSheetController::class, 'details'])->name('packingsheet.details');
    Route::post('/packingsheet/details/', [PackingSheetController::class, 'store_packingsheet'])->name('packingsheet.store_packingsheet');
    Route::get('/packingsheet/koli/{nops}', [PackingSheetController::class, 'koli'])->name('packingsheet.koli');
    Route::post('/packingsheet/koli', [PackingSheetController::class, 'store_dus'])->name('packingsheet.store-dus');
    Route::get('/packingsheet/cetak/{nops}', [PackingSheetController::class, 'cetak'])->name('packingsheet.cetak');
    Route::get('/packingsheet/cetak-label/{nops}', [PackingSheetController::class, 'cetak_label'])->name('packingsheet.cetak_label');
    Route::get('/packingsheet/reset-packingsheet/{nops}', [PackingSheetController::class, 'store_reset'])->name('packingsheet.store_reset');
    Route::get('/packingsheet/edit/{id}', [PackingSheetController::class, 'edit_details'])->name('packingsheet.edit_details');
    Route::post('/packingsheet/update/{id}/{nops}', [PackingSheetController::class, 'store_edit'])->name('packingsheet.store_edit');

    //ROUTE INVOICE
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice/create', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/approve/{noso}', [InvoiceController::class, 'approve'])->name('invoice.approve');
    Route::get('/invoice/reject/{noso}', [InvoiceController::class, 'reject'])->name('invoice.reject');
    Route::get('/invoice/cetak/{noinv}', [InvoiceController::class, 'cetak'])->name('invoice.cetak');

    //ROUTE SURAT JALAN
    Route::get('/surat-jalan', [SuratJalanController::class, 'index'])->name('surat-jalan.index');
    Route::get('/surat-jalan/reset', [SuratJalanController::class, 'reset'])->name('surat-jalan.reset');
    Route::post('/surat-jalan/store', [SuratJalanController::class, 'store_sj'])->name('surat-jalan.store_sj');
    Route::get('/surat-jalan/approve/{noso}', [SuratJalanController::class, 'approve'])->name('surat-jalan.approve');
    Route::get('/surat-jalan/reject/{noso}', [SuratJalanController::class, 'reject'])->name('surat-jalan.reject');
    Route::get('/surat-jalan/cetak/{nosj}', [SuratJalanController::class, 'cetak'])->name('surat-jalan.cetak');

    //ROUTE LKH
    Route::get('/laporan-kiriman-harian', [LkhController::class, 'index'])->name('laporan-kiriman-harian.index');
    Route::get('/laporan-kiriman-harian/create', [LkhController::class, 'create'])->name('laporan-kiriman-harian.create');
    Route::post('/laporan-kiriman-harian/store', [LkhController::class, 'store'])->name('laporan-kiriman-harian.store');
    Route::get('/laporan-kiriman-harian/approve/{noso}', [LkhController::class, 'approve'])->name('laporan-kiriman-harian.approve');
    Route::get('/laporan-kiriman-harian/reject/{noso}', [LkhController::class, 'reject'])->name('laporan-kiriman-harian.reject');
    Route::get('/laporan-kiriman-harian/details/{no_lkh}', [LkhController::class, 'details'])->name('laporan-kiriman-harian.details');
    Route::post('/laporan-kiriman-harian/details/{no_lkh}', [LkhController::class, 'store_details'])->name('laporan-kiriman-harian.store-details');
    Route::get('/laporan-kiriman-harian/cetak/{no_lkh}', [LkhController::class, 'cetak'])->name('laporan-kiriman-harian.cetak');
    Route::post('/laporan-kiriman-harian/store-update/{no_lkh}', [LkhController::class, 'update'])->name('laporan-kiriman-harian.update');
    Route::get('/laporan-kiriman-harian/history', [LkhController::class, 'history'])->name('laporan-kiriman-harian.history');

    //ROUTE STOK GUDANG
    Route::get('/stok-gudang', [StokGudangController::class, 'index'])->name('stok-gudang.index');
    Route::post('/stok-gudang', [StokGudangController::class, 'store'])->name('stok-gudang.store');
    Route::get('/stok-gudang/create', [StokGudangController::class, 'create'])->name('stok-gudang.create');
    Route::get('/stok-gudang/delete/{id}', [StokGudangController::class, 'delete'])->name('stok-gudang.delete');
    Route::get('/stok-gudang/update/{id}', [StokGudangController::class, 'edit'])->name('stok-gudang.edit');
    Route::post('/stok-gudang/update/{id}', [StokGudangController::class, 'update'])->name('stok-gudang.update');
    Route::get('/stok-gudang/show/{id}', [StokGudangController::class, 'show'])->name('stok-gudang.show');
    Route::get('/stok-gudang/create-barang-masuk', [StokGudangController::class, 'create_barang_masuk'])->name('stok-gudang.tambah');
    Route::post('/stok-gudang/create-barang-masuk/store', [StokGudangController::class, 'store_barang_masuk'])->name('stok-gudang.store-barang-masuk');
    Route::get('/stok-gudang/details-barang-masuk/{id}', [StokGudangController::class, 'add_details'])->name('stok-gudang.add-details');
    Route::post('/stok-gudang/details-barang-masuk-store', [StokGudangController::class, 'store_add_details'])->name('stok-gudang.store_add_details');
    Route::get('/stok-gudang/list-barang-masuk', [StokGudangController::class, 'list'])->name('stok-gudang.list');
    Route::get('/stok-gudang/list-details-barang-masuk/{id}', [StokGudangController::class, 'list_details'])->name('stok-gudang.list-details');
    Route::post('/stok-gudang/store-details-barang-masuk', [StokGudangController::class, 'store_list_details'])->name('stok-gudang.store_list_details');

    //ROUTE MASTER TOKO
    Route::get('/master-toko', [MasterTokoController::class, 'index'])->name('master-toko.index');
    Route::get('/master-toko/create', [MasterTokoController::class, 'create'])->name('master-toko.create');
    Route::get('/master-toko/list-pengajuan', [MasterTokoController::class, 'list_pengajuan'])->name('master-toko.list-pengajuan');
    Route::get('/master-toko/edit/{kd_outlet}', [MasterTokoController::class, 'edit'])->name('master-toko.edit');
    Route::get('/master-toko/details/{kd_outlet}', [MasterTokoController::class, 'details'])->name('master-toko.details');
    Route::get('/master-toko/nonaktif/{kd_outlet}', [MasterTokoController::class, 'nonaktif'])->name('master-toko.nonaktif');
    Route::post('/master-toko/update', [MasterTokoController::class, 'update'])->name('master-toko.update');

    //ROUTE MASTER SALES
    Route::get('/master-sales', [MasterSalesController::class, 'index'])->name('master-sales.index');
    Route::post('/master-sales/details', [MasterSalesController::class, 'store'])->name('master-sales.store');
    Route::post('/master-sales/store-details', [MasterSalesController::class, 'store_details'])->name('master-sales.store-details');
    Route::get('/master-sales/create', [MasterSalesController::class, 'create'])->name('master-sales.create');
    Route::get('/master-sales/show/{id}', [MasterSalesController::class, 'show'])->name('master-sales.show');
    Route::get('/master-sales/tambah-wilayah/{id}', [MasterSalesController::class, 'tambah_wilayah'])->name('master-sales.tambah-wilayah');
    Route::delete('/master-sales/destroy/{id}', [MasterSalesController::class, 'destroy'])->name('master-sales.destroy');
    Route::post('/master-sales/delete/{id}', [MasterSalesController::class, 'delete'])->name('master-sales.delete');

    //ROUTE MASTER PART HET
    Route::get('/master-part-het', [MasterPartHetController::class, 'index'])->name('master-part-het.index');
    Route::post('/master-part-het', [MasterPartHetController::class, 'store'])->name('master-part-het.store');
    Route::get('/master-part-het/create', [MasterPartHetController::class, 'create'])->name('master-part-het.create');

    //ROUTE AR
    Route::get('/account-receivable', [AccountReceivableController::class, 'index'])->name('account-receivable.index');
    Route::get('/account-receivable/cetak', [AccountReceivableController::class, 'cetak'])->name('account-receivable.cetak');
    Route::post('/account-receivable/cetak-pdf', [AccountReceivableController::class, 'cetak_pdf'])->name('account-receivable.cetak-pdf');
    Route::get('/account-receivable/create', [AccountReceivableController::class, 'create'])->name('account-receivable.create');
    Route::post('/account-receivable/store', [AccountReceivableController::class, 'store'])->name('account-receivable.store');
    Route::post('/account-receivable/daftar-piutang-toko', [AccountReceivableController::class, 'search'])->name('account-receivable.search');
    Route::get('/account-receivable/daftar-piutang-toko/{kd_outlet}', [AccountReceivableController::class, 'dpt'])->name('account-receivable.dpt');
    Route::get('/account-receivable/details/{no_piutang}', [AccountReceivableController::class, 'details'])->name('account-receivable.details');
    Route::post('/account-receivable/store-details', [AccountReceivableController::class, 'store_details'])->name('account-receivable.store-details');

    //RINCIAN TAGIHAN
    Route::get('/rincian-tagihan', [RincianTagihanController::class, 'index'])->name('rincian-tagihan.index');
    Route::post('/rincian-tagihan/approve/{id}', [RincianTagihanController::class, 'approve'])->name('rincian-tagihan.approve');

    //ROUTE PEMBAYARAN PIUTANG TOKO
    Route::get('/piutang-toko', [PembayaranPiutangTokoController::class, 'index'])->name('piutang-toko.index');
    Route::get('/piutang-toko/create', [PembayaranPiutangTokoController::class, 'create'])->name('piutang-toko.create');
    Route::post('/piutang-toko/store', [PembayaranPiutangTokoController::class, 'store'])->name('piutang-toko.store');
    Route::get('/piutang-toko/details/{no_piutang}', [PembayaranPiutangTokoController::class, 'details'])->name('piutang-toko.details');
    Route::get('/piutang-toko/edit/{no_piutang}', [PembayaranPiutangTokoController::class, 'edit'])->name('piutang-toko.edit');
    Route::post('/piutang-toko/store-details', [PembayaranPiutangTokoController::class, 'store_details'])->name('piutang-toko.store-details');
    Route::post('/piutang-toko/store-kas', [PembayaranPiutangTokoController::class, 'store_kas'])->name('piutang-toko.store-kas');
    Route::get('/piutang-toko/cetak/{no_piutang}', [PembayaranPiutangTokoController::class, 'cetak'])->name('piutang-toko.cetak');
    Route::get('/piutang-toko/tanda-terima/{no_kas_masuk}', [PembayaranPiutangTokoController::class, 'tanda_terima'])->name('piutang-toko.tanda-terima');
    Route::post('/piutang-toko/store-tanda-terima', [PembayaranPiutangTokoController::class, 'store_tanda_terima'])->name('piutang-toko.store-tanda-terima');

    //ROUTE PEMBAYARAN PIUTANG TOKO
    Route::get('/pembayaran-toko', [PembayaranTokoController::class, 'index'])->name('pembayaran-toko.index');

    //KAS KELUAR
    Route::get('/kas-masuk', [KasMasukController::class, 'index'])->name('kas-masuk.index');
    Route::get('/kas-masuk/bukti-bayar', [KasMasukController::class, 'bukti_bayar'])->name('kas-masuk.bukti-bayar');
    Route::get('/kas-masuk/bayar-manual', [KasMasukController::class, 'bayar_manual'])->name('kas-masuk.bayar-manual');
    Route::get('/kas-masuk/bayar-manual/details/{no_kas_masuk}', [KasMasukController::class, 'details'])->name('kas-masuk.details');
    Route::post('/kas-masuk/store-bukti-bayar', [KasMasukController::class, 'store_bukti_bayar'])->name('kas-masuk.store-bukti-bayar');
    Route::post('/kas-masuk/store', [KasMasukController::class, 'store'])->name('kas-masuk.store');
    Route::post('/kas-masuk/store-details', [KasMasukController::class, 'store_details'])->name('kas-masuk.store-details');
    Route::get('/kas-masuk/bukti-bayar', [KasMasukController::class, 'bukti_bayar'])->name('kas-masuk.bukti-bayar');
    Route::get('/kas-masuk/pembayaran-manual', [KasMasukController::class, 'pembayaran_manual'])->name('kas-masuk.bayar_manual');
    Route::get('/kas-masuk/cetak/{no_kas_masuk}', [KasMasukController::class, 'cetak'])->name('kas-masuk.cetak');
    Route::get('/kas-masuk/cetak-tanda-terima/{no_kas_masuk}', [KasMasukController::class, 'cetak_tanda_terima'])->name('kas-masuk.cetak-tanda-terima');
    Route::delete('/kas-masuk/delete-details/{id}', [KasMasukController::class, 'delete_details'])->name('kas-masuk.delete-details');
    Route::delete('/kas-masuk/delete/{id}', [KasMasukController::class, 'delete'])->name('kas-masuk.delete');

    //KAS KELUAR
    Route::get('/kas-keluar', [KasKeluarController::class, 'index'])->name('kas-keluar.index');
    Route::get('/kas-keluar/create', [KasKeluarController::class, 'create'])->name('kas-keluar.create');
    Route::post('/kas-keluar/store', [KasKeluarController::class, 'store'])->name('kas-keluar.store');
    Route::get('/kas-keluar/details/{no_keluar}', [KasKeluarController::class, 'details'])->name('kas-keluar.details');
    Route::post('/kas-keluar/store-details', [KasKeluarController::class, 'store_details'])->name('kas-keluar.store-details');
    Route::post('/kas-keluar/store-selesai', [KasKeluarController::class, 'store_kas_keluar'])->name('kas-keluar.store-selesai');
    Route::get('/kas-keluar/show/{no_keluar}', [KasKeluarController::class, 'show'])->name('kas-keluar.show');
    Route::delete('/kas-keluar/delete/{no_keluar}', [KasKeluarController::class, 'delete'])->name('kas-keluar.delete');
    Route::delete('/kas-keluar/delete-details/{id}', [KasKeluarController::class, 'delete_details'])->name('kas-keluar.delete-details');
    Route::get('/kas-keluar/cetak/{no_keluar}', [KasKeluarController::class, 'cetak'])->name('kas-keluar.cetak');
    Route::get('/kas-keluar/update/{no_keluar}', [KasKeluarController::class, 'update'])->name('kas-keluar.update');

    //REPORT KAS
    Route::get('/report-kas', [ReportKasController::class, 'index'])->name('report-kas.index');
    Route::get('/report-kas/store', [ReportKasController::class, 'store'])->name('report-kas.store');

    //BG MASUK
    Route::get('/bg-masuk', [BgMasukController::class, 'index'])->name('bg-masuk.index');
    Route::get('/bg-masuk/cair/{no_bg}', [BgMasukController::class, 'store'])->name('bg-masuk.store');
    Route::get('/bg-masuk/details/{id_bg}', [BgMasukController::class, 'details'])->name('bg-masuk.details');
    Route::post('/bg-masuk/store-details', [BgMasukController::class, 'store_details'])->name('bg-masuk.store-details');
    Route::get('/bg-masuk/bukti-bayar', [BgMasukController::class, 'bukti_bayar'])->name('bg-masuk.bukti-bayar');
    Route::get('/bg-masuk/pembayaran-manual', [BgMasukController::class, 'pembayaran_manual'])->name('bg-masuk.bayar_manual');
    Route::get('/bg-masuk/cetak/{no_kas_masuk}', [BgMasukController::class, 'cetak'])->name('bg-masuk.cetak');
    Route::get('/bg-masuk/cetak-tanda-terima/{no_kas_masuk}', [BgMasukController::class, 'cetak_tanda_terima'])->name('bg-masuk.cetak-tanda-terima');
    Route::delete('/bg-masuk/delete-details/{id}', [BgMasukController::class, 'delete_details'])->name('bg-masuk.delete-details');
    Route::delete('/bg-masuk/delete/{id}', [BgMasukController::class, 'delete'])->name('bg-masuk.delete');

     //BG Keluar
    Route::get('/bg-keluar', [BgKeluarController::class, 'index'])->name('bg-keluar.index');
    Route::get('/bg-keluar/create', [BgKeluarController::class, 'create'])->name('bg-keluar.create');
    Route::get('/bg-keluar/store', [BgKeluarController::class, 'store'])->name('bg-keluar.store');

    //TRANSFER MASUK
    Route::get('/transfer-masuk', [TransferMasukController::class, 'index'])->name('transfer-masuk.index');
    Route::get('/transfer-masuk/create', [TransferMasukController::class, 'create'])->name('transfer-masuk.create');
    Route::post('/transfer-masuk/store', [TransferMasukController::class, 'store'])->name('transfer-masuk.store');
    Route::get('/transfer-masuk/list-validasi', [TransferMasukController::class, 'validasi'])->name('transfer-masuk.validasi');
    Route::get('/transfer-masuk/validasi/{id_transfer}', [TransferMasukController::class, 'validasi_data'])->name('transfer-masuk.validasi-data');
    Route::get('/transfer-masuk/details/{id_transfer}', [TransferMasukController::class, 'details'])->name('transfer-masuk.details');
    Route::post('/transfer-masuk/store-details', [TransferMasukController::class, 'store_details'])->name('transfer-masuk.store-details');
    Route::post('/transfer-masuk/store-validasi/{id_transfer}', [TransferMasukController::class, 'store_validasi'])->name('transfer-masuk.store-validasi');
    Route::get('/transfer-masuk/edit/{id_transfer}', [TransferMasukController::class, 'edit'])->name('transfer-masuk.edit');
    Route::get('/transfer-masuk/cetak/{id_transfer}', [TransferMasukController::class, 'cetak'])->name('transfer-masuk.cetak');
    Route::post('/transfer-masuk/store-transfer', [TransferMasukController::class, 'store_transfer'])->name('transfer-masuk.store-transfer');
    Route::delete('/transfer-masuk/details/{id}', [TransferMasukController::class, 'delete_details'])->name('transfer-masuk.delete-details');
    Route::delete('/transfer-masuk/delete-details/{id}', [TransferMasukController::class, 'delete_details'])->name('transfer-masuk.delete');

    //TRANSFER
    Route::get('/transfer-keluar', [TransferKeluarController::class, 'index'])->name('transfer-keluar.index');
    Route::get('/transfer-keluar/create', [TransferKeluarController::class, 'create'])->name('transfer-keluar.create');
    Route::post('/transfer-keluar/store', [TransferKeluarController::class, 'store'])->name('transfer-keluar.store');
    Route::get('/transfer-keluar/list-validasi', [TransferKeluarController::class, 'validasi'])->name('transfer-keluar.validasi');
    Route::get('/transfer-keluar/validasi/{id_transfer}', [TransferKeluarController::class, 'validasi_data'])->name('transfer-keluar.validasi-data');
    Route::get('/transfer-keluar/details/{id_transfer}', [TransferKeluarController::class, 'details'])->name('transfer-keluar.details');
    Route::post('/transfer-keluar/store-details', [TransferKeluarController::class, 'store_details'])->name('transfer-keluar.store-details');
    Route::post('/transfer-keluar/store-validasi/{id_transfer}', [TransferKeluarController::class, 'store_validasi'])->name('transfer-keluar.store-validasi');
    Route::get('/transfer-keluar/edit/{id_transfer}', [TransferKeluarController::class, 'edit'])->name('transfer-keluar.edit');
    Route::post('/transfer-keluar/store-transfer', [TransferKeluarController::class, 'store_transfer'])->name('transfer-keluar.store-transfer');
    Route::delete('/transfer-keluar/delete-details/{id}', [TransferMasukController::class, 'delete_details'])->name('transfer-keluar.delete-details');
    
    //MUTASI
    Route::get('/kode-rak-lokasi', [KodeRakLokasiController::class, 'index'])->name('kode-rak-lokasi.index');
    Route::post('/kode-rak-lokasi', [KodeRakLokasiController::class, 'store'])->name('kode-rak-lokasi.store');
    Route::get('/kode-rak-lokasi/create', [KodeRakLokasiController::class, 'create'])->name('kode-rak-lokasi.create');
    Route::get('/kode-rak-lokasi/show/{id}', [KodeRakLokasiController::class, 'show'])->name('kode-rak-lokasi.show');
    Route::get('/kode-rak-lokasi/edit/{id}', [KodeRakLokasiController::class, 'edit'])->name('kode-rak-lokasi.edit');
    Route::get('/kode-rak-lokasi/show/{id}', [KodeRakLokasiController::class, 'show'])->name('kode-rak-lokasi.show');
    Route::get('/kode-rak-lokasi/delete/{id}', [KodeRakLokasiController::class, 'delete'])->name('kode-rak-lokasi.delete');
    Route::get('/kode-rak-lokasi/mutasi/{id}', [KodeRakLokasiController::class, 'mutasi'])->name('kode-rak-lokasi.mutasi');
    Route::post('/kode-rak-lokasi/mutasi/store', [KodeRakLokasiController::class, 'store_mutasi'])->name('kode-rak-lokasi.store_mutasi');

    //MUTASI
    Route::get('/mutasi-part', [MutasiPartController::class, 'index'])->name('mutasi-part.index');
    Route::get('/mutasi-part/details/{no_mutasi}', [MutasiPartController::class, 'details'])->name('mutasi-part.details');
    Route::get('/mutasi-part/approve/{no_mutasi}', [MutasiPartController::class, 'approve'])->name('mutasi-part.approve');
    Route::get('/mutasi-part/reject/{no_mutasi}', [MutasiPartController::class, 'reject'])->name('mutasi-part.reject');

    //MST. SALES ACHIVEMENTS
    Route::get('/master-target', [MasterTargetController::class, 'index'])->name('master-target.index');
    Route::post('/master-target', [MasterTargetController::class, 'store'])->name('master-target.store');
    Route::get('/master-target/create', [MasterTargetController::class, 'create'])->name('master-target.create');
    Route::get('/master-target/show/{id}', [MasterTargetController::class, 'show'])->name('master-target.show');
    Route::get('/master-target/delete/{id}', [MasterTargetController::class, 'delete'])->name('master-target.delete');
    Route::get('/master-target/edit/{id}', [MasterTargetController::class, 'edit'])->name('master-target.edit');
    Route::get('/master-target/update/{id}', [MasterTargetController::class, 'update'])->name('master-target.update');
    Route::delete('/master-target/destroy/{id}', [MasterTargetController::class, 'destroy'])->name('master-target.destroy');

    //MST. SPV ACHIVEMENTS
    Route::get('/master-target-spv', [MasterTargetSpvController::class, 'index'])->name('master-target-spv.index');
    Route::post('/master-target-spv', [MasterTargetSpvController::class, 'store'])->name('master-target-spv.store');
    Route::get('/master-target-spv/create', [MasterTargetSpvController::class, 'create'])->name('master-target-spv.create');
    Route::get('/master-target-spv/show/{id}', [MasterTargetSpvController::class, 'show'])->name('master-target-spv.show');
    Route::get('/master-target-spv/edit/{id}', [MasterTargetSpvController::class, 'edit'])->name('master-target-spv.edit');
    Route::post('/master-target-spv/update/{id}', [MasterTargetSpvController::class, 'update'])->name('master-target-spv.update');
    Route::delete('/master-target-spv/destroy/{id}', [MasterTargetSpvController::class, 'destroy'])->name('master-target-spv.destroy');

    //MST. SPV BY PRODUCT ACHIVEMENTS
    Route::get('/master-target-spv-produk', [MasterTargetSpvProdukController::class, 'index'])->name('master-target-spv-produk.index');
    Route::post('/master-target-spv-produk', [MasterTargetSpvProdukController::class, 'store'])->name('master-target-spv-produk.store');
    Route::get('/master-target-spv-produk/create', [MasterTargetSpvProdukController::class, 'create'])->name('master-target-spv-produk.create');
    Route::get('/master-target-spv-produk/show/{id}', [MasterTargetSpvProdukController::class, 'show'])->name('master-target-spv-produk.show');
    Route::get('/master-target-spv-produk/edit/{id}', [MasterTargetSpvProdukController::class, 'edit'])->name('master-target-spv-produk.edit');
    Route::post('/master-target-spv-produk/update/{id}', [MasterTargetSpvProdukController::class, 'update'])->name('master-target-spv-produk.update');
    Route::delete('/master-target-spv-produk/destroy/{id}', [MasterTargetSpvProdukController::class, 'destroy'])->name('master-target-spv-produk.destroy');

    //MST. SALES BY PRODUCT ACHIVEMENTS
    Route::get('/master-target-sales-produk', [MasterTargetSalesProductController::class, 'index'])->name('master-target-sales-produk.index');
    Route::post('/master-target-sales-produk', [MasterTargetSalesProductController::class, 'store'])->name('master-target-sales-produk.store');
    Route::get('/master-target-sales-produk/create', [MasterTargetSalesProductController::class, 'create'])->name('master-target-sales-produk.create');
    Route::get('/master-target-sales-produk/show/{id}', [MasterTargetSalesProductController::class, 'show'])->name('master-target-sales-produk.show');
    Route::get('/master-target-sales-produk/edit/{id}', [MasterTargetSalesProductController::class, 'edit'])->name('master-target-sales-produk.edit');
    Route::post('/master-target-sales-produk/update/{id}', [MasterTargetSalesProductController::class, 'update'])->name('master-target-sales-produk.update');
    Route::delete('/master-target-sales-produk/destroy/{id}', [MasterTargetSalesProductController::class, 'destroy'])->name('master-target-sales-produk.destroy');

    //MONITORING ACH. MARKETING
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/pencapaian-sales', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::get('/monitoring/spv', [MonitoringController::class, 'spv'])->name('monitoring.spv');
    Route::get('/monitoring/pencapaian-spv', [MonitoringController::class, 'spv_store'])->name('monitoring.spv_store');
    Route::get('/monitoring/pesanan', [MonitoringController::class, 'pesanan'])->name('monitoring.pesanan');
    Route::get('/monitoring/pesanan-terjual', [MonitoringController::class, 'pesanan_store'])->name('monitoring.pesanan-store');

    //LSS
    Route::get('/report-lss', [ReportLssController::class, 'index'])->name('report-lss.index');
    Route::get('/report-lss/view', [ReportLssController::class, 'store'])->name('report-lss.store');

    //EXPORT PAJAK
    Route::get('/export-pajak', [ExportPajakController::class, 'index'])->name('export-pajak.index');
    Route::get('/export-pajak/cetak', [ExportPajakController::class, 'cetak'])->name('export-pajak.cetak');
    Route::post('/export-pajak/store', [ExportPajakController::class, 'store'])->name('export-pajak.store');

    //MODAL PENJUALAN
    Route::get('/modal', [ModalDbpController::class, 'index'])->name('modal.index');
    Route::post('/modal/store', [ModalDbpController::class, 'store'])->name('modal.store');

    //HISTORY PESANAN
    Route::get('/history-pesanan', [HistoryPesananController::class, 'index'])->name('history-pesanan.index');

    //RETUR
    Route::get('/retur', [ReturController::class, 'index'])->name('retur.index');
    Route::get('/retur/create', [ReturController::class, 'create'])->name('retur.create');
    Route::post('/retur/store', [ReturController::class, 'store'])->name('retur.store');
    Route::get('/retur/details/{no_retur}', [ReturController::class, 'details'])->name('retur.details');
    Route::post('/retur/store-details', [ReturController::class, 'store_details'])->name('retur.store-details');
    Route::get('/retur/approve/{id}', [ReturController::class, 'approve'])->name('retur.approve');
    Route::get('/retur/history', [ReturController::class, 'history'])->name('retur.history');

});

Route::get('/login', [LoginController::class, 'formLogin'])->name('login.formLogin');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'formRegister'])->name('login.formRegister');




