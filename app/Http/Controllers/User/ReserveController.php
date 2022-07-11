<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CostCenter;
use App\Models\Kit;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\View\Components\Widget\Alert;

class ReserveController extends Controller
{
    public function index(){
        
        return view('user.reserve.create', ['costCenters' => CostCenter::all()]);
    }

    public function create(Request $request){
        $request->validate([
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ],[
            'description.required' => 'Necessita de uma razão para efetuar a reserva',
            'start_date.required' => 'Data de inicio da reserva é necessaria',
            'end_date.required' => 'Data de fim da reserva é necessaria'
        ]);

        $reserve = [
            "user_id" => Auth::id(),
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "description" => $request->description,
            "cost_center_id" => $request->cost_center_id,
            "cost" => 0,
            "kits" => []
        ];

        session()->put('reserve', $reserve);

        return redirect()->to('/reserve/info')->with('toast_success', 'Reserva iniciada');
    }

    public function reserveInfo(){
        return view('user.reserve.info');
    }

    public function addKit($id){

        $kit = Kit::find($id);

        if(!session()->has('reserve')){
            return back()->with('warning', 'Tem de criar uma reserva para poder adicionar kits!',[
                'position' => 'center',
                'timer' => null,
                'toast' => false,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Criar reserva',
                'onConfirmed' => 'createReserve'
            ]);
            return;
        }
        
        if(empty(session()->get('reserve.kits'))){
            session()->push('reserve.kits', $kit);
            session()->increment('reserve.cost', $kit->price);
        }else{
            if(in_array($kit, session()->get('reserve.kits'))){
                return back()->with('warning', 'Não pode reservar o mesmo kit duas vezes');
            }
            else{
                session()->push('reserve.kits', $kit);
                session()->increment('reserve.cost', $kit->price);
            }
        }

        return back()->with('toast_success', 'Kit adicionado à reserva');
    }

    public function removeKit($id){
        $kits = session()->pull('reserve.kits');
        foreach ($kits as $kit) {
            if($kit->id == $id){
                array_splice($kits, $kit->id);
            }
            else {
                session()->push('reserve.kits', $kit);
            }
        }

        return back()->with('toast_success', 'Kit removido!');
    }

    public function cancelReserve(){
        session()->pull('reserve');

        return redirect('/reserve')->with('success', 'Reserva foi cancelada');
    }

    public function confirmReserve(){
        if(empty(session()->get('reserve.kits'))){
            return back()->with('warning', 'Adicione kits á reserva para poder concluir!');
        } 

        $reserve = Reserve::create([
            'description' => session()->get('reserve.description'),
            'cost_center_id' => session()->get('reserve.cost_center_id'),
            'user_id' => session()->get('reserve.user_id'),
            'start_date' => session()->get('reserve.start_date'),
            'end_date' => session()->get('reserve.end_date'),
            'cost' => session()->get('reserve.cost'),
            'reserve_state_id' => 1
        ]);

        $costCenter = CostCenter::find(session()->get('reserve.cost_center_id'));
        $costCenter->total_cost += session()->get('reserve.cost');
        $costCenter->save();

        foreach(session()->get('reserve.kits') as $kit){
            $reserve->kits()->attach($kit->id);
        }

        session()->forget('reserve');

        return redirect('/')->with('success', 'Reserva efetuada com sucesso!');
    }
}
