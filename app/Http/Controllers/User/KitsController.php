<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitsController extends Controller
{
    public function index($id){
        $kits = null;
        if($this->hasSession()){
            $kits = $this->filteredKits($id);
        }
        else{
            if(request('search')){
                $kits = Kit::where('kit_state_id', '!=', 3)
                            ->where('description', 'LIKE', '%'.request('search').'%')
                            ->where('kit_category_id', $id)->get();
            } else {
                $kits = Kit::where('kit_state_id', '!=', 3)
                            ->where('kit_category_id', $id)->get();
            }
        }

        return view('user.kits.list', ['kits' => $kits]);
    }

    private function hasSession(){
        if(session()->has('reserve')){
            return true;
        }
        
        return false;
    }

    public function show($id){
        return view('user.kits.info', ['kit' => Kit::find($id)]);
    }

    private function filteredKits($id){
        $kits = Kit::where('kit_state_id', '!=', 3)->where('kit_category_id', $id)->doesntHave('reserves')
                ->orWhere('kit_state_id', '!=', 3)->where('kit_category_id', $id)->whereDoesntHave('reserves', function(Builder $query){
                    $query->whereBetween('start_date', [session()->get('reserve.start_date'), session()->get('reserve.end_date')])
                        ->orWhereBetween('end_date', [session()->get('reserve.start_date'), session()->get('reserve.end_date')]);
                })
                ->orWhere('kit_state_id', '!=', 3)->where('kit_category_id', $id)->whereDoesntHave('reserves', function(Builder $query){
                    $query->where('start_date', '>' , session()->get('reserve.end_date'))
                        ->orWhere('end_date', '<', session()->get('reserve.start_date'));
                })
                ->get();

        return $kits;
    }
}
