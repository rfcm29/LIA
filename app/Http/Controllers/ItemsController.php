<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Atributo;
use App\Categoria;
use App\Grupo;
use App\Time;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=$this->canView();
        $itemsAtributos=[];
        foreach($items as $item){
            $itemsAtributos[]=[$item,Atributo::findOrFail($item->id_atributos)];

        }
        
        return view('items.index',compact('itemsAtributos'));

         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $this->authorize('gerir',Item::Class);
        $categorias = Categoria::all();
        return view('items.create', compact('categorias'));
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
            'marca' => 'required',
            'modelo' => 'required',
            'serial_number' => 'numeric|required',
            'visivel' => 'boolean|required',
            'categoria' => 'exists:categorias,id|required',
            'fotografia_caminho' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantidade' => 'required',
            'descricao' => 'required'

        ]);

        $itemUltimo = null;

        for ($i=0; $i <request('quantidade') ; $i++) { 
            
            //code by :https://www.larashout.com/laravel-image-upload-made-easy
            // Check if a image has been uploaded
            
            if ($request->has('fotografia_caminho')) {
                // Get image file
                $image = $request->file('fotografia_caminho');
                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('name')).'_'.time();
                // Define folder path
                $folder = '/uploads/images/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                // Upload image
                $this->uploadOne($image, $folder, 'public', $name);
                // Set user profile image path in database to filePath
                
            }

            
            $atributo = Atributo::create([
                'marca' => request('marca'),
                'modelo' => request('modelo'),
                'fotografia_caminho' => $filePath,
                'serial_number' => request('serial_number'),
                'visivel' => request('visivel'),
                'quantidade' => request('quantidade'),
                'is_item'=>1,
                'descricao' => request('descricao'),
                'is_operacional'=>1
                ]);
            
            $item = Item::create([
                'name' => request('name'),
                'categoria_id' => request('categoria'),
                'id_atributos' => $atributo->id,
                'id_ipvc' => "Lia-i-"
                ]);

            
            $item->update([
                'id_ipvc' => "Lia-i-".$item->id
            ]);    
            $item->save();

            $itemUltimo = $item;
        }
        return redirect(('/items/' . $itemUltimo->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  
     * @return \Illuminate\Http\Response
     */

    public function show(Item $item)
    {
        $this->authorize('view',$item);
        $atributo = Atributo::findOrFail($item->id_atributos);
        return view('items.show', compact(['item', 'atributo']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {   
        $this->authorize('gerir',Item::Class);
        $atributo = Atributo::findOrFail($item->id_atributos);
        $categorias = Categoria::all();
        
        return view('items.edit', [
            'items' => $item,
            'atributos' => $atributo,
            'categorias' => $categorias

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, $id)
    {
        $item = Item::findOrFail($id);
        $atributo = Atributo::findOrFail($item->id_atributos);
        request()->validate([
            'marca' => 'sometimes|required',
            'modelo' => 'sometimes|required',
            'serial_number' => 'numeric|required',
            'up_image' => 'required',
            'fotografia_caminho' => 'required_if:up_image,1',
            'name' => 'sometimes|required',
            'descricao' => 'sometimes|required',
            'visivel' => 'boolean|sometimes|required',
            'categoria' => 'exists:categorias,id|sometimes|required',
            'quantidade' => 'sometimes|required',
            'observacoes' =>'string'

        ]);

        if (request('up_image') === 1) {
            $atributo->update([
                'marca' => request('marca'),
                'modelo' => request('modelo'),
                'serial_number' => request('serial_number'),
                'fotografia_caminho' => request('fotografia_caminho'),
                'visivel' => request('visivel'),
                'descricao' => request('descricao'),
                'quantidade' => request('quantidade')


            ]);
        } else {
            $atributo->update([
                'marca' => request('marca'),
                'modelo' => request('modelo'),
                'serial_number' => request('serial_number'),
                'visivel' => request('visivel'),
                'descricao' => request('descricao'),
                'quantidade' => request('quantidade'),
                


            ]);
        }

        $item->update([
            'name' => request('name'),
            'preco' => request('preco'),
            'categoria_id' => request('categoria'),
            'observacoes'=> request('observacoes')
    
        ]);

        $item->save();

        return redirect(('/items/' . $item->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $this->authorize('gerir',Item::Class);
        //$item->delete();
        return redirect('/items');
    }

    /**
     * Checks if the user can see items with attribute visible true
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function canView(){
        $canViewInvisibleItems = Grupo::findOrFail(auth()->user()->grupo_id)->gerirItemsKits;
        
        if ($canViewInvisibleItems) {
            $items=Item::all();
           } else {
            $items = Item::all()->filter(function($item) {
                $atributo = Atributo::findOrFail($item->id_atributos);
                return $atributo->visivel === 1 && count(Time::fetchByItem($item->id))=== 0;
            }); 
        }
        return $items;

    }

 


    /**
     * Makes the upload of the image.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}
