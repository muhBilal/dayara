<?php

namespace App\Http\Controllers;

use App\Fish;
use App\Grade;
use App\Kedatangan;
use App\KedatanganRack;
use App\PreOrder;
use App\Size;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $preOrder = PreOrder::all();
        return view('admin.order.index', compact('preOrder'));
    }

    public function edit($id) {
        $preOrder = PreOrder::with('detailOrders')->find($id);
        $fish = Fish::all();
        $size = Size::all();
        $grade = Grade::all();
        $fishOrder = $preOrder->detailOrders;

        return view('admin.order.edit', compact('preOrder', 'fish', 'size', 'grade', 'fishOrder'));
    }

    public function scan() {
        return view('admin.order.scan');
    }

    public function checkOrder($id) {
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
                        'name' => $item1->rack->name,
                        'fish_name' => $item1->kedatangan->fish->name,
                        'qty' => $qtyToTake,
                    ];
                    $remainingOrder -= $qtyToTake;
                }
                if ($remainingOrder <= 0) {
                    break;
                }
            }
        }

        $item->status = 'sukses';
        $item->save();

        return response()->json(['message' => 'success'], 200);
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
}
