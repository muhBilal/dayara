<?php

namespace App\Http\Controllers\admin;

use App\Detailorder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Warehouse;
use App\KedatanganRack;
use App\Kedatangan;
use App\Fish;
use App\Size;
use App\Grade;
use App\Supplier;
use App\Rack;

use PDF;

class AssignController extends Controller
{
    public function index()
    {
        //ambil data order yang status nya 1 atau masih baru/belum melalukan pembayaran
        $assign = KedatanganRack::with('kedatangan','rack', 'kedatangan.fish')
            ->get();

        return view('admin.assign.index', compact('assign'));
    }

    public function tambah()
    {
        //menampilkan form tambah kategori

        $kedatangan = Kedatangan::with('fish', 'grade', 'size')->whereDate('date', '2023-10-10')->get();
        $rack = Rack::all();
       

        return view('admin.assign.tambah', compact('kedatangan', 'rack'));
    }

    public function store(Request $request)
    {
        KedatanganRack::create($request->all());

        return redirect()->route('admin.assign')->with('status', 'Berhasil Menambah KedatanganRack');
    
    }

    public function edit(KedatanganRack $id)
    {
        //menampilkan form edit
        //dan mengambil data produk sesuai id dari parameter

        return view('admin.assign.edit', [
            'product'       => $id,
            'categories'    => Categories::all(),
        ]);
    }

    public function update(Product $id, Request $request)
    {
        $prod = $id;

        if ($request->file('image')) {

            Storage::delete('public/' . $prod->image);
            $file = $request->file('image')->store('imageproduct', 'public');
            $prod->image = $file;
        }

        $prod->name = $request->name;
        $prod->description = $request->description;
        $prod->price = $request->price;
        $prod->weigth = $request->weigth;
        $prod->panjang = $request->panjang;
        $prod->lebar = $request->lebar;
        $prod->isi = $request->isi;
        $prod->categories_id = $request->categories_id;
        $prod->stok = $request->stok;


        $prod->save();

        return redirect()->route('admin.product')->with('status', 'Berhasil Mengubah Kategori');
    }

    public function delete(Product $id)
    {
        //mengahapus produk
        Storage::delete('public/' . $id->image);
        $id->delete();
        
        return redirect()->route('admin.product')->with('status', 'Berhasil Mengahapus Produk');
    }

    public function cetak(KedatanganRack $id)
    {
        $data = $id;

    	$pdf = PDF::loadview('admin.assign.cetak',['data'=>$id]);
        // return view('admin.assign.cetak', compact('data'));

        // return $pdf;
    	return $pdf->stream('laporan-assign-pdf.pdf');
    }

    public function detail($id)
    {
        //ambil data detail order sesuai id
        $detail_order = Detailorder::join('products', 'products.id', '=', 'detail_order.product_id')
            ->join('order', 'order.id', '=', 'detail_order.order_id')
            ->select('products.name as nama_produk', 'products.image', 'detail_order.*', 'products.price', 'order.*')
            ->where('detail_order.order_id', $id)
            ->get();

        $order = Order::join('users', 'users.id', '=', 'order.user_id')
            ->join('status_order', 'status_order.id', '=', 'order.status_order_id')
            ->select('order.*', 'users.name as nama_pelanggan', 'status_order.name as status')
            ->where('order.id', $id)
            ->first();

        return view('admin.transaksi.detail', [
            'detail' => $detail_order,
            'order'  => $order
        ]);
    }

    public function perludicek()
    {
        //ambil data order yang status nya 2 atau belum di cek / sudah bayar
        $orderbaru = Order::join('status_order', 'status_order.id', '=', 'order.status_order_id')
            ->join('users', 'users.id', '=', 'order.user_id')
            ->select('order.*', 'status_order.name', 'users.name as nama_pemesan')
            ->where('order.status_order_id', 2)
            ->get();

        return view('admin.transaksi.perludicek', compact('orderbaru'));
    }

    public function perludikirim()
    {
        //ambil data order yang status nya 3 sudah dicek dan perlu dikirim(input no resi)
        $orderbaru = Order::join('status_order', 'status_order.id', '=', 'order.status_order_id')
            ->join('users', 'users.id', '=', 'order.user_id')
            ->select('order.*', 'status_order.name', 'users.name as nama_pemesan')
            ->where('order.status_order_id', 3)
            ->get();

        return view('admin.transaksi.perludikirim', compact('orderbaru'));
    }

    public function selesai()
    {
        //ambil data order yang status nya 5 barang sudah diterima pelangan
        $orderbaru = Order::join('status_order', 'status_order.id', '=', 'order.status_order_id')
            ->join('users', 'users.id', '=', 'order.user_id')
            ->select('order.*', 'status_order.name', 'users.name as nama_pemesan')
            ->where('order.status_order_id', 5)
            ->get();

        return view('admin.transaksi.selesai', compact('orderbaru'));
    }

    public function dibatalkan()
    {
        //ambil data order yang status nya 6 dibatalkan pelanngan
        $orderbaru = Order::join('status_order', 'status_order.id', '=', 'order.status_order_id')
            ->join('users', 'users.id', '=', 'order.user_id')
            ->select('order.*', 'status_order.name', 'users.name as nama_pemesan')
            ->where('order.status_order_id', 6)
            ->get();

        return view('admin.transaksi.dibatalkan', compact('orderbaru'));
    }

    public function dikirim()
    {
        //ambil data order yang status nya 4 atau sedang dikirim
        $orderbaru = Order::join('status_order', 'status_order.id', '=', 'order.status_order_id')
            ->join('users', 'users.id', '=', 'order.user_id')
            ->select('order.*', 'status_order.name', 'users.name as nama_pemesan')
            ->where('order.status_order_id', 4)
            ->get();

        return view('admin.transaksi.dikirim', compact('orderbaru'));
    }

    public function konfirmasi(Order $id)
    {
        //function ini untuk mengkonfirmasi bahwa pelanngan sudah melakukan pembayaran
        $id->update([
            'status_order_id' => 3
        ]);

        $order = Detailorder::where('order_id', $id)->get();

        foreach ($order as $item) {
            Product::where('id', $item->product_id)->decrement('stok', $item->qty);
        }
        return redirect()->route('admin.transaksi.perludikirim')->with('status', 'Berhasil Mengonfirmasi Pembayaran Pesanan');
    }

    public function inputresi($id, Request $request)
    {
        //funtion untuk menginput no resi pesanan
        Order::where('id', $id)
            ->update([
                'no_resi'           => $request->no_resi,
                'status_order_id'   => 4
            ]);

        return redirect()->route('admin.transaksi.perludikirim')->with('status', 'Berhasil Menginput No Resi');
    }
}
