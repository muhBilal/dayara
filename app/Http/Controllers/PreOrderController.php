<?php

namespace App\Http\Controllers;

use App\DetailOrder;
use App\Fish;
use App\Grade;
use App\KedatanganRack;
use App\PreOrder;
use App\Size;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreOrderController extends Controller
{
    public function index()
    {
        $preOrder = PreOrder::all();
        return view('admin.preOrder.index', compact('preOrder'));
    }

    public function create()
    {
        $fish = Fish::all();
        $size = Size::all();
        $grade = Grade::all();
        $supplier = Supplier::all();
        return view('admin.preOrder.tambah', compact('fish', 'size', 'grade', 'supplier'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $mainFormData = $request->only(['fish_id', 'size_id', 'grade_id', 'qty']);
            $additionalFormsData = [];
            if ($request->filled('counter')) {
                for ($i = 2; $i <= $request->input('counter'); $i++) {
                    $additionalFormsData[] = [
                        'fish_id' => $request->input("fish_id_$i"),
                        'size_id' => $request->input("size_id_$i"),
                        'grade_id' => $request->input("grade_id_$i"),
                        'qty' => $request->input("qty_$i"),
                    ];
                }
            }

            $items = array_merge([$mainFormData], $additionalFormsData);

            $custInfo = [
                'name' => $request->name,
                'vehicle' => $request->vehicle,
            ];

            $order = PreOrder::create($custInfo);

            $rackInfo = [];
            $idOrder = [];
            foreach ($items as $item) {
                $detailOrder = new DetailOrder([
                    'fish_id' => $item['fish_id'],
                    'fish_size_id' => $item['size_id'],
                    'fish_grade_id' => $item['grade_id'],
                    'qty' => $item['qty'],
                ]);
                $order->detailOrders()->save($detailOrder);
                $idOrder[] = $detailOrder->id;
                $kedatanganRak = KedatanganRack::with('kedatangan', 'rack', 'kedatangan.fish')
                    ->whereHas('kedatangan', function ($query) use ($detailOrder) {
                        $query->where('grade_id', $detailOrder->fish_grade_id)
                            ->where('size_id', $detailOrder->fish_size_id)
                            ->where('fish_id', $detailOrder->fish_id);
                    })
                    ->orderBy('created_at', 'asc')
                    ->get();

                $remainingOrder = $detailOrder->qty;

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
            $preOrder = [];
            foreach ($idOrder as $item) {
                $preOrder[] = DetailOrder::with('fish', 'grade', 'size')->find($item);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        $pdf = \PDF::loadView('admin.preOrder.cetak', compact('custInfo', 'items', 'rackInfo', 'preOrder'));
        return $pdf->stream('preOrder.pdf');
    }

    public function show(PreOrder $po)
    {
        //
    }

    public function edit($id)
    {
        $preOrder = PreOrder::find($id);
        $fish = Fish::all();
        $size = Size::all();
        $grade = Grade::all();
        return view('admin.preOrder.edit', compact('preOrder', 'fish', 'size', 'grade'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fish_id' => 'required',
            'size_id' => 'required',
            'grade_id' => 'required',
            'qty' => 'required',
        ]);

        $post = PreOrder::find($id);

        $post->update([
            'fish_id' => $request->fish_id,
            'fish_size_id' => $request->size_id,
            'fish_grade_id' => $request->grade_id,
            'cust_name' => $request->name,
            'cust_vehicle' => $request->vehicle,
            'qty' => $request->qty,
        ]);

        return redirect()->route('admin.preOrder')->with('success', 'Pre Order berhasil diupdate');
    }

    public function destroy($id)
    {
        try {
            $preOrder = PreOrder::find($id);
            $preOrder->delete();
            $preOrder->detailOrders()->delete();
            return redirect()->route('admin.preOrder')->with('success', 'Pre Order berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.preOrder')->with('error', 'Pre Order gagal dihapus');
        }
    }

    // public function print($id)
    // {
    //     $preOrder = PreOrder::with('fish', 'grade', 'size')->find($id);

    //     $kedatangan = Kedatangan::where('fish_id', $preOrder->fish->id)
    //         ->where('grade_id', $preOrder->grade->id)
    //         ->where('size_id', $preOrder->size->id)
    //         ->orderBy('urutan', 'asc')
    //         ->get();

    //     $remainingOrder = $preOrder->qty;
    //     $rackInfo = [];

    //     foreach ($kedatangan as $item) {
    //         $quantityTaken = min($remainingOrder, $item->qty);
    //         $rackDetails = KedatanganRack::with('rack')
    //             ->where('kedatangan_id', $item->id)
    //             ->get();

    //         foreach ($rackDetails as $rackItem) {
    //             $rackInfo[] = [
    //                 'name' => $rackItem->rack->name,
    //                 'qty' => $quantityTaken
    //             ];
    //         }

    //         $remainingOrder -= $quantityTaken;

    //         if ($remainingOrder <= 0) {
    //             break;
    //         }
    //     }

    //     $pdf = \PDF::loadView('admin.preOrder.cetak', compact('preOrder', 'rackInfo'));
    //     return $pdf->stream('preOrder.pdf');
    // }


    public function print($id)
    {
        $preOrder = PreOrder::with('fish', 'grade', 'size')->find($id);
        $kedatanganRak = KedatanganRack::with('kedatangan', 'rack')
            ->whereHas('kedatangan', function ($query) use ($preOrder) {
                $query->where('grade_id', $preOrder->grade->id)
                    ->where('size_id', $preOrder->size->id)
                    ->where('fish_id', $preOrder->fish->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $remainingOrder = $preOrder->qty;
        $rackInfo = [];

        foreach ($kedatanganRak as $item) {
            $qtyOnRack = $item->kedatangan->qty;

            if ($remainingOrder > 0 && $qtyOnRack > 0) {
                $qtyToTake = min($remainingOrder, $qtyOnRack);
                $rackInfo[] = [
                    'name' => $item->rack->name,
                    'qty' => $qtyToTake,
                ];
                $remainingOrder -= $qtyToTake;
            }
            if ($remainingOrder <= 0) {
                break;
            }
        }

//        dd($rackInfo);
        $pdf = \PDF::loadView('admin.preOrder.cetak', compact('preOrder', 'rackInfo'));
        return $pdf->stream('preOrder.pdf');
    }


}
