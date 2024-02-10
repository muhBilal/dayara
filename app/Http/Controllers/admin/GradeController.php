<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Grade;

class GradeController extends Controller
{
    public function index()
    {

        //Ambil data kategori dari database
        $grades = Grade::all();

        //menampilkan view
        return view('admin.grade.index', compact('grades'));
    }

    //function menampilkan view tambah data
    public function tambah()
    {
        return view('admin.grade.tambah');
    }

    public function store(Request $request)
    {
        //Simpan datab ke database    
        Grade::updateOrCreate([
            'name' => $request->name
        ], []);

        //lalu reireact ke route admin.grade dengan mengirim flashdata(session) berhasil tambah data untuk manampilkan alert succes tambah data
        return redirect()->route('admin.grade')->with('status', 'Berhasil Menambah Grade');
    }

    public function update(Grade $id, Request $request)
    {
        $id->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.grade')->with('status', 'Berhasil Mengubah Grade');
    }

    //function menampilkan form edit
    public function edit(Grade $id)
    {
        return view('admin.grade.edit', [
            'grade' => $id
        ]);
    }

    public function delete($id)
    {
        //hapus data sesuai id dari parameter
        Grade::destroy($id);

        return redirect()->route('admin.grade')->with('status', 'Berhasil Mengahapus Grade');
    }
}
