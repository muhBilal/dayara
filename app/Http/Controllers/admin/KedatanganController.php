<?php

namespace App\Http\Controllers\admin;

use App\DetailOrder;
use App\DetailTransaction;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Warehouse;
use App\Kedatangan;
use App\Fish;
use App\Size;
use App\Grade;
use App\KedatanganRack;
use App\PreOrder;
use App\Rack;
use App\Supplier;

use PDF;

class KedatanganController extends Controller
{
    public function index()
    {
        //ambil data order yang status nya 1 atau masih baru/belum melalukan pembayaran
        $kedatangan = Kedatangan::with('fish', 'grade', 'warehouse', 'size', 'kedatanganRack')
            ->where('qty', '>', 0)
            ->whereDoesntHave('kedatanganRack')
            ->orderBy('id', 'asc')
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

        // $kontainer = $request->kontainer;
        // $urutan = $request->urutan;
        $kontainer = $urutan = 1;
        
        $date = date_create($request->date);
        $tanggal = date_format($date,"dmY");
        $code = $kontainer."/".$urutan."/".$warehouse->name."/SUP".$request->supplier_id."/".$tanggal;
        Kedatangan::updateOrCreate([
            'code' => $code,
            'date' => $request->date,
            'supplier_id' => $request->supplier_id,
            'warehouse_id' => $request->warehouse_id,
            'urutan' => $urutan,
            'fish_id' => $request->fish_id,
            'size_id' => $request->size_id,
            'grade_id' => $request->grade_id,
            'qty' => $request->qty,
            'kontainer' => $kontainer
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

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Kedatangan::with('kedatanganRack')->findOrFail($id);
            $item->kedatanganRack()->delete();
            $item->delete();
            DB::commit();
            return redirect()->route('admin.kedatangan')->with('status', 'Berhasil Menghapus Produk');
        } catch (\Exception $e) {
            return redirect()->route('admin.kedatangan')->with('error', 'Gagal Menghapus Produk');
        }
    }


    public function cetak(Kedatangan $id)
    {
        $url = url()->previous();
        if($url === "http://127.0.0.1:8000/admin/kedatangan" || $url === "http://127.0.0.1:8000/admin/assign"){
            $pdf = PDF::loadview('admin.kedatangan.cetak',['data'=>$id]);
            return $pdf->stream('laporan-kedatangan-pdf.pdf');
        }else{
            $cookiePO = isset($_COOKIE['poID']) ? $_COOKIE['poID'] : null;
            $cookieRack = isset($_COOKIE['rack']) ? $_COOKIE['rack'] : null;

            if(is_null($cookiePO) || is_null($cookieRack)){
                return response()->json(['message' => 'failed']);
            }

            $kedatanganRack = KedatanganRack::with('rack')->where('kedatangan_id', $id->id)->first();
            // return response()->json(['kedatanganRack' => $kedatanganRack], 200);

            if(!$kedatanganRack){
                return response()->json(['message' => 'empty']);
            }

            if($cookieRack !== $kedatanganRack->rack['name']){
                return response()->json(['message' => 'failed']);
            }

            $detailOrder = DetailOrder::where('order_id', $cookiePO)->where('fish_id', $id->fish_id)->where('fish_size_id', $id->size_id)->where('fish_grade_id', $id->grade_id)->first();
            // return response()->json(['order' => $detailOrder, 'kedatanganRack' => $kedatanganRack], 200);
            if($detailOrder){
                return $this->scanOrder($detailOrder, $id);
            }else{
                return redirect()->route('admin.kedatangan');
            }
        }
    }

    function scanOrder($detailOrder, $kedatangan) {
        // ambil data cookie
        $cookieQty = isset($_COOKIE['qty']) ? $_COOKIE['qty'] : null;
        $cookieRack = isset($_COOKIE['rack']) ? $_COOKIE['rack'] : null;
        $qtyOrder = intval($cookieQty);

        // cek cookie
        if(is_null($cookieQty) || is_null($cookieRack)){
            return response()->json(['message' => 'failed']);
        }

        // get po
        $po = PreOrder::find($detailOrder->order_id);

        // cek jika status order
        if($detailOrder->status == 'sukses'){
            return response()->json(['message' => 'duplicate'], 200);
        }

        // substraction
        $kedatangan->qty -= $qtyOrder;
        $kedatangan->save();

        // penghapusan / pengosongan rack jika kedatangan == 0
        if($kedatangan->qty == 0){
            KedatanganRack::where('kedatangan_id', $kedatangan->id)->delete();
        }

        // pembuatan data detail transaction untuk menyimpan transaksi
        DetailTransaction::create([
            'fish_id' => $detailOrder->fish_id,
            'preorder_id' => $po->id,
            'detail_order_id' => $detailOrder->id,
            'qty' => $qtyOrder,
            'rack' => $cookieRack,
            'status' => 'sukses'
        ]);

        // get all detail transaction
        $allDetailTransaction = DetailTransaction::where('preorder_id', $po->id)->get();
        $totalQtyDetailTransaction = $allDetailTransaction->sum('qty');

        // get all detail order
        $allDetailOrders = DetailOrder::where('order_id', $po->id)->get();

        // calculate all qty order detail
        $orderDetailQty = 0;
        foreach($allDetailOrders as $orderItem){
            $orderDetailQty += $orderItem->qty;
        }

        // check if total qty detail transaction is bigger than total qty order detail
        if($totalQtyDetailTransaction >= $orderDetailQty){
            foreach($allDetailOrders as $orderItem){
                $orderItem->status = 'sukses';
                $orderItem->save();
            }
        }

        // sum success detail order
        $success = 0;
        foreach($allDetailOrders as $orderItem){
            if($orderItem->status == 'sukses'){
                $success += 1;
            }
        }

        // change po to success
        if($success == count($allDetailOrders)) {
            $po->status = 'sukses';
            $po->save();
        }

        return response()->json(['message' => 'success'], 200);
    }

    public function detail($id)
    {
        //ambil data detail order sesuai id
        $detail_order = DetailOrder::join('products', 'products.id', '=', 'detail_order.product_id')
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

        $order = DetailOrder::where('order_id', $id)->get();

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
