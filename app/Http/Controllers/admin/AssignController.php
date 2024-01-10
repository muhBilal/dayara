<?php

namespace App\Http\Controllers\admin;

use App\Detailorder;
use App\Http\Controllers\Controller;
use App\Kedatangan;
use App\KedatanganRack;
use App\Rack;
use Illuminate\Http\Request;
use PDF;

class AssignController extends Controller
{
    public function index()
    {
        //ambil data order yang status nya 1 atau masih baru/belum melalukan pembayaran
        $assign = KedatanganRack::with('kedatangan', 'rack', 'kedatangan.fish', 'kedatangan.grade', 'kedatangan.size')
            ->get();


        return view('admin.assign.index', compact('assign'));
    }

    function getRack(Request $request)
    {
        $kedatangan_rack = KedatanganRack::all();
        $specificRackIds = $kedatangan_rack->pluck('rack_id')->toArray();
        $rack = Rack::whereNotIn('id', $specificRackIds)->where('name', 'like', '%' . $request->q . '%')->get();

        return response()->json($rack);
    }

    public function tambah()
    {
        $kedatangan_rack = KedatanganRack::all();
        $specificRack = $kedatangan_rack->pluck('rack_id', 'kedatangan_id')->toArray();

        $kedatangan = Kedatangan::with('fish', 'grade', 'size')
            ->whereNotIn('id', array_keys($specificRack))
            ->get();

        $rack = Rack::whereNotIn('id', array_values($specificRack))->get();

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

        $kedatangan = Kedatangan::with('fish', 'grade', 'size')->get();

        // Pisahkan tanggal dari waktu
        $tanggal = explode(' ', $id->created_at)[0]; // Ambil bagian tanggal saja

        // Ubah format tanggal agar sesuai dengan format yang diterima oleh elemen input tanggal
        $format_tanggal = date('Y-m-d', strtotime($tanggal));
        $id->tanggal = $format_tanggal;

        // dd($id);

        return view('admin.assign.edit', [
            'kedatangan' => $kedatangan,
            'item' => $id,
        ]);
    }

    public function update(KedatanganRack $id, Request $request)
    {
        $data = $request->validate([
            'date' => 'required', // Sesuaikan dengan aturan validasi yang diinginkan
            'kedatangan_id' => 'required',
            'rack_id' => 'required',
        ]);

        // Pastikan data yang diambil sesuai dengan nama field yang diharapkan di tabel
        $id->created_at = $data['date'];
        $id->kedatangan_id = $data['kedatangan_id'];
        $id->rack_id = $data['rack_id'];

        // Pastikan perubahan disimpan
        $id->save();

        // Jika ingin melihat nilai variabel sebelum redirect, bisa menggunakan dd()
        // dd($data, $id);

        return redirect()->route('admin.assign')->with('status', 'Berhasil Mengubah Kedatangan Rack');
    }

    public function delete($id)
    {
        $item = KedatanganRack::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.assign')->with('status', 'Berhasil Mengahapus Produk');
    }

    public function filter(Request $request)
    {
        $date = $request->date;
        $kedatangan_rack = KedatanganRack::all();
        $specificRack = $kedatangan_rack->pluck('rack_id', 'kedatangan_id')->toArray();

        $kedatangan = Kedatangan::with('fish', 'grade', 'size')
            ->whereDate('date', $date)
            ->whereNotIn('id', array_keys($specificRack))
            ->get();
        $rack = Rack::whereNotIn('id', array_values($specificRack))->get();


        return view('admin.assign.tambah', compact('kedatangan', 'rack', 'date'));
    }

    public function cetak(KedatanganRack $id)
    {
        $data = $id;

        $pdf = PDF::loadview('admin.assign.cetak', ['data' => $id]);
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
            'order' => $order
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
                'no_resi' => $request->no_resi,
                'status_order_id' => 4
            ]);

        return redirect()->route('admin.transaksi.perludikirim')->with('status', 'Berhasil Menginput No Resi');
    }
}
