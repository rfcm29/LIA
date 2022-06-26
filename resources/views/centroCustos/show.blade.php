@extends('layout.layout')

@section('content')


        <h1> {{$item->name}}</h1>
        <h2>{{$item->preco}}</h2>

        <h3>{{$atributo->fotografia_caminho}}</h3>
        
        <form action="/items/{{$item->id}}/edit"method="GET">
                
                
                <button type="submit" class="btn btn-primary" >Edit</button>

              </form>
              <form action="/items/{{$item->id}}"method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger" >Delete</button>
            </form>



    
    
@endsection