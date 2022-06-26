@extends('layout.layout')

@section('content')

        <div class="clearfix"></div>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_title">
        <h2>{{$kit->name}}</h2>
                
        <div class="clearfix"></div>
        </div>
        <div class="col-md-3">
        <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">{{$kit->name}}</h3>
                </div>
                <div class="panel-body">
                  <img class="img-responsive" src="{{$atributo->fotografia_caminho}}" alt="..." width="240" height="200">
                  <p></p>
                  <div class="row">
                    <div class="col-xl-6">
                     
                    </div>
    
                  </div>
                </div>
              </div>
              
        </div>
        <div class="row">
                <div class="col-md-4">
                        <form action="/insertItemCarrinho/{{$atributo->id}}"method="POST">
                                @method('PATCH')
                                @csrf
                                
                                <input name="id" value="{{$kit->id}}" hidden>
                                <input type="hidden" name ="pag" value="1">
                                <button type="submit" class="btn btn-primary">Adicionar ao Carrinho</button>
                        </form>
                </div>
        </div>
        

        @if (session('grupo')->gerirItemsKits)
        <div class="row">
                <div class="col-md-4">
                        <form action="/kits/{{$kit->id}}/edit"method="GET">
                                @csrf
                                
                                <button type="submit" class="btn btn-primary">Editar Kit</button>
                        </form>
                </div>

        </div>
        <div class="row">
                <div class="col-md-6">
                        @if (session('grupo')->gerirItemsKits)
                        <a href="/addItems/{{$kit->id}}" class="btn btn-primary" >Adicionar Items</a>
                        @endif
                          
                </div>
        </div>
        
        <div class="row">
                <div class="col-md-4">
                        <form action="/kits/{{$kit->id}}"method="POST">
                                @csrf
                                
                                <input name="id" value="{{$kit->id}}" hidden>
                                <input type="hidden" name ="pag" value="1">
                                <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                </div>

        </div>
        @endif
                

       

        
        

                
        <div class="x_content">
                <br />
                <div class="form-group">
                <!-- tabela de utilizadores -->
                <table id="table" class="table table-striped table-bordered bulk_action dt-responsive text-center nowrap" cellspacing="0" width="100%">
                
                <thead>
                        <tr>
                        <th class="text-center">Nome Item</th>
                        <th class="text-center">Ver Item</th>
                        
                        </tr>
                </thead>                        
                <tbody>
                        @foreach ($items as $item)
                        <tr>
                                <td class="text-center">{{$item[0]->name}} </td>
                                
                                
                                <td class="text-center">
                                        <a class="btn btn-primary"  href="/items/{{$item[0]->id}}">Ver item</a>
                                
                                </td>
                                
                        </tr>
                        @endforeach
                </tbody>
                </table>                        
                </div>
                @if (session('messageRemove')!==null)
                <div class="col-4">
                <div class="alert alert-success" role="alert">{{session('messageRemove')}}</div>
                </div>
                @endif
                
        </div>
        </div>
        </div>
        </div>
    
    
@endsection