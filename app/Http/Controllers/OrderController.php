<?php

namespace App\Http\Controllers;

use App\Kedatangan;
use App\KedatanganRack;
use App\PreOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $preOrder = PreOrder::with('fish', 'grade', 'size')
            ->get();
        return view('admin.order.index', compact('preOrder'));
    }

//    public function accept($id)
//    {
//        $preOrder = PreOrder::find($id);
//        if (!$preOrder) {
//            return redirect()->route('admin.order')->with('error', 'Pre Order tidak ditemukan');
//        }
//
//        $preOrder->update(['status' => 'selesai']);
//
//        $preOrder = PreOrder::with('fish', 'grade', 'size')->find($id);
//        $kedatangan = Kedatangan::where('fish_id', $preOrder->fish->id)
//            ->where('grade_id', $preOrder->grade->id)
//            ->where('size_id', $preOrder->size->id)
//            ->orderBy('urutan', 'asc')
//            ->get();
//
//        $remainingOrder = $preOrder->qty;
//
//        foreach ($kedatangan as $item) {
//            $quantityTaken = min($remainingOrder, $item->qty);
//            $item->qty -= $quantityTaken;
//
//            $item->save();
//
//            $remainingOrder -= $quantityTaken;
//
//            if ($remainingOrder <= 0) {
//                break;
//            }
//        }
//
//        return redirect()->route('admin.order')->with('success', 'Pre Order berhasil diupdate');
//    }


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
