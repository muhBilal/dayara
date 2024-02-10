<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Supplier;

class SupplierController extends Controller
{
    public function index()
    {

        //Ambil data kategori dari database
        $suppliers = Supplier::all();

        //menampilkan view
        return view('admin.supplier.index', compact('suppliers'));
    }

    //function menampilkan view tambah data
    public function tambah()
    {
        return view('admin.supplier.tambah');
    }

    public function store(Request $request)
    {
        //Simpan datab ke database    
        Supplier::updateOrCreate([
            'name' => $request->name
        ], []);

        //lalu reireact ke route admin.supplier dengan mengirim flashdata(session) berhasil tambah data untuk manampilkan alert succes tambah data
        return redirect()->route('admin.supplier')->with('status', 'Berhasil Menambah Supplier');
    }

    public function update(Supplier $id, Request $request)
    {
        $id->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.supplier')->with('status', 'Berhasil Mengubah Supplier');
    }

    //function menampilkan form edit
    public function edit(Supplier $id)
    {
        return view('admin.supplier.edit', [
            'supplier' => $id
        ]);
    }

    public function delete($id)
    {
        //hapus data sesuai id dari parameter
        Supplier::destroy($id);

        return redirect()->route('admin.supplier')->with('status', 'Berhasil Mengahapus Supplier');
    }
}
