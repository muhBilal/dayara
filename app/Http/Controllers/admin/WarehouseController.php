<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {

        //Ambil data kategori dari database
        $warehouses = Warehouse::all();

        //menampilkan view
        return view('admin.warehouse.index', compact('warehouses'));
    }

    //function menampilkan view tambah data
    public function tambah()
    {
        return view('admin.warehouse.tambah');
    }

    public function store(Request $request)
    {
        //Simpan datab ke database    
        Warehouse::updateOrCreate([
            'name' => $request->name
        ], []);

        //lalu reireact ke route admin.warehouse dengan mengirim flashdata(session) berhasil tambah data untuk manampilkan alert succes tambah data
        return redirect()->route('admin.warehouse')->with('status', 'Berhasil Menambah Warehouse');
    }

    public function update(Warehouse $id, Request $request)
    {
        $id->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.warehouse')->with('status', 'Berhasil Mengubah Warehouse');
    }

    //function menampilkan form edit
    public function edit(Warehouse $id)
    {
        return view('admin.warehouse.edit', [
            'warehouse' => $id
        ]);
    }

    public function delete($id)
    {
        //hapus data sesuai id dari parameter
        Warehouse::destroy($id);

        return redirect()->route('admin.warehouse')->with('status', 'Berhasil Mengahapus Warehouse');
    }
}
