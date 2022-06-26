@extends('layout.layout')

@section('content')
<div class="clearfix"></div>
        <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                        <h1>Grupo {{$grupo->name}}</h1>
        <div class="x_panel">
        <div class="x_title">

<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
        
        <div class="row">
                
                
                <div class="col-md-8">
                        
                        <h2>Utilizadores no Grupo</h2>
                </div>
                <div class="col-md-3">
                <form action="/searchUsersInGrupo/{{$grupo->id}}" method="POST">
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
        

        <div class="form-group">
        <!-- tabela de utilizadores -->
        <table id="table" class="table table-striped table-bordered bulk_action dt-responsive text-center nowrap" cellspacing="0" width="100%">
        
        <thead>
                <tr>
                <th class="text-center">Username</th>
                <th class="text-center">Email</th>
                <th class="text-center">Remover do Grupo</th>
                
                </tr>
        </thead>                        
        <tbody>
                @foreach ($usersGroup as $user)
                        <tr>
                                <td class="text-center">{{$user->name}} </td>
                                
                                <td class="text-center">{{$user->email}}</td>

                                <td class="text-center">
                                        <form action="/removeGrupo/{{$user->id}}/{{$grupo->id}}" method="POST">
                                                @csrf
                                                
                                
                                                <button type="submit" class="btn btn-primary" >Remover</button>
                                        </form>
                                
                                </td>
                                
                        </tr>
                @endforeach
        </tbody>
        </table>                        
        </div>
        
              <a href="/grupos/{{$grupo->id}}/edit" class="btn btn-primary mx-auto">Editar Permissões do Grupo</a>
</div>
</div>
</div>
</div>
      

                <div class="clearfix"></div>
                <div class="row">
                        <div class="col-md-8">
                                
                                <h2>Inserir Utilizadores</h2>
                        </div>
                        <div class="col-md-3">
                          <form action="/searchUsersOutGrupo/{{$grupo->id}}" method="POST">
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

                

                <div class="form-group">
                <!-- tabela de utilizadores -->
                <table id="table" class="table table-striped table-bordered bulk_action dt-responsive text-center nowrap" cellspacing="0" width="100%">
                
                <thead>
                        <tr>
                        <th class="text-center">Username</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Inserir no Grupo</th>
                        
                        </tr>
                </thead>                        
                <tbody>
                        @foreach ($users as $user)
                                <tr>
                                        <td class="text-center">{{$user->name}} </td>
                                        
                                        <td class="text-center">{{$user->email}}</td>
                                        
                                        <td class="text-center">
                                                <form action="/insertGrupo/{{$user->id}}/{{$grupo->id}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary" >Inserir no Grupo</button>
                                                </form>
                                        
                                        </td>
                                        
                                </tr>
                        @endforeach
                </tbody>
                </table>                        
                </div>
                
               
                @if (session('message')!==null)
                <div class="col-4">
                <div class="alert alert-danger" role="alert">{{session('message')}}</div>
                </div>
                @endif
        </div>
        </div>
        </div>
        </div>


       
                

        


        
    
    
@endsection