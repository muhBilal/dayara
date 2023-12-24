<?php

namespace App\Http\Controllers\Api;

use App\Alamat;
use App\Ongkir;
use App\Http\Controllers\Controller;
use App\Keranjang;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckoutController extends Controller
{
    public function index()
    {
        //ambil session user id
        $id_user = Auth::user()->id;

        //ambil produk apa saja yang akan dibeli user dari table keranjang
        $carts = Keranjang::join('users', 'users.id', '=', 'keranjang.user_id')
            ->join('products', 'products.id', '=', 'keranjang.products_id')
            ->select('products.name as nama_produk', 'products.image', 'products.weigth', 'users.name', 'keranjang.*', 'products.price')
            ->where('keranjang.user_id', '=', $id_user)
            ->get();

        //lalu hitung jumlah berat total dari semua produk yang akan di beli
        $berattotal = 0;
        foreach ($carts as $item) {
            $berattotal += ( $item->weigth * $item->qty );
        }

        //lalu ambil id kota si pelanngan
        $city_destination = Alamat::where('user_id', $id_user)->where('primary', 1)->first()->cities_id;
        
        
        //lalu hitung ongkirnya
        $cost = Ongkir::where('cities_id', $city_destination)->first()->ongkir;

        //ambil hasil nya
        $ongkir =  $cost;

        //lalu ambil alamat user untuk ditampilkan di view
        $alamat_user = Alamat::join('cities', 'cities.city_id', '=', 'alamat.cities_id')
            ->join('provinces', 'provinces.province_id', '=', 'cities.province_id')
            ->select('alamat.*', 'cities.title as kota', 'provinces.title as prov')
            ->where('alamat.user_id', $id_user)
            ->where('alamat.primary', 1)
            ->first();
            
        $data  = array(
                'invoice' => 'ALV' . Date('Ymdhi'),
                'keranjangs' => $carts,
                'ongkir' => $ongkir,
                'alamat' => $alamat_user
            );

        return response()->json($data, 200);

    }
}
