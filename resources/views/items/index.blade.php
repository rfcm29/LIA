@extends('layout.layout')

@section('content')

<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
  <div class="row">
    <div class="col-md-6">
      <h2>Items (todos os items)</h2>
    </div>
    
    <div class="col-md-6">
      <form action="/searchItemsAndKits" method="POST">
        @csrf
        <div class="row">
          
          <div class="col-md-4">
            <div class="form-group">
            <label class="control-label" for="descricao">Entre</label>
            <input type="date" name="data_entre_inicio">
            </select>  
            
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
            <label class="control-label" for="descricao">e </label>
            <input type="date" name="data_entre_fim">
            </select>  
            
            </div>
            
            
            </div>
            <div class="col-md-4">
                <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="Pesquisar Por">
                <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Go!</button>
                </span>
                </div>
            </div>
        </div>
        @if (session('datas'))
              <div class="row">
                
                <div class="col-md-12">
                <label for="datas">Reservas para datas entre {{session('datas')[0]}} e {{session('datas')[1]}} </label>
                </div>
              </div>
               
        @endif
    </form>           
  </div>
  </div>
        
        
        <div class="clearfix"></div>
</div>
<div class="col-8">
  <div class="row">
      @foreach ($itemsAtributos as $item)
      
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">{{$item[0]->name}}</h3>
            </div>
            <div class="panel-body">
              <img class="img-responsive" style="display:block; margin-left: auto; margin-right: auto;"src="{{$item[1]->fotografia_caminho}}" alt="..." width="240" height="200">
              <p></p>
              <div class="panel-body">
                <h4>{{$item[0]->id_ipvc}}</h4>
              </div>
              <div class="row">

                <!--
                <div class="col-xl-6">
                  <form action="/insertItemCarrinho/{{$item[0]->id_atributos}}"method="POST">
                    @method('PATCH')
                    @csrf
                    
                    <input name="id" value="{{$item[0]->id}}" hidden>
                    <input type="hidden" name ="pag" value="1">
                    <button type="submit" class="btn btn-primary" >Adicionar ao Carrinho</button>
                </form>
                </div>
              -->

                <div class="col-xl-6">
                  
                    
                <a href="/items/{{$item[0]->id}}" class="btn btn-primary" >Ver item</a>
                
                </div>
              </div>
            </div>
          </div>
        </div>
      
              
            
      @endforeach         
    </div>
  
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

