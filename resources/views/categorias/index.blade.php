@extends('layout.layout')

@section('content')
    
                

    <div class="clearfix"></div>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_title">
                <div class="row">
                        <div class="col-6">
                          <h2>Categorias</h2>
                        </div>
                        
                        <div class="col-md-8">
                          
                        </div>
                        <div class="col-md-3">
                          <form action="/searchCategorias" method="POST">
                            @csrf
                          <div class="input-group">
                            <input type="text" name="name" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                            </span>
                          </div>
                        </form>
                        </div>
                      
                      </div>
                
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
                        <th class="text-center">Nome da Categoria</th>
                        <th class="text-center">Items/kits na Categoria</th>
                        <th class="text-center">Ver Categoria</th>
                        
                        </tr>
                </thead>                        
                <tbody>
                    @foreach ($newcategorias as $categoria)
                                <tr>
                                        <td class="text-center">{{$categoria['categoria']->name}} </td>
                                        
                                        <td class="text-center">{{$categoria['qtd']}}</td>

                                        <td class="text-center">

                                        <a href="/categorias/{{$categoria['categoria']->id}}"class="btn btn-primary" >Pesquisar por Categoria</a>
                                                
                                        
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
      
   

@endsection