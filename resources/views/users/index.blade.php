@extends('layout.layout')

@section('content')
        <div class="clearfix"></div>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_title">
                <div class="row">
                        <div class="col-6">
                          <h2>Utilizadores</h2>
                        </div>
                        
                        <div class="col-md-8">
                          
                        </div>
                        <div class="col-md-3">
                          <form action="/searchUsers" method="POST">
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
                        <th class="text-center">Username</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Numero Mecanografico</th>
                        <th class="text-center">Contacto Telefonico</th>
                        <th class="text-center">Grupo</th>
                        <th class="text-center">Editar</th>
                        
                        
                        </tr>
                </thead>                        
                <tbody>
                        @foreach ($allUsers as $user)
                                <tr>
                                        <td class="text-center">{{$user[0]->name}} </td>
                                        
                                        <td class="text-center">{{$user[0]->email}}</td>

                                        <td class="text-center">{{$user[0]->numero_mecanografico}} </td>
                                        
                                        <td class="text-center">{{$user[0]->numero_telemovel}}</td>

                                        <td class="text-center">{{$user[1]->name}}</td>

                                <td class="text-center"><a href="/users/{{$user[0]->id}}" class="btn btn-primary">Editar User</a></td>

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