<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Province;
use App\City;
use App\Alamat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlamatController extends Controller
{
    public function index()
    {
        //ambil session id user
        $id_user = Auth::user()->id;
        //ambil data alamat
        $cekAlamat = Alamat::where('user_id', $id_user)
            ->count();
        //cek jika user sudah mengatur alamat maka jalankan ini
        // if ($cekAlamat > 0) {
            $data = DB::table('alamat')
                ->join('cities', 'cities.city_id', '=', 'alamat.cities_id')
                ->join('provinces', 'provinces.province_id', '=', 'cities.province_id')
                ->select('provinces.title as prov', 'cities.title as kota', 'alamat.*')
                ->where('alamat.user_id', $id_user)
                ->get();
            // }

        //jika belum maka tampilkan form untuk mengatur alamat
        return response()->json($data, 200);

    }

    public function ubah($id)
    {
        //menampilkan form edit alamat
        $data['province'] = Province::all();
        $data['id'] = $id;

        return view('user.ubahalamat', $data);
    }

    public function update($id, Request $request)
    {
        //mengupdate alamat
        $alamat = Alamat::where('id', $id)
            ->update([
                'penerima'  => $request->penerima,
                'cities_id' => $request->cities_id,
                'detail' => $request->detail
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil diubah'
        ]);    
    }
    
    public function primary($id)
    {
        //mengupdate alamat
        $updateZero = Alamat::where('primary', 1)->where('user_id', Auth::user()->id)->update([
                'primary' => 0
            ]);
        $alamat = Alamat::where('id', $id)
            ->update([
                'primary' => 1
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil merubah alamat utama'
        ]);    
    }
    
    public function getProvince()
    {
        //mengambil data kota/kab
        $data = Province::all();
        return response()->json($data, 200);
    }
    

    public function getCity($id)
    {
        //mengambil data kota/kab
        $data = City::where('province_id', $id)->get();
        return response()->json($data, 200);

    }
    public function simpan(Request $request)
    {
        //menyimpan alamat user
        Alamat::create([
            'penerima'  => $request->penerima,
            'cities_id' => $request->cities_id,
            'detail'    => $request->detail,
            'user_id'   => Auth::user()->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil ditambahkan'
        ]);    
        
    }
}
