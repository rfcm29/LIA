@extends('layout.layout')

@section('content')


<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
        <div class="row">
              
                
                <div class="col-md-6">
                        <h2>Items no {{$info[0]->name}}</h2>
                  
                </div>
                <div class="col-md-2"><a href="/addItems/{{$info[0]->id}}" class="btn btn-primary">Mostrar todos</a></div>
                <div class="col-md-3">
                  <form action="/searchItemsInKits/{{$info[0]->id}}" method="POST">
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
                    <th class="text-center">Nome Item</th>
                    <th class="text-center">Categoria</th>
                    <th class="text-center">Descricao</th>
                    
                    <th class="text-center">Remover do Kit</th>
                    
                </tr>
        </thead>                        
        <tbody>
                @foreach ($info[1] as $item)
                    <tr>
                        <td class="text-center">{{$item[0]->name}} </td>
                        
                        <td class="text-center">{{$item[1]->name}}</td>
                        
                        <td class="text-center">{{$item[2]->descricao}}</td>
                        
                        
                        
                        <td class="text-center">
                                <form action="/removeItemKit/{{$item[0]->id}}/{{$info[0]->id}}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <button type="submit" class="btn btn-primary" >Remover do Kit</button>
                                </form>
                        
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
      
  
        <div class="clearfix"></div>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_title">
                <div class="row">
              
                
                        <div class="col-md-6">
                               
                                <h2>Items fora do {{$info[0]->name}}</h2>
                          
                        </div>
                        <div class="col-md-2"><a href="/addItems/{{$info[0]->id}}" class="btn btn-primary">Mostrar todos</a></div>
                        <div class="col-md-3">
                          <form action="/searchItemsOutKits/{{$info[0]->id}}" method="POST">
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
                        <th class="text-center">Nome Item</th>
                        <th class="text-center">Categoria</th>
                        <th class="text-center">Descricao</th>
                        <th class="text-center">Inserir no Kit</th>
                        
                        </tr>
                </thead>                        
                <tbody>
                    
                        @foreach ($info[2] as $item)
                        
                        
                                <tr>
                                        <td class="text-center">{{$item[0]->name}} </td>
                                        
                                        <td class="text-center">{{$item[1]->name}}</td>

                                        <td class="text-center">{{$item[2]->descricao}}</td>
                                        
                                        <td class="text-center">
                                                <form action="/insertItemKit/{{$item[0]->id}}/{{$info[0]->id}}" method="POST">
                                                        @method('PATCH')    
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary" >Inserir no Kit</button>
                                                </form>
                                        
                                        </td>
                                        
                                </tr>
                        @endforeach
                </tbody>
                </table>                        
                </div>
                
               
                @if (session('message')!==null)
                <div class="col-4">
                <div class="alert alert-success" role="alert">{{session('message')}}</div>
                </div>
                @endif
        </div>
        </div>
        </div>
        </div>


    
@endsection