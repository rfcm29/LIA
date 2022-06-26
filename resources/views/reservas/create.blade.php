@extends('layout.layout')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Reservar</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br/>

          <div class="form-group">
            <!-- tabela de utilizadores -->
            <table id="table" class="table table-striped table-bordered bulk_action dt-responsive text-center nowrap" cellspacing="0" width="100%">
            
            <thead>
                    <tr>
                    <th class="text-center">Nome do Item/Kit</th>
                    <th class="text-center">Remover do Carrinho</th>
                    
                    </tr>
            </thead>                        
            <tbody>
              
              
              
                    @foreach ($linhas as $item)
                    
                        @if ($item->itemKit instanceof \App\Item)
                        <tr>
                          <td class="text-center">{{$item->itemKit->name}} </td>
                          
                          
                            <td>
                            <form action="/removeItemFromCarrinho/{{$item->itemKit->id}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-primary" >Remover</button>
                            </form>
                          
                          </td>

                              
                      </tr>
                    @else
                        <tr>
                          <td class="text-center">{{$item->itemKit->name}}</td>
                          <td class="text-center">
                                  <form action="/removeKitFromCarrinho/{{$item->itemKit->id}}" method="POST">
                                          @method('DELETE')
                                          @csrf
                                          <button type="submit" class="btn btn-primary" >Remover</button>
                                  </form>
                          </td>
                        </tr>
                        @endif
                            
                    @endforeach
                 
                  @if (!isset($linhas))
                      
                  <tr>
                    <td>Não existem Items ou Kits no carrinho
                  </tr>
                      
                  @endif
            </tbody>
            </table>                        
            </div>
          </form>

        
          <!-- form -->
          <form  method="POST" action="/reservas" class="form-horizontal form-label-left">
            @csrf
              <!-- campo do Motivo da Reserva -->
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Motivo da Reserva</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="razao_pedido" class="form-control col-md-7 col-xs-12">
              <span id="msg_descricao" name="msg" style="color:red"></span>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Curso e Disciplina Envolvidos</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="curso_disciplina" class="form-control col-md-7 col-xs-12">
            <span id="msg_descricao" name="msg" style="color:red"></span>
            </div>
          </div>



          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Data Inicio</label>
            <div class="col-md-6 col-sm-6 col-xs-12 mp-2">
            <label for="datas">{{session('datas')[0]}}</label>
              </select>  
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Data Fim</label>
            <div class="col-md-6 col-sm-6 col-xs-12 mp-2">
              <label for="datas">{{session('datas')[1]}}</label>
              </select>  
            </div>
          </div>
          
          <div style="color:red">{{session('message')}}</div>

          @if(count($errors->all()) > 0)
                    @foreach ($errors->all() as $error)
                      <div>{{ $error }}</div>
                    @endforeach
                    @endif



          

          <!-- botoes reset e submit -->
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button class="btn btn-primary" type="reset">Recomeça</button>
              <button type="submit" class="btn btn-success">Submeter</button>
              <span id="msg" name="msg" class="control-label col-md-5 col-sm-3 col-xs-12"></span>
            </div>
          </div>
        </form>
            
           

            <!-- botoes reset e submit -->
            
        </div>
      </div>
    </div>
  </div>

    
@endsection