<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use Illuminate\Http\Request;

use PDF;

class ReserveController extends Controller
{
    public function all(){
        return view('admin.reserves.all', ['reserves' => Reserve::all()]);
    }

    public function pending(){
        return view('admin.reserves.pending', ['reserves' => Reserve::where('reserve_state_id', 1)->get()]);
    }

    public function delayed(){
        return view('admin.reserves.delayed', ['reserves' => Reserve::where('reserve_state_id', '4')->get()]);
    }

    public function show($id){
        return view('admin.reserves.show', ['reserve' => Reserve::find($id)]);
    }

    public function PDFDownload($id){
        $reserve = Reserve::find($id);
        $pdf = PDF::loadview('admin.reserves.PDF', compact('reserve'));

        return $pdf->download('Requisicao.pdf');
    }

    public function autorize($id){
        $reserve = Reserve::find($id);
        $reserve->reserve_state_id = 2;
        $reserve->save();

        return back();
    }

    public function decline($id){
        $reserve = Reserve::find($id);
        $reserve->reserve_state_id = 3;
        $reserve->save();

        return back();
    }
}
