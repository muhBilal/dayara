<?php

namespace App\Http\Controllers\Api;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Alamat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Keranjang;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Auth;

class KeranjangController extends Controller
{

    public function index()
    {

        $id_user = Auth::user()->id;
        $keranjangs = Keranjang::join('users', 'users.id', '=', 'keranjang.user_id')
            ->join('products', 'products.id', '=', 'keranjang.products_id')
            ->select('products.name as nama_produk', 'products.image', 'users.name', 'keranjang.*', 'products.price')
            ->where('keranjang.user_id', '=', $id_user)
            ->get();

        $cekalamat = Alamat::where('user_id', $id_user)->where('primary', 1)->count();
        $data = [
            'carts' => $keranjangs,
            'address'  => $cekalamat
        ];
        return response()->json($data, 200);
    }

    public function simpan(Request $request)
    {
        $id_user = Auth::user()->id;
        $keranjangData = Keranjang::where('products_id', '=', $request->products_id)->where('user_id', '=', $id_user)->first();
        $qtyCount = Keranjang::where('products_id', '=', $request->products_id)->where('user_id', '=', $id_user)->count();
        if($qtyCount > 0){
            $keranjang = Keranjang::findOrFail($keranjangData->id);
            $keranjang->qty = $request->qty+$keranjangData->qty;
            $keranjang->save();
        }else{
            Keranjang::create([
                'user_id' => $id_user,
                'products_id' => $request->products_id,
                'qty' => $request->qty
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan di Keranjang'
        ]);
    }

    /**
     * I dont know, it seem never used
     */
    // function show_Names($n, $m)
    // {
    //     return ("The name is $n and email is $m, thank you");
    // }

    public function update($id, Request $request)
    {
        $alamat = Keranjang::where('id', $id)
            ->update([
                'qty' => $request->qty
                ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate'
        ]);    
    
    }
    

    public function delete($id)
    {

        Keranjang::destroy($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dihapus'
        ]);
    }
}
