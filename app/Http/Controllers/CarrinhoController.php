<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Kit;
use App\CarrinhoCompras;
use App\CarrinhoLinhas;
use App\Atributo;
use Illuminate\Support\Facades\DB;

class CarrinhoController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrinho = CarrinhoCompras::carrinho(auth()->user());
        if(!session('datas')){
            DB::table('carrinho_linhas')->where('carrinho_linhas.carrinho_compras_id', '=' ,$carrinho->id)->delete(); 
        }
        $linhas=CarrinhoLinhas::fetchLinhas( $carrinho->id);
        
        return view('.carrinho.index',compact('linhas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id_atributos)
    {
        $request->validate([
            'pag'=>'required'
        ]);
        $atributo=Atributo::findOrFail($id_atributos);
        $user = auth()->user();
        $carrinho = CarrinhoCompras::carrinho($user);
        
        if($atributo->is_item){
            $item=Item::findOrFail(request('id'));
            $kit= null;
            $existingLinha = CarrinhoLinhas::checkLinha($kit,$item,$carrinho);
            if($existingLinha){
            }else{
                $carrinhoLinha = CarrinhoLinhas::insereItemKit($carrinho,$item,$kit);   
                }
            if(request('pag')==1){
                return redirect(('/items' ))->with('message','O item  foi adicionado ao Carrinho');
            }else if (request('pag')=="3") {
                return redirect(('/reservas/create' ))->with('message','O item  foi adicionado ao Carrinho');
            }else {
                return redirect(('/carrinho' ))->with('message','O item  foi adicionado ao Carrinho');
            }
        }
        if(!$atributo->is_item){
            $item=null;
            $kit=Kit::findOrFail(request('id'));
            $existingLinha = CarrinhoLinhas::checkLinha($kit,$item,$carrinho);
            if($existingLinha){
            }else{
                $carrinhoLinha = CarrinhoLinhas::insereItemKit($carrinho,$item,$kit);
            }
            if(request('pag')==1){
                return redirect(('/kits' ))->with('message','O item  foi adicionado ao Carrinho');
            }else if (request('pag')=="3") {
                return redirect(('/reservas/create' ))->with('message','O item  foi adicionado ao Carrinho');
            }else {
                return redirect(('/carrinho' ))->with('message','O item  foi adicionado ao Carrinho');
            }
        }
    }

    /**
     * Removes Items from Carrinho Compras.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Request  $id_atributos
     * @return \Illuminate\Http\Response
     */
    public function removeItem(Request $request,$id_atributos){
        $request->validate([
            'pag'=>'required'
        ]);
        $atributo=Atributo::findOrFail($id_atributos);
        $user = auth()->user();
        $carrinho = CarrinhoCompras::carrinho($user);
            
        if($atributo->is_item){
            $item=Item::findOrFail(request('id'));
            $kit= null;
            $existingLinha = CarrinhoLinhas::checkLinha($kit,$item,$carrinho);
            $newLinha= CarrinhoLinhas::DeleteLinha($carrinho,$existingLinha,$item,$kit);
            /*
            if($existingLinha->qtd!==1){
                $newLinha= CarrinhoLinhas::removeQtdLinha($carrinho,$existingLinha,$item,$kit);

            }else{
                
                

            }
            */
            
            //dd(request('pag'));
            if(request('pag')=="1"){
                return redirect(('/kits' ))->with('message','O item  foi removido do Carrinho');

            }else if(request('pag')=="2"){
                return redirect(('/searchItemsKits' ))->with('message','O item  foi removido do Carrinho');
            }else if (request('pag')=="3") {
                return redirect(('/reservas/create' ))->with('message','O item  foi removido do Carrinho');
            }else {
                return redirect(('/carrinho' ))->with('message','O item  foi removido do Carrinho');
            }
        }

        if(!$atributo->is_item){
            $item=null;
            $kit=Kit::findOrFail(request('id'));
            $existingLinha = CarrinhoLinhas::checkLinha($kit,$item,$carrinho);
            $newLinha= CarrinhoLinhas::deleteLinha($carrinho,$existingLinha,$item,$kit);

            /*
            if($existingLinha->qtd!==1){
                $newLinha= CarrinhoLinhas::removeQtdLinha($carrinho,$existingLinha,$item,$kit);

            }else{
                

            }
            */
            
    
            if(request('pag')=="1"){
                return redirect(('/kits' ))->with('message','O item  foi adicionado ao Carrinho');

            }else if(request('pag')=="2"){
                return redirect(('/searchItemsKits' ))->with('message','O item  foi adicionado ao Carrinho');
            }else if (request('pag')=="3") {
                return redirect(('/reservas/create' ))->with('message','O item  foi adicionado ao Carrinho');
             } else {
                return redirect(('/carrinho' ))->with('message','O item  foi adicionado ao Carrinho');
            }      
        }


    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

   

    /**
     * Remove the specified linha from carrinho Compras.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyLinhaItem($id)
    {
        $user = auth()->user();
        
        $linha = DB::table("carrinho_linhas")
            ->where("item_id" ,"=", $id)
            ->delete();

        return redirect(("/reservas/create"));
        
        

    }

    /**
     * Remove the specified linha from carrinho Compras.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyLinhaKit($id){

        $linha = DB::table("carrinho_linhas")
            ->where("kit_id" ,"=", $id)
            ->delete();

            return redirect(("/reservas/create"));
       
        
    }
}
