<?php
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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreOrderController;

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/pelanggan',function(){
    return 'Pelanggan';
});

Route::get('/admin/kedatangan/cetak/{id}','admin\KedatanganController@cetak')->name('admin.kedatangan.cetak');


Route::group(['middleware' => ['auth','checkRole:admin']],function(){
    Route::get('/admin','DashboardController@index')->name('admin.dashboard');
    Route::get('/pengaturan/alamat','admin\PengaturanController@aturalamat')->name('admin.pengaturan.alamat');
    Route::get('/pengaturan/ubahalamat/{id}','admin\PengaturanController@ubahalamat')->name('admin.pengaturan.ubahalamat');
    Route::get('/pengaturan/alamat/getcity/{id}','admin\PengaturanController@getCity')->name('admin.pengaturan.getCity');
    Route::post('pengaturan/simpanalamat','admin\PengaturanController@simpanalamat')->name('admin.pengaturan.simpanalamat');
    Route::post('pengaturan/updatealamat/{id}','admin\PengaturanController@updatealamat')->name('admin.pengaturan.updatealamat');

    Route::get('/admin/categories','admin\CategoriesController@index')->name('admin.categories');
    Route::get('/admin/categories/tambah','admin\CategoriesController@tambah')->name('admin.categories.tambah');
    Route::post('/admin/categories/store','admin\CategoriesController@store')->name('admin.categories.store');
    Route::post('/admin/categories/update/{id}','admin\CategoriesController@update')->name('admin.categories.update');
    Route::get('/admin/categories/edit/{id}','admin\CategoriesController@edit')->name('admin.categories.edit');
    Route::get('/admin/categories/delete/{id}','admin\CategoriesController@delete')->name('admin.categories.delete');

    Route::get('/admin/grade','admin\GradeController@index')->name('admin.grade');
    Route::get('/admin/grade/tambah','admin\GradeController@tambah')->name('admin.grade.tambah');
    Route::post('/admin/grade/store','admin\GradeController@store')->name('admin.grade.store');
    Route::post('/admin/grade/update/{id}','admin\GradeController@update')->name('admin.grade.update');
    Route::get('/admin/grade/edit/{id}','admin\GradeController@edit')->name('admin.grade.edit');
    Route::get('/admin/grade/delete/{id}','admin\GradeController@delete')->name('admin.grade.delete');

    Route::get('/admin/fish','admin\FishController@index')->name('admin.fish');
    Route::get('/admin/fish/tambah','admin\FishController@tambah')->name('admin.fish.tambah');
    Route::post('/admin/fish/store','admin\FishController@store')->name('admin.fish.store');
    Route::post('/admin/fish/update/{id}','admin\FishController@update')->name('admin.fish.update');
    Route::get('/admin/fish/edit/{id}','admin\FishController@edit')->name('admin.fish.edit');
    Route::get('/admin/fish/delete/{id}','admin\FishController@delete')->name('admin.fish.delete');

    Route::get('/admin/size','admin\SizeController@index')->name('admin.size');
    Route::get('/admin/size/tambah','admin\SizeController@tambah')->name('admin.size.tambah');
    Route::post('/admin/size/store','admin\SizeController@store')->name('admin.size.store');
    Route::post('/admin/size/update/{id}','admin\SizeController@update')->name('admin.size.update');
    Route::get('/admin/size/edit/{id}','admin\SizeController@edit')->name('admin.size.edit');
    Route::get('/admin/size/delete/{id}','admin\SizeController@delete')->name('admin.size.delete');

    Route::get('/admin/supplier','admin\SupplierController@index')->name('admin.supplier');
    Route::get('/admin/supplier/tambah','admin\SupplierController@tambah')->name('admin.supplier.tambah');
    Route::post('/admin/supplier/store','admin\SupplierController@store')->name('admin.supplier.store');
    Route::post('/admin/supplier/update/{id}','admin\SupplierController@update')->name('admin.supplier.update');
    Route::get('/admin/supplier/edit/{id}','admin\SupplierController@edit')->name('admin.supplier.edit');
    Route::get('/admin/supplier/delete/{id}','admin\SupplierController@delete')->name('admin.supplier.delete');

    Route::get('/admin/warehouse','admin\WarehouseController@index')->name('admin.warehouse');
    Route::get('/admin/warehouse/tambah','admin\WarehouseController@tambah')->name('admin.warehouse.tambah');
    Route::post('/admin/warehouse/store','admin\WarehouseController@store')->name('admin.warehouse.store');
    Route::post('/admin/warehouse/update/{id}','admin\WarehouseController@update')->name('admin.warehouse.update');
    Route::get('/admin/warehouse/edit/{id}','admin\WarehouseController@edit')->name('admin.warehouse.edit');
    Route::get('/admin/warehouse/delete/{id}','admin\WarehouseController@delete')->name('admin.warehouse.delete');

    Route::get('/admin/kedatangan','admin\KedatanganController@index')->name('admin.kedatangan');
    Route::get('/admin/kedatangan/tambah','admin\KedatanganController@tambah')->name('admin.kedatangan.tambah');
    Route::post('/admin/kedatangan/store','admin\KedatanganController@store')->name('admin.kedatangan.store');
    Route::post('/admin/kedatangan/update/{id}','admin\KedatanganController@update')->name('admin.kedatangan.update');
    Route::get('/admin/kedatangan/edit/{id}','admin\KedatanganController@edit')->name('admin.kedatangan.edit');
    Route::get('/admin/kedatangan/delete/{id}','admin\KedatanganController@delete')->name('admin.kedatangan.delete');

    Route::get('/admin/rack','admin\RackController@index')->name('admin.rack');
    Route::get('/admin/rack/tambah','admin\RackController@tambah')->name('admin.rack.tambah');
    Route::post('/admin/rack/store','admin\RackController@store')->name('admin.rack.store');
    Route::post('/admin/rack/update/{id}','admin\RackController@update')->name('admin.rack.update');
    Route::get('/admin/rack/edit/{id}','admin\RackController@edit')->name('admin.rack.edit');
    Route::get('/admin/rack/delete/{id}','admin\RackController@delete')->name('admin.rack.delete');

    Route::get('/admin/product','admin\ProductController@index')->name('admin.product');
    Route::get('/admin/product/tambah','admin\ProductController@tambah')->name('admin.product.tambah');
    Route::post('/admin/product/store','admin\ProductController@store')->name('admin.product.store');
    Route::get('/admin/product/edit/{id}','admin\ProductController@edit')->name('admin.product.edit');
    Route::get('/admin/product/delete/{id}','admin\ProductController@delete')->name('admin.product.delete');
    Route::post('/admin/product/update/{id}','admin\ProductController@update')->name('admin.product.update');

    Route::get('/admin/assign','admin\AssignController@index')->name('admin.assign');
    Route::get('/admin/assign/tambah','admin\AssignController@tambah')->name('admin.assign.tambah');
    Route::post('/admin/assign/store','admin\AssignController@store')->name('admin.assign.store');
    Route::post('/admin/assign/update/{id}','admin\AssignController@update')->name('admin.assign.update');
    Route::get('/admin/assign/edit/{id}','admin\AssignController@edit')->name('admin.assign.edit');
    Route::get('/admin/assign/delete/{id}','admin\AssignController@delete')->name('admin.assign.delete');

    Route::get('/admin/purchase','admin\PurchaseController@index')->name('admin.purchase');
    Route::get('/admin/purchase/tambah','admin\PurchaseController@tambah')->name('admin.purchase.tambah');
    Route::post('/admin/purchase/store','admin\PurchaseController@store')->name('admin.purchase.store');
    Route::post('/admin/purchase/update/{id}','admin\PurchaseController@update')->name('admin.purchase.update');
    Route::get('/admin/purchase/edit/{id}','admin\PurchaseController@edit')->name('admin.purchase.edit');
    Route::get('/admin/purchase/delete/{id}','admin\PurchaseController@delete')->name('admin.purchase.delete');

    Route::get('/admin/banner','admin\BannerController@index')->name('admin.banner');
    Route::get('/admin/banner/tambah','admin\BannerController@tambah')->name('admin.banner.tambah');
    Route::post('/admin/banner/store','admin\BannerController@store')->name('admin.banner.store');
    Route::get('/admin/banner/edit/{id}','admin\BannerController@edit')->name('admin.banner.edit');
    Route::get('/admin/banner/delete/{id}','admin\BannerController@delete')->name('admin.banner.delete');
    Route::post('/admin/banner/update/{id}','admin\BannerController@update')->name('admin.banner.update');

    Route::get('/admin/transaksi','admin\TransaksiController@index')->name('admin.transaksi');
    Route::get('/admin/transaksi/perludicek','admin\TransaksiController@perludicek')->name('admin.transaksi.perludicek');
    Route::get('/admin/transaksi/perludikirim','admin\TransaksiController@perludikirim')->name('admin.transaksi.perludikirim');
    Route::get('/admin/transaksi/dikirim','admin\TransaksiController@dikirim')->name('admin.transaksi.dikirim');
    Route::get('/admin/transaksi/detail/{id}','admin\TransaksiController@detail')->name('admin.transaksi.detail');
    Route::get('/admin/transaksi/konfirmasi/{id}','admin\TransaksiController@konfirmasi')->name('admin.transaksi.konfirmasi');
    Route::post('/admin/transaksi/inputresi/{id}','admin\TransaksiController@inputresi')->name('admin.transaksi.inputresi');
    Route::get('/admin/transaksi/selesai','admin\TransaksiController@selesai')->name('admin.transaksi.selesai');
    Route::get('/admin/transaksi/dibatalkan','admin\TransaksiController@dibatalkan')->name('admin.transaksi.dibatalkan');

    Route::get('/admin/rekening','admin\RekeningController@index')->name('admin.rekening');
    Route::get('/admin/rekening/edit/{id}','admin\RekeningController@edit')->name('admin.rekening.edit');
    Route::get('/admin/rekening/tambah','admin\RekeningController@tambah')->name('admin.rekening.tambah');
    Route::post('/admin/rekening/store','admin\RekeningController@store')->name('admin.rekening.store');
    Route::get('/admin/rekening/delete/{id}','admin\RekeningController@delete')->name('admin.rekening.delete');
    Route::post('/admin/rekening/update/{id}','admin\RekeningController@update')->name('admin.rekening.update');

    Route::get('/admin/pelanggan','admin\PelangganController@index')->name('admin.pelanggan');


    Route::prefix('admin/preorder')->group(function(){
        Route::get('/admin/kedatangan/edit/{id}','admin\KedatanganController@edit')->name('admin.kedatangan.edit');

        Route::get('/',[PreOrderController::class, 'index'])->name('admin.preOrder');
        Route::get('/tambah',[PreOrderController::class, 'create'])->name('admin.preOrder.tambah');
        Route::post('/store',[PreOrderController::class, 'store'])->name('admin.preOrder.store');
        Route::get('/edit/{id}',[PreOrderController::class, 'edit'])->name('admin.preOrder.edit');
        Route::put('/update/{id}',[PreOrderController::class, 'update'])->name('admin.preOrder.update');
        Route::get('/delete/{id}',[PreOrderController::class, 'destroy'])->name('admin.preOrder.delete');
        Route::get('/cetak/{id}',[PreOrderController::class, 'print'])->name('admin.preOrder.cetak');
    });

});
