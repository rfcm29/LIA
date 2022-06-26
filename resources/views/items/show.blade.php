@extends('layout.layout')

@section('content')


        <div class="row">
        
          <div class="col-md-4">
            <div class="panel-heading"><h1>{{$item->name}}</h1></div>
            <div class="panel panel-default">
              <!-- Default panel contents -->
              
              <div class="panel-body">
                <p><img class="media-object" src="{{$atributo->fotografia_caminho}}" alt="..."></p>
              </div>
            
              <!-- List group -->
              <ul class="list-group">
                <li class="list-group-item">Descrição: {{$atributo->descricao}}</li>
                <li class="list-group-item">Serial Number: {{$atributo->serial_number}}</li>
                
              </ul>
            </div>
    
            
            
            @if (session('grupo')->gerirItemsKits)
            <form action="/items/{{$item->id}}/edit"method="GET">
              <button type="submit" class="btn btn-primary" >Edit</button>
            </form>
            <form action="/items/{{$item->id}}"method="POST">
              @method('DELETE')
              @csrf
              <button type="submit" class="btn btn-danger" >Delete</button>
            </form>
                
            @endif
            @if (session('datas'))
            <form action="/insertItemCarrinho/{{$item->id_atributos}}"method="POST">
              @method('PATCH')
              @csrf
              
              <input name="id" value="{{$item->id}}" hidden>
              <input type="hidden" name ="pag" value="1">
              <button type="submit" class="btn btn-primary" >Adicionar ao Carrinho</button>
          </form>
            @endif
            
          </div>
        </div>
        
        



    
    
@endsection