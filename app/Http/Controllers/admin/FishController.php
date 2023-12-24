<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Fish;

class FishController extends Controller
{
    public function index()
    {

        //Ambil data kategori dari database
        $fishs = Fish::all();

        //menampilkan view
        return view('admin.fish.index', compact('fishs'));
    }

    //function menampilkan view tambah data
    public function tambah()
    {
        return view('admin.fish.tambah');
    }

    public function store(Request $request)
    {
        //Simpan datab ke database    
        Fish::updateOrCreate([
            'name' => $request->name
        ], []);

        //lalu reireact ke route admin.categories dengan mengirim flashdata(session) berhasil tambah data untuk manampilkan alert succes tambah data
        return redirect()->route('admin.fish')->with('status', 'Berhasil Menambah Ikan');
    }

    public function update(Categories $id, Request $request)
    {
        $id->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.fish')->with('status', 'Berhasil Mengubah Ikan');
    }

    //function menampilkan form edit
    public function edit(Fish $id)
    {
        return view('admin.fish.edit', [
            'fish' => $id
        ]);
    }

    public function delete($id)
    {
        //hapus data sesuai id dari parameter
        Fish::destroy($id);

        return redirect()->route('admin.fish')->with('status', 'Berhasil Mengahapus Ikan');
    }
}
