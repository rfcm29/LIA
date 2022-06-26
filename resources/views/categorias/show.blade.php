@extends('layout.layout')

@section('content')

<div class="row">
  <div class="col-md-4">

  
  <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><h1>{{$info[0]->name}}</h1></div>
    
  
    <!-- List group -->
    <ul class="list-group">
      <li class="list-group-item">Descrição: {{$info[0]->descricao}}</li>
      
     
      
    </ul>
  </div>
      
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
        <h2>Categoria</h2>
        
        <div class="clearfix"></div>
</div>
<div class="x_content">
        <br />

        <!-- form -->
        <form id="demo-form2" class="form-horizontal form-label-left" >
        

        <div class="form-group">
        <!-- tabela de utilizadores -->
        <table id="table" class="table table-striped table-bordered bulk_action dt-responsive text-center nowrap" cellspacing="0" width="100%">
        
        <thead>
                <tr>
                <th class="text-center">Nome do Item</th>
                <th class="text-center">Descricao</th>
                <th class="text-center">Serial number</th>
                
                </tr>
        </thead>                        
        <tbody>
          
                @foreach ($info[1][0] as $kit)
                        <tr>
                          
                          
                                <td class="text-center">{{$kit[0]->name}} </td>
                                
                                <td class="text-center">{{$kit[1]->descricao}}</td>

                                <td class="text-center">

                                <a href="/kits/{{$kit[0]->id}}"class="btn btn-primary" >Ver Kit</a>
                                        
                                
                                </td>
                                
                        </tr>
                @endforeach
                
                @foreach ($info[1][1] as $item)
                    
                        <tr>
                                <td class="text-center">{{$item[0]->name}} </td>
                                
                                <td class="text-center">{{$item[1]->descricao}}</td>

                                <td class="text-center">

                                <a href="/items/{{$item[0]->id}}"class="btn btn-primary" >Ver Item</a>
                                        
                                
                                </td>
                                
                        </tr>
                @endforeach
        </tbody>
        </table>                        
        </div>
        </form>
       
</div>
</div>
</div>
</div>






@if (session('grupo')->gerirCategorias)
<form action="/categorias/{{$info[0]->id}}/edit"method="GET">
        
        
  <button type="submit" class="btn btn-primary" >Edit</button>

</form>

<form action="/categorias/{{$info[0]->id}}"method="POST">
  @method('DELETE')
  @csrf
  <button type="submit" class="btn btn-danger" >Delete</button>
</form>

@endif

@endsection