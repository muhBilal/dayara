<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Kedatangan;
use App\Fish;
use Illuminate\Http\Request;

class StockController extends Controller
{
    //
    public function index()
    {
        //ambil data order yang status nya 1 atau masih baru/belum melalukan pembayaran
        $stocks = Kedatangan::select('fish_id','size_id','grade_id','qty','warehouse_id','supplier_id')->with('fish','grade','warehouse','size','supplier')
            ->where('qty', '>', 0)
            ->distinct()
            ->orderBy('id', 'asc')
            ->get();

        foreach ($stocks as $value) {
            $value->qty = Kedatangan::where(['fish_id'=>$value->fish_id,'size_id'=>$value->size_id,'grade_id'=>$value->grade_id,'supplier_id'=>$value->supplier_id])->sum('qty');
        }
            
        return view('admin.stock.index', compact('stocks'));
    }
}
