<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use Illuminate\Http\Request;

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
}
