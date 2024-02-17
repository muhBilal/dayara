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
            $items = [];
            if ($request->filled('counter')) {
                for ($i = 1; $i <= $request->input('counter'); $i++) {
                    $items[] = [
                        'fish_id' => $request->input("fish_id_$i"),
                        'size_id' => $request->input("size_id_$i"),
                        'grade_id' => $request->input("grade_id_$i"),
                        'qty' => $request->input("qty_$i"),
                    ];
                }
            }

//            $items = array_merge([$mainFormData], $additionalFormsData);

            $custInfo = [
                'name' => $request->name,
                'vehicle' => $request->vehicle,
            ];

            $order = PreOrder::create($custInfo);

            $rackInfo = [];
            $idOrder = [];
            foreach ($items as $item) {
                $checkRack = KedatanganRack::with('kedatangan')->whereHas('kedatangan', function ($query) use ($item) {
                    $query->where('grade_id', $item['grade_id'])
                        ->where('size_id', $item['size_id'])
                        ->where('fish_id', $item['fish_id']);
                })->get();

                $totalQty = $checkRack->sum('kedatangan.qty');

                if (!$checkRack || $totalQty < $item['qty']) {
                    DB::rollBack();
                    echo '<script>';
                    echo 'alert("Pre Order gagal ditambahkan, rak tidak ditemukan");';
                    echo 'window.close();';
                    echo '</script>';
                    exit();
                }

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
                    ->orderBy('id', 'asc')
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

            $fish = [];
            foreach ($idOrder as $item) {
                $fish[] = DetailOrder::with('fish', 'grade', 'size')->find($item);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        $pdf = \PDF::loadView('admin.preOrder.cetak', compact('custInfo', 'items', 'rackInfo', 'fish'));
        return $pdf->stream('preOrder.pdf');
    }

    public function show(PreOrder $po)
    {
        //
    }

    public function edit($id)
    {
        $preOrder = PreOrder::with('detailOrders')->find($id);
        $fish = Fish::all();
        $size = Size::all();
        $grade = Grade::all();
        $fishOrder = $preOrder->detailOrders;
        return view('admin.preOrder.edit', compact('preOrder', 'fish', 'size', 'grade', 'fishOrder'));
    }

    public function update(Request $request, $id)
    {
        $items = [];
        for ($i = 1; $i <= $request->input('counter'); $i++) {
            $items[] = [
                'fish_id' => $request->input("fish_id_$i"),
                'size_id' => $request->input("size_id_$i"),
                'grade_id' => $request->input("grade_id_$i"),
                'qty' => $request->input("qty_$i"),
            ];
        }

        $custInfo = [
            'name' => $request->name,
            'vehicle' => $request->vehicle,
        ];

        $po = PreOrder::with('detailOrders')->find($id);
        $po->detailOrders()->delete();
        $po->update($custInfo);

        foreach ($items as $item) {
            if ($item['qty'] == 0) {
                continue;
            }
            $detailOrder = new DetailOrder([
                'fish_id' => $item['fish_id'],
                'fish_size_id' => $item['size_id'],
                'fish_grade_id' => $item['grade_id'],
                'qty' => $item['qty'],
            ]);
            $po->detailOrders()->save($detailOrder);
        }

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

    public function print($id)
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
                ->orderBy('id', 'asc')
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

        $pdf = \PDF::loadView('admin.preOrder.cetak', compact('custInfo', 'item', 'rackInfo', 'fish'));
        return $pdf->stream('preOrder.pdf');

    }


}
