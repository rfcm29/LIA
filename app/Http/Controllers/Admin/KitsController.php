<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Kit;
use App\Models\KitCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class KitsController extends Controller
{
    public function index(){
        if(request('search')){
            $kits = Kit::where('description', 'LIKE', '%'.request('search').'%')
                ->orWhere('lia_code', 'LIKE', '%'.request('search').'%')->get();
        } else{
            $kits = Kit::all();
        }
        
        return view('admin.kits.index', ['kits' => $kits]);
    }

    public function create(){
        return view('admin.kits.create', [
            'categories' => KitCategory::all(), 
            'kits' => Kit::where('kit_id', null)->get()
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'description' => 'required',
            'lia_code' => 'required|unique:kits,lia_code',
            'price' => 'required'
        ],
        [
            'description.required' => 'O kit deve ter uma descrição',
            'lia_code.required' => 'O kit deve ter um código LIA associado',
            'lia_code.unique' => 'Código LIA deve ser único',
            'price.required' => 'O kit deve ter um preço associado'
        ]);

        if($request->itens){
            $request->validate([
                'itens.*.description' => 'required'
            ]);
        }
        
        $parentKit = Kit::create([
            'description' => $request->description,
            'lia_code' => $request->lia_code,
            'price' => $request->price,
            'ipvc_ref' => $request->ipvc_ref,
            'kit_category_id' => $request->category,
            'kit_state_id' => 1
        ]);

        if($request->itens){
            foreach($request->itens as $item){
                Item::create([
                    'description' => $item['description'],
                    'model' => $item['model'],
                    'serial_number' => $item['serial_number'],
                    'ipvc_ref' => $item['ipvc_ref'],
                    'kit_id' => $parentKit->id
                ]);
            }
        }

        if($request->kits){
            foreach($request->kits as $id){
                $Kit = Kit::find($id);
                $Kit->kit_id = $parentKit->id;
                $Kit->save();
            }
        }

        return redirect('admin/kits')->with('toast_success', 'Kit criado com sucesso!');
    }

    public function show($id){
        return view('admin.kits.show', ['kit' => Kit::find($id)]);
    }

    public function edit($id){
        return view('admin.kits.edit', [
            'kit' => Kit::find($id),
            'categories' => KitCategory::all(), 
            'kits' => Kit::where('kit_id', null)
                        ->orWhere('kit_id', $id)->get()]);
    }

    public function update(Request $request, $id){
        $kit = Kit::find($id);
        $items = $kit->items;
        $kits = $kit->kits;

        $request->validate([
            'description' => 'required',
            'lia_code' => ['required', Rule::unique('kits', 'lia_code')->ignore($id)],
            'price' => 'required'
        ],
        [
            'description.required' => 'O kit deve ter uma descrição',
            'lia_code.required' => 'O kit deve ter um código LIA associado',
            'lia_code.unique' => 'Código LIA deve ser único',
            'price.required' => 'O kit deve ter um preço associado'
        ]);
        //return $items;

        if($request->itens){
            $request->validate([
                'itens.*.description' => 'required'
            ]);
            
            foreach($request->itens as $key => $itemInfo){
                foreach($items as $item){
                    if($item->id == $key){
                        $item->update([
                            'description' => $itemInfo['description'],
                            'model' => $itemInfo['model'],
                            'serial_number' => $itemInfo['serial_number'],
                            'ipvc_ref' => $itemInfo['ipvc_ref']
                        ]);
                        $item->save();
                        $items->pull($item->id);
                        unset($request->itens,$key);
                    }
                }
            }
            foreach($items as $item){
                $item->delete();
            }
            foreach($request->itens as $item){
                Item::create([
                    'description' => $item['description'],
                    'model' => $item['model'],
                    'serial_number' => $item['serial_number'],
                    'ipvc_ref' => $item['ipvc_ref'],
                    'kit_id' => $kit->id
                ]);
            }
        } else {
            foreach($items as $item){
                $item->delete();
            }
        }

        if($request->kits){
            foreach($kits as $item){
                $item->kit_id = null;
                $item->save();
            }
            foreach($request->kits as $kitID){
                $data = Kit::where('id', $kitID)->first();
                $data->kit_id = $id;
                $data->save();
            }
        }else {
            foreach($kits as $item){
                $item->kit_id = null;
                $item->save();
            }
        }

        $kit->update([
            'description' => $request->description,
            'lia_code' => $request->lia_code,
            'price' => $request->price,
            'ipvc_ref' => $request->ipvc_ref,
            'kit_category_id' => $request->category,
            'kit_state_id' => 1
        ]);

        $kit->save();

        return redirect(route('kits.show', $kit->id));
    }

    public function destroy(){

    }
}
