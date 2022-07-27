<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiaSpace;
use App\Models\SpaceItem;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LiaSpaceController extends Controller
{
    public function index(){
        return view('admin.lia_space.index');
    }

    public function getSpace(Request $request){
        $space = LiaSpace::where('space_code', $request->spaceID)->first();
        if($space == null){
            return response()->json(['space' => $space]);
        }
        return response()->json(['space' => $space, 'itens' => $space->itens]);
    }

    public function create($id){
        return view('admin.lia_space.create', ['id'=>$id]);
    }

    public function store(Request $request, $id){
        $request->validate([
            'description' => 'required',
            'lia_code' => 'required',
            'price' => 'required',
            'itens.*' => 'required'
        ],
        [
            'description.required' => 'O espaço deve ter uma descrição',
            'lia_code.required' => 'Insira um código do Lia para este espaço',
            'price.required' => 'O espaço deve ter um preço associado',
            'itens.*.required' => 'Tentou adicionar itens sem descrição',
        ]);

        $space = LiaSpace::create([
            'description' => $request->description,
            'lia_code' => $request->lia_code,
            'cost' => $request->price,
            'space_code' =>  $id
        ]);

        foreach($request->itens as $item){
            SpaceItem::create([
                'lia_space_id' => $space->id,
                'description' => $item
            ]);
        }

        return redirect('/admin/lia-space')->with('toast_success', 'Novo espaço criado');
    }

    public function delete($id){
        $space = LiaSpace::where('space_code', $id)->first();
        $space->space_code = null;
        $space->save();

        return;
    }
}
