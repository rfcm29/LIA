<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemKit;
use App\Kit;
use App\Categoria;
use App\Atributo;
use App\Grupo;
use App\Item;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class KitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kits=$this->canView();
        $kitsAtributos=[];
        foreach($kits as $kit){
            $kitsAtributos[]=[$kit,Atributo::findOrFail($kit->id_atributos)];

        }
        
        return view('kits.index',compact('kitsAtributos'));
        
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('gerir',Kit::Class);
        $kits = Kit::all();
        $categorias = Categoria::all();


        return view('kits.create', compact(['kits', 'categorias']));
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
            'fotografia_caminho' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'descricao' => 'required',
            'preco' => 'numeric|required',
            'visivel' => 'required',
            'categoria' => 'required',
            'quantidade' => 'numeric|required'

        ]);

        $kitUltimo = null;

        for ($i=0; $i <request('quantidade') ; $i++) { 
            //code by :https://www.larashout.com/laravel-image-upload-made-easy
            // Check if a profile image has been uploaded
            
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
            

            $atributos = Atributo::create([
                'marca' => 'kit',
                'modelo' => 'modelo',
                'serial_number' => '1',
                'descricao' => request('descricao'),
                'visivel' => request('visivel'),
                'quantidade' => request('quantidade'),
                'is_item'=>0,
                'is_operacional'=>1,
                'fotografia_caminho' => $filePath
            ]);
            $kit = Kit::create([
                'name' => request('name'),
                'preco' => request('preco'),
                'categoria_id' => request('categoria'),
                'id_atributos' => $atributos->id,
            ]);

            $kit->update([
                'id_ipvc' => "Lia-k-".$kit->id
            ]);  

            $kitUltimo = $kit;
            $kit->save();
            
        }
        
        

        return redirect(('/kits/' . $kitUltimo->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Kit $kit)
    {
        
        $items=Kit::findItems($kit->id);
        $atributo = Atributo::findOrFail($kit->id_atributos);
        
        return view('kits.show', compact(['kit', 'atributo','items']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Kit $kit)
    {
        $this->authorize('gerir',Kit::Class);
        $atributo = Atributo::findOrFail($kit->id_atributos);
        $categorias = Categoria::all();
        
        return view('kits.edit', [
            'kits' => $kit,
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
    public function update(Request $request, $id)
    {
        $kit = Kit::findOrFail($id);
        $atributo = Atributo::findOrFail($kit->id_atributos);
        request()->validate([
            'up_image' => 'required',
            'fotografia_caminho' => 'required_if:up_image,1',
            'name' => 'sometimes|required',
            'descricao' => 'sometimes|required',
            'preco' => 'sometimes|numeric|required',
            'visivel' => 'sometimes|boolean|required',
            'categoria' => 'sometimes|exists:categorias,id|required',
            'quantidade' => 'sometimes|required',
            'observacoes' => 'string'

        ]);

        if (request('up_image') === 1) {
            $atributo->update([
                'fotografia_caminho' => request('fotografia_caminho'),
                'visivel' => request('visivel'),
                'descricao' => request('descricao'),
                'quantidade' => request('quantidade')


            ]);
        } else {
            $atributo->update([
                'visivel' => request('visivel'),
                'descricao' => request('descricao'),
                'quantidade' => request('quantidade')

            ]);
        }

        $kit->update([
            'name' => request('name'),
            'preco' => request('preco'),
            'categoria_id' => request('categoria'),
            'observacoes'=> request('observacoes')
            

        ]);
        $kit->save();

        return redirect(('/kits/' . $kit->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kit $kit)
    {
        $this->authorize('gerir',Kit::Class);
        //$kit->delete();
        return redirect('/kits');
    }

    public function canView()
    {
        $canViewInvisibleItems = Grupo::findOrFail(auth()->user()->grupo_id)->gerirItemsKits;
        
        if ($canViewInvisibleItems) {
            $kits=Kit::all();
           } else {
               
            $kits= Kit::kitsVisiveis();
            
        }
        return $kits;

    }

    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

    public function addKit($kit_id){
        $this->authorize('gerir',Kit::Class);
        $kit=Kit::findOrFail($kit_id);
        $info= Kit::infoForAddKit($kit->id);
        return view(('.kits.additems'),compact('info'));
    }


    public function insertItemKit($item_id,$kit_id){
        $existingLinha = ItemKit::findIfExists($item_id,$kit_id);
        $item=Item::findOrFail($item_id);
        $kit=Kit::findOrFail($kit_id);
        /*
        if(isset($existingLinha)){
            $newLinha=ItemKit::updateLinha($item->id,$kit->id,$existingLinha);
            
        }else{
            */
        $newLinha = ItemKit::createLinha($item->id,$kit->id);
        //}

        return redirect(('/addItems/'.$kit_id ))->with('message','O item  foi adicionado ao Kit');
        

    }

    public function removeItemKit($item_id,$kit_id){
        $existingLinha = ItemKit::findIfExists($item_id,$kit_id);
        $item=Item::findOrFail($item_id);
        $kit=Kit::findOrFail($kit_id);
        /*
        if($existingLinha->qtd>1){
            $newLinha=ItemKit::updateLinhaNega($item->id,$kit->id,$existingLinha);
        }else{
            */
        ItemKit::deleteLinha($item->id,$kit->id);
        //}

        return redirect(('/addItems/'.$kit_id ))->with('messageRemove','O item  foi removido ao Kit');

    }
}
