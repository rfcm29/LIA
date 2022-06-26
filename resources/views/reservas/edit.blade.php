@extends('layout.layout')

@section('content')


    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2>Editar Reserva</h2>
                
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br/>
                @if ($reserva->isConcluido)
                    <!-- form -->
                <form  method="POST" action="/reservas/{{$reserva->id}}" class="form-horizontal form-label-left">
                    @method('PATCH')
                    @csrf
                    
                    
                        <!-- campo da data de Entrega -->
                    <div class="form-group">
                        
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="data">Data de Entrega</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="date"name="data_entrega" value={{$reserva->data_entrega}}/>
                            <span id="data_entrega" name="data_entrega" style="color:red"></span>
                        </div>
                        </div>
                        
                    
                       
                    <!-- campo do estado-->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado da Entrega </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="desc" name="estado_entrega" >
                                    
                                    <option value="Completo sem Defeitos">Completo sem defeitos</option>
                                    <option value="Completo com Defeitos">Completo com defeitos</option>
                                    <option value="Componentes em Falta">Componentes em falta</option>
                                
                            </select>    
                            <span id="" name="estado_entrega" style="color:red"></span>
                        </div>
                        </div> 

                    <!-- campo da marca -->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="marca">Observações </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea type="text" name="observacoes" class="form-control col-md-7 col-xs-12">
                            {{$reserva->observacoes}}
                        </textarea>
                        <span id="msg_marca" name="msg" style="color:red"></span>
                    </div>
                    </div>

                    


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
                
                
                @else
                    <h2>A reserva tem de estar concluida para a poder editar</h2>
                @endif
                
            </div>
        </div>
        </div>
    </div>

   
    
    
@endsection