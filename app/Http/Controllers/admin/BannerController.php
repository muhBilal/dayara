<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        //membawa data produk yang di join dengan table kategori
        $banners = Banner::all();

        return view('admin.banner.index', compact('banners'));
    }

    public function tambah()
    {
        return view('admin.banner.tambah');
    }

    public function store(Request $request)
    {
        if ($request->file('image')) {
            //simpan foto produk yang di upload ke direkteri public/storage/imageproduct
            $file = $request->file('image')->store('imagebanner', 'public');

            Banner::create([
                'name'          => $request->name,
                'description'   => $request->description,
                'image'         => $file

            ]);

            return redirect()->route('admin.banner')->with('status', 'Berhasil Menambah Banner Baru');
        }
    }

    public function edit(Banner $id)
    {
        //menampilkan form edit
        //dan mengambil data produk sesuai id dari parameter

        return view('admin.banner.edit', [
            'banner'       => $id
        ]);
    }

    public function update(Banner $id, Request $request)
    {
        $prod = $id;

        if ($request->file('image')) {

            Storage::delete('public/' . $prod->image);
            $file = $request->file('image')->store('imagebanner', 'public');
            $prod->image = $file;
        }

        $prod->name = $request->name;
        $prod->description = $request->description;

        $prod->save();

        return redirect()->route('admin.banner')->with('status', 'Berhasil Mengubah Banner');
    }

    public function delete(Banner $id)
    {
        //mengahapus produk
        Storage::delete('public/' . $id->image);
        $id->delete();

        return redirect()->route('admin.banner')->with('status', 'Berhasil Mengahapus Banner');
    }
}
