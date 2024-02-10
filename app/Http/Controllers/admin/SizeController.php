<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Size;

class SizeController extends Controller
{
    public function index()
    {

        //Ambil data kategori dari database
        $sizes = Size::all();

        //menampilkan view
        return view('admin.size.index', compact('sizes'));
    }

    //function menampilkan view tambah data
    public function tambah()
    {
        return view('admin.size.tambah');
    }

    public function store(Request $request)
    {
        //Simpan datab ke database    
        Size::updateOrCreate([
            'name' => $request->name
        ], []);

        //lalu reireact ke route admin.size dengan mengirim flashdata(session) berhasil tambah data untuk manampilkan alert succes tambah data
        return redirect()->route('admin.size')->with('status', 'Berhasil Menambah Size');
    }

    public function update(Size $id, Request $request)
    {
        $id->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.size')->with('status', 'Berhasil Mengubah Size');
    }

    //function menampilkan form edit
    public function edit(Size $id)
    {
        return view('admin.size.edit', [
            'size' => $id
        ]);
    }

    public function delete($id)
    {
        //hapus data sesuai id dari parameter
        Size::destroy($id);

        return redirect()->route('admin.size')->with('status', 'Berhasil Mengahapus Size');
    }
}
