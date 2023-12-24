<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Rack;

class RackController extends Controller
{
    public function index()
    {

        //Ambil data kategori dari database
        $racks = Rack::all();

        //menampilkan view
        return view('admin.rack.index', compact('racks'));
    }

    //function menampilkan view tambah data
    public function tambah()
    {
        return view('admin.rack.tambah');
    }

    public function store(Request $request)
    {
        //Simpan datab ke database    
        Rack::updateOrCreate([
            'name' => $request->name
        ], []);

        //lalu reireact ke route admin.categories dengan mengirim flashdata(session) berhasil tambah data untuk manampilkan alert succes tambah data
        return redirect()->route('admin.rack')->with('status', 'Berhasil Menambah Rack');
    }

    public function update(Categories $id, Request $request)
    {
        $id->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.rack')->with('status', 'Berhasil Mengubah Rack');
    }

    //function menampilkan form edit
    public function edit(Rack $id)
    {
        return view('admin.rack.edit', [
            'categorie' => $id
        ]);
    }

    public function delete($id)
    {
        //hapus data sesuai id dari parameter
        Rack::destroy($id);

        return redirect()->route('admin.rack')->with('status', 'Berhasil Mengahapus Rack');
    }
}
