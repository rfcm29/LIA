<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CostCenter;
use App\Models\LiaSpace;
use App\Models\SpaceReserve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LiaSpaceController extends Controller
{
    public function index(){
        return view('user.lia_space.index');
    }

    public function getSpace(Request $request){
        $space = LiaSpace::where('space_code', $request->spaceID)->first();
        if($space == null){
            return response()->json(['space' => $space]);
        }
        return response()->json(['space' => $space, 'itens' => $space->itens]);
    }

    public function checkAvailability(Request $request){
        if($request->spaceID == null){
            return response()->json(['message' => 'Nenhum espaço foi selecionado'], 400);
        }
        if(LiaSpace::where('space_code', $request->spaceID)->first() == null){
            return response()->json(['message' => 'Espaço inativo'], 400);
        }
        if($request->start_date == "" || $request->end_date == ""){
            return response()->json(['message' =>'Tem de preencher ambas as datas para verificar a disponibilidade'], 400);
        }
        
        $space = LiaSpace::where('space_code', $request->spaceID)->first();

        return $space == null ? 
            response()->json(['message' => 'Espaço Inativo'], 400) 
            : 
            ($this->available($space, $request) ? response()->json(['available' => true]) : response()->json(['available' => false]));
    }

    private function available($space, $request){
        return collect($space->spaceReserve)->isEmpty() ? true : $this->checkReserveDates($space, $request->start_date, $request->end_date);
    }

    private function checkReserveDates($space, $start_date, $end_date){
        $reserves = $space->spaceReserve()->where(function($query) use ($start_date, $end_date){
                                    $query->whereBetween('start_date', [$start_date, $end_date])
                                        ->orWhereBetween('end_date', [$start_date, $end_date]);
                                })
                                ->orWhere(function($reserve) use ($start_date, $end_date){
                                    $reserve->where('start_date', '<', $start_date)
                                        ->where('end_date', '>', $end_date);
                                })
                                ->get();
        return collect($reserves)->isEmpty() ? true : false;
    }

    public function reserve(Request $request){
        return view('user.lia_space.reserve', [
            'space' => LiaSpace::where('space_code', $request->spaceID)->first(),
            'costCenters' => CostCenter::all(),
            'users' => User::where('user_type_id', 5)->get(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
    }

    public function createReserve($id, Request $request){
        $request->validate([
            'description' => 'required'
        ]);

        $user = $request->exists('occupant_email') ? $this->newUser($request) : User::find($request->occupant_id);
        
        $space = LiaSpace::find($id);

        $reserve = SpaceReserve::create([
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'cost' => $space->cost,
            'occupant_id' => $user->id
        ]);

        $reserve->liaSpace()->attach($space->id);
        $reserve->users()->attach(Auth::id());

        return $reserve;
    }

    private function newUser($request){
        $request->validate([
            'occupant_email' => 'required'
        ]);

        $user = User::create([
            'email' => $request->occupant_email,
            'password' => Hash::make('12345'),
            'user_type_id' => '5',
            'user_status_id' => '1'
        ]);

        return $user;
    }
}