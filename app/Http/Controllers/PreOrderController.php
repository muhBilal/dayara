<?php

namespace App\Http\Controllers;

use App\Fish;
use App\Grade;
use App\Kedatangan;
use App\KedatanganRack;
use App\PreOrder;
use App\Size;
use App\Supplier;
use Illuminate\Http\Request;

class PreOrderController extends Controller
{
    public function index()
    {
        $preOrder = PreOrder::with('fish', 'grade', 'size')
            ->get();
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
        $preOrder = PreOrder::create([
            'fish_id' => $request->fish_id,
            'fish_size_id' => $request->size_id,
            'fish_grade_id' => $request->grade_id,
            'cust_name' => $request->name,
            'cust_vehicle' => $request->vehicle,
            'qty' => $request->qty,
        ]);
//        return redirect()->route('admin.preOrder')->with('success', 'Pre Order berhasil ditambahkan');
        $pdf = \PDF::loadView('admin.preOrder.cetak', compact('preOrder'));
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

    public function destroy(PreOrder $id)
    {
        $id->delete();
        return redirect()->route('admin.preOrder')->with('success', 'Pre Order berhasil dihapus');
    }

    public function print($id)
    {
        $preOrder = PreOrder::with('fish', 'grade', 'size')->find($id);
        $fishId = $preOrder->fish->id;
        $kedatangan = Kedatangan::where('fish_id', $fishId)->orderBy('urutan', 'asc')->get()->first();
        $rak_id = $kedatangan->id;
        $get_rak = KedatanganRack::with('rack')->where('kedatangan_id', 17)->get()->first();
        $rackName = $get_rak->rack->name;

        $pdf = \PDF::loadView('admin.preOrder.cetak', compact('preOrder', 'rackName'));
        return $pdf->stream('preOrder.pdf');
    }

}
