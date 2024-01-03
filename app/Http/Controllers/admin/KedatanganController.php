<?php

namespace App\Http\Controllers\admin;

use App\Detailorder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Warehouse;
use App\Kedatangan;
use App\Fish;
use App\Size;
use App\Grade;
use App\Supplier;

use PDF;

class KedatanganController extends Controller
{
    public function index()
    {
        //ambil data order yang status nya 1 atau masih baru/belum melalukan pembayaran
        $kedatangan = Kedatangan::with('fish','grade','warehouse','size')
            ->get();

        return view('admin.kedatangan.index', compact('kedatangan'));
    }

    public function tambah()
    {
        //menampilkan form tambah kategori

        $warehouse = Warehouse::all();
        $fish = Fish::all();
        $size = Size::all();
        $grade = Grade::all();
        $supplier = Supplier::all();

        return view('admin.kedatangan.tambah', compact('warehouse', 'fish', 'size', 'grade', 'supplier'));
    }

    public function store(Request $request)
    {
        $grade = Grade::find($request->grade_id);
        $warehouse = Warehouse::find($request->warehouse_id);
        // $suplier = Warehouse::find($request->supplier_id);

        $kontainer = $request->kontainer;
        $urutan = $request->urutan;
        $date=date_create($request->date);
        $tanggal = date_format($date,"dmY");
        $code = $kontainer."/".$urutan."/".$warehouse->name."/SUP".$request->supplier_id."/".$tanggal;
        Kedatangan::updateOrCreate([
            'code' => $code,
            'date' => $request->date,
            'supplier_id' => $request->supplier_id,
            'warehouse_id' => $request->warehouse_id,
            'urutan' => $request->urutan,
            'fish_id' => $request->fish_id,
            'size_id' => $request->size_id,
            'grade_id' => $request->grade_id,
            'qty' => $request->qty,
            'kontainer' => $request->kontainer
        ], []);

        return redirect()->route('admin.kedatangan')->with('status', 'Berhasil Menambah Kedatangan');
    
    }

    public function edit(Kedatangan $id)
    {
        //menampilkan form edit
        //dan mengambil data produk sesuai id dari parameter

        $item = $id;

        $warehouse = Warehouse::all();
        $fish = Fish::all();
        $size = Size::all();
        $grade = Grade::all();
        $supplier = Supplier::all();

        return view('admin.kedatangan.edit', compact('warehouse', 'fish', 'size', 'grade', 'supplier', 'item'));
    }

    public function update(Request $request, Kedatangan $id)
    {
        $data = $request->all();

        $id->date = $data['date'];
        $id->kontainer = $data['kontainer'];
        $id->urutan = $data['urutan'];
        $id->warehouse_id = $data['warehouse_id'];
        $id->supplier_id = $data['supplier_id'];
        $id->fish_id = $data['fish_id'];
        $id->size_id = $data['size_id'];
        $id->grade_id = $data['grade_id'];
        $id->qty = $data['qty'];

        $id->save();

        return redirect()->route('admin.kedatangan')->with('status', 'Berhasil Mengubah Kedatangan');
    }

    public function delete(Product $id)
    {
        //mengahapus produk
        Storage::delete('public/' . $id->image);
        $id->delete();

        return redirect()->route('admin.product')->with('status', 'Berhasil Mengahapus Produk');
    }

    public function cetak(Kedatangan $id)
    {
        $data = $id;

    	$pdf = PDF::loadview('admin.kedatangan.cetak',['data'=>$id]);
        // return view('admin.kedatangan.cetak', compact('data'));

        // return $pdf;
    	return $pdf->stream('laporan-kedatangan-pdf.pdf');
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
