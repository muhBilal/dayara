<?php

namespace App\Http\Controllers;

use App\DetailOrder;
use App\DetailTransaction;
use App\Kedatangan;
use App\KedatanganRack;
use App\PreOrder;

class OrderController extends Controller
{
    public function index()
    {
        $preOrders = PreOrder::with('detailOrders')->get();
        foreach ($preOrders as $preOrder) {
            $allSuccess = true;
            foreach ($preOrder->detailOrders as $detailOrder) {
                if ($detailOrder->status !== 'sukses') {
                    $allSuccess = false;
                    break;
                }
            }

            if ($allSuccess) {
                $preOrder->status = 'selesai';
                $preOrder->save();
            }
        }

        return view('admin.order.index', compact('preOrders'));
    }

    public function detail($id)
    {
        $item = PreOrder::with('detailOrders')->find($id);
        $fish = $item->detailOrders;
        $rackInfo = [];
        $custInfo = [
            'name' => $item->name,
            'vehicle' => $item->vehicle,
        ];
        foreach ($item->detailOrders as $items){
            $kedatanganRak = KedatanganRack::with('kedatangan', 'rack', 'kedatangan.fish')
                ->whereHas('kedatangan', function ($query) use ($items) {
                    $query->where('grade_id', $items->fish_grade_id)
                        ->where('size_id', $items->fish_size_id)
                        ->where('fish_id', $items->fish_id);
                })
                ->orderBy('created_at', 'asc')
                ->get();

            $remainingOrder = $items->qty;
            
            foreach ($kedatanganRak as $item1) {
                $qtyOnRack = $item1->kedatangan->qty;
                if ($remainingOrder > 0 && $qtyOnRack > 0) {
                    $qtyToTake = min($remainingOrder, $qtyOnRack);
                    $rackInfo[] = [
                        'id' => $item1->kedatangan->id,
                        'name' => $item1->rack->name,
                        'fish_id' => $item1->kedatangan->fish->id,
                        'fish_size_id' => $item1->kedatangan->size->id,
                        'fish_grade_id' => $item1->kedatangan->grade->id,
                        'fish_name' => $item1->kedatangan->fish->name,
                        'fish_size' => $item1->kedatangan->grade->name,
                        'fish_grade' => $item1->kedatangan->size->name,
                        'qty' => $qtyToTake,
                        'poID' => $item->id,
                    ];
                    $remainingOrder -= $qtyToTake;
                }
                if ($remainingOrder <= 0) {
                    break;
                }
            }

            foreach($fish as $detail_order){
                foreach($rackInfo as &$rack){
                    if ($rack['fish_id'] === $detail_order->fish_id && $rack['fish_size_id'] === $detail_order->fish_size_id && $rack['fish_grade_id'] === $detail_order->fish_grade_id) {
                        $rack['created_at'] = $detail_order->created_at;
                        $detailTransaction = DetailTransaction::where('preorder_id', $detail_order->order_id)->where('fish_id', $detail_order->fish_id)->where('detail_order_id', $detail_order->id)->where('qty', $rack['qty'])->first();
                        if($detailTransaction){
                            $rack['status'] = $detailTransaction['status'];
                            $rack['name'] = $detailTransaction['rack'];
                        }else{
                            $rack['status'] = 'menunggu';
                        }
                    }
                }
            }
        }

        return view('admin.order.detail', compact('custInfo', 'item', 'rackInfo', 'fish'));
    }

    public function scan()
    {
        return view('admin.order.scan');
    }

    public function checkOrder($id)
    {
        $item = DetailOrder::find($id);
        $getAllKedatangan = Kedatangan::where('fish_id', $item->fish_id)->where('size_id', $item->fish_size_id)->where('grade_id', $item->fish_grade_id)->orderBy('date', 'asc')->get();
        $po = PreOrder::find($item->order_id);

        if($item->status == 'sukses'){
            return response()->json(['message' => 'duplicate'], 200);
        }

        if(count($getAllKedatangan) > 0){
            $totalQty = $getAllKedatangan->sum('qty');
            $qtyCurrent = $item->qty;
            if($totalQty > $item->qty){
                foreach($getAllKedatangan as $kedatangan){
                    if($qtyCurrent != 0){
                        if ($qtyCurrent >= $kedatangan->qty) {
                            $qtyCurrent -= $kedatangan->qty;
                            $kedatangan->qty = 0;
                        } else {
                            $kedatangan->qty -= $qtyCurrent;
                            $qtyCurrent = 0;
                        }
                        $kedatangan->save();
                    }else{
                        break;
                    }
                }
            }else {
                return response()->json(['message' => 'limit'], 200);
            }

            $item->status = 'sukses';
            $item->save();

            $allPoItems = DetailOrder::where('order_id', $po->id)->get();

            $success = 0;
            foreach($allPoItems as $poItem){
                if($poItem->status == 'sukses'){
                    $success += 1;
                }
            }

            if($success == count($allPoItems)) {
                $po->status = 'sukses';
                $po->save();
            }

            return response()->json(['message' => 'success'], 200);
        }else{
            return response()->json(['message' => 'failed'], 500);
        }
    }

    public function accept($id)
    {
        $preOrder = PreOrder::find($id);
        if (!$preOrder) {
            return redirect()->route('admin.order')->with('error', 'Pre Order tidak ditemukan');
        }

        $preOrder->update(['status' => 'selesai']);

        $preOrder = PreOrder::with('fish', 'grade', 'size')->find($id);
        $kedatangan = Kedatangan::where('fish_id', $preOrder->fish->id)
            ->where('grade_id', $preOrder->grade->id)
            ->where('size_id', $preOrder->size->id)
            ->orderBy('urutan', 'asc')
            ->get();

        $remainingOrder = $preOrder->qty;

        foreach ($kedatangan as $item) {
            $quantityTaken = min($remainingOrder, $item->qty);
            $item->qty -= $quantityTaken;

            $item->save();

            $remainingOrder -= $quantityTaken;

            if ($remainingOrder <= 0) {
                break;
            }
        }

        foreach ($kedatangan as $item) {
            if ($item->qty <= 0) {
                KedatanganRack::where('kedatangan_id', $item->id)->delete();
                $item->delete();
            }
        }

        return redirect()->route('admin.order')->with('success', 'Pre Order berhasil diupdate');
    }

    public function reject($id)
    {
        $preOrder = PreOrder::find($id);
        $preOrder->update([
            'status' => 'ditolak'
        ]);
        return redirect()->route('admin.order')->with('success', 'Pre Order berhasil ditolak');
    }

    public function struk($id)
    {
        $order = PreOrder::with('detailOrders')->find($id);
        $pdf = \PDF::loadview('admin.order.struk', compact('order'));
        return $pdf->stream('struk-preorder.pdf');
//        return view('admin.order.struk', compact('order'));
    }

}
