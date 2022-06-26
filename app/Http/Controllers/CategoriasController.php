<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Categoria;
use App\Item;
use App\Kit;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        $newcategorias = [];
        foreach ($categorias as $categoria){
            $count =0;
            $items=Item::all()->where('categoria_id','=',$categoria->id);
            foreach($items as $item){
                $count++;
            }
            $kits=Kit::all()->where('categoria_id','=',$categoria->id);
            foreach ($kits as $kit) {
                $count++;
            }       
            $newcategorias[]=['categoria'=>$categoria,'qtd'=>$count];
        }
        return view('categorias.index', compact('newcategorias'));
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('gerir',Categoria::Class);
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'descricao' => 'required'
        ]);



        $categoria = Categoria::create([
            'name' => request('name'),
            'descricao' => request('descricao')

        ]);

        $categoria->save();


        return redirect(('/categorias/' . $categoria->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        
        $categoria = Categoria::findOrFail($categoria->id);
        $items= Categoria::findItemsKits($categoria->id);
        $info=[$categoria,$items];
        return view('categorias.show', compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        $this->authorize('gerir',Categoria::Class);
        $categoria = Categoria::findOrFail($categoria->id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        request()->validate([
            'name' => 'sometimes|required',
            'descricao' => 'sometimes|required'

        ]);



        $categoria->update([
            'name' => request('name'),
            'descricao' => request('descricao')

        ]);

        $categoria->save();

        return redirect(('/categorias/' . $categoria->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        $this->authorize('gerir',Categoria::Class);
        $categoria->delete();
        return redirect('/categoria');
    }
}
