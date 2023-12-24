<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login','Api\ApiAuthController@authenticate')->name('api.login.authenticate');
Route::post('/register','Api\ApiAuthController@register')->name('api.register');


Route::get('/produk','user\ProdukController@api')->name('user.produk.api');
Route::get('/produkwithcategory/{category_id}','user\ProdukController@productwithcategory')->name('user.produk.productwithcategory');
Route::get('/kategori','user\ProdukController@categories')->name('user.produk.categories');
Route::get('/produk/{id}','user\ProdukController@detailapi')->name('user.produk.detailapi');
Route::get('/banner','user\BannerController@api')->name('user.banner.api');
Route::get('/getProvince','Api\AlamatController@getProvince')->name('user.alamat.getProvince');
Route::get('/getCity/{id}','Api\AlamatController@getCity')->name('user.alamat.getCity');

Route::group(['middleware' => ['jwt.verify']], function() {
     Route::get('/get_user', 'Api\ApiAuthController@get_user')->name('api.get_user');
    
   
    Route::post('/keranjang/update/{id}','Api\KeranjangController@update')->name('user.keranjang.update');
    Route::post('/keranjang/simpan','Api\KeranjangController@simpan')->name('api.keranjang.simpan');
    Route::get('/keranjang','Api\KeranjangController@index')->name('api.keranjang');
    Route::post('/keranjang/delete/{id}','Api\KeranjangController@delete')->name('api.keranjang.delete');
    
    Route::get('/alamat','Api\AlamatController@index')->name('user.alamat');
    Route::post('/alamat/simpan','Api\AlamatController@simpan')->name('user.alamat.simpan');
    Route::post('/alamat/update/{id}','Api\AlamatController@update')->name('user.alamat.update');
    Route::post('/alamat/primary/{id}','Api\AlamatController@primary')->name('user.alamat.primary');
    Route::get('/alamat/ubah/{id}','Api\AlamatController@ubah')->name('user.alamat.ubah');
    
    Route::get('/checkout','Api\CheckoutController@index')->name('user.checkout');
    Route::post('/order/simpan','Api\OrderController@simpan')->name('user.order.simpan');
    Route::get('/order/sukses','Api\OrderController@sukses')->name('user.order.sukses');
    Route::get('/order','Api\OrderController@index')->name('user.order');
    Route::get('/order/detail/{id}','Api\OrderController@detail')->name('user.order.detail');
    Route::get('/order/pesananditerima/{id}','Api\OrderController@pesananditerima')->name('user.order.pesananditerima');
    Route::get('/order/pesanandibatalkan/{id}','Api\OrderController@pesanandibatalkan')->name('user.order.pesanandibatalkan');
    Route::get('/order/pembayaran','Api\OrderController@pembayaran')->name('user.order.pembayaran');
    Route::post('/order/kirimbukti/{id}','Api\OrderController@kirimbukti')->name('user.order.kirimbukti');
    
    Route::get('/order_selesai','Api\OrderController@selesai')->name('user.order.selesai');
    Route::get('/order_belum_bayar','Api\OrderController@belum_bayar')->name('user.order.belum_bayar');
    
    Route::get('/order_proses','Api\OrderController@proses')->name('user.order.proses');

    
    Route::post('/logout','Api\ApiAuthController@login')->name('api.logout');
});
