@extends('layout.layout')

@section('content')

   
    <div class="clearfix"></div>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_title">
                <div class="row">
                        <div class="col-6">
                          <h2>Grupos</h2>
                        </div>
                        
                        <div class="col-md-8">
                          
                        </div>
                        <div class="col-md-3">
                          <form action="/searchGrupos" method="POST">
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
                        <th class="text-center">Nome do Grupo</th>
                        <th class="text-center">Utilizadores inseridos</th>
                        <th class="text-center">Ver grupo</th>
                        
                        </tr>
                </thead>                        
                <tbody>
                        @foreach ($newgrupos as $grupo)
                                <tr>
                                        <td class="text-center">{{$grupo['grupo']->name}} </td>
                                        
                                        <td class="text-center">{{$grupo['qtd']}}</td>

                                        <td class="text-center">

                                        <a href="/grupos/{{$grupo['grupo']->id}}"class="btn btn-primary" >Ver Grupo</a>
                                                
                                        
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