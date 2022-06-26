@extends('layout.layout')

@section('content')


            @foreach ($items as $item)
            

            <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">{{$item->name}}</h5>
                      <p class="card-text">{{$item->preco}}</p>
                    <a href="/items/{{$item->id}}" class="btn btn-primary">Ver Item</a>
                    
                    <form action="/carrinho/{{$item->id_atributos}}"method="POST">
                      @csrf
                      <input name="id" value="{{$item->id}}" hidden>
                      <button type="submit" class="btn btn-primary" >Adicionar ao Carrinho</button>
                  </form>
                    
                    </div>
                  </div>
                    
            
            @endforeach
        



    
    
@endsection

