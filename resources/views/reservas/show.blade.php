@extends('layout.layout')

@section('content')
    

    <div class="clearfix"></div>
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
    <h2>Reserva do utilizador {{$user->name}}</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
            <br />
            <div class="form-group">
            <!-- tabela de Reservas -->
            <table id="table" class="table table-striped table-bordered bulk_action dt-responsive text-center nowrap" cellspacing="0" width="100%">
            
            <thead>
                    <tr>
                    <th class="text-center">Reservante</th>
                    <th class="text-center">Email</th>
                    
                    <th class="text-center">Data de Inicio</th>
                    <th class="text-center">Data de Fim</th>
                        
                    
                    <th class="text-center">Estado da Reserva</th>
                    <th class="text-center">Preço</th>
                    
                    </tr>
            </thead>                        
            <tbody>
                    
                            <tr class={{$reserva->emAtraso ? "danger" : "" }} >
                                    <td class="text-center">{{$user->name}} </td>
                                    
                                    <td class="text-center">{{$user->email}}</td>

                                    <td class="text-center">{{$reserva->data_inicio}}</td>

                                    <td class="text-center">{{$reserva->data_fim}}</td>
                                    
                                    <td class="text-center">
                                        @if ($reserva->isConcluido)
                                            Concluida
                                        @else 
                                            @if ($reserva->emAtraso)
                                                Em atraso
                                            @else
                                                @if ($reserva->wasVista && $reserva->isAceite)
                                                    A decorrer
                                                @elseif ($reserva->wasVista && $reserva->isAceite===false)
                                                    Reserva Rejeitada
                                                @else 
                                                    Aguardando Resposta
                                                @endif
                                            @endif

                                            
                                        @endif

                                        

                                    </td>    

                                    <td class="text-center">{{$reserva->preco}}</td>
                                
                            </tr>
                    
            </tbody>
            </table>                        
            </div>


            <div class="form-group">
                <!-- tabela de Reservas -->
                <table id="table" class="table table-striped table-bordered bulk_action dt-responsive text-center nowrap" cellspacing="0" width="100%">
                
                <thead>
                        <tr>
                        <th class="text-center">Nome do Item</th>
                        
                        
                        
                        </tr>
                </thead>                        
                <tbody>
                    
                    
                        @foreach ($linhas['items'] as $item)
                           
                            
                                <tr>
                                        <td class="text-center">{{$item[0]->name}} </td>
                                        
                                       
                                </tr>
                                @endforeach
                                
                        @foreach ($linhas['kits'] as $kit)
                            
                        
                            <tr>
                                    <td class="text-center">{{$kit[0]->name}} </td>
                                    
                            </tr>
                        @endforeach
                        
                </tbody>
                </table>                        
                </div>
            </form>

            @if (session('grupo')->gerirReservas)
        <div class="row">

            <div class="col-md-4" style="text-align:center;">
                <form action="/acceptReserva/{{$reserva->id}}" method="POST">
                    @method('PATCH')
                    @csrf
                    <!-- botoes Aceitar e recusar -->
                        <div class="form-group ">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    
                                <button type="submit" class="btn btn-success">Aceitar</button>
                                <br>
                                <br>
                                <span id="msg" name="msg" class="control-label">{{session('messageAcei')}}</span>
                            </div>
                        </div>
                    </form>
        
            </div>
            
                
            
            <div class="col-md-4" style="text-align:center;">
                <form action="/isConcluida/{{$reserva->id}}" method="POST">
                    @method('PATCH')
                    @csrf
                    <!-- botoes Aceitar e recusar -->
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="submit">Concluir Reserva</button>
                            <br>
                            <br>
                            <span id="msg" name="msg" style="margin-top:10%" class="control-label">{{session('messageConc')}}</span>
                        </div>
                    </div>
                    </form>
            </div>
            <div class="col-md-4 "style="text-align:center;">
                <form action="/refuseReserva/{{$reserva->id}}" method="POST">
                    @method('PATCH')
                    @csrf
                    <!-- botoes Aceitar e recusar -->
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-danger" type="submit">Recusar</button>
                            <br>
                            <br>
                            <span id="msg" name="msg" class="control-label">{{session('messageRec')}}</span>
                        </div>
                    </div>
                    </form>
            </div>
            

        </div>
        
        <div class="row">
            <div class="col-md-12">
                <form action="/pdf_download/{{$reserva->id}}" style="text-align:center; margin-top:2%" method="post">
                    @csrf
                    
                    <button class="btn btn-primary" type="submit">Download PDF</button>
                    
                </form>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div style="text-align:center; margin-top:2%">
                        <a href="/reservas/{{$reserva->id}}/edit" class="btn btn-primary">Editar</a>
                        
                    </div>

                </div>
            </div>
            
        @endif
        @if ($reserva->isConcluido)
            <div class="row" style="margin-top:3%">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Data de Entrega</div>
                        <div class="panel-body">
                           
                        <h5>{{$reserva->data_entrega}}</h5>
                        </div>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Estado Na Entrega</div>
                        <div class="panel-body">
                           
                        <h5>{{$reserva->estado_entrega}}</h5>
                        </div>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Observações</div>
                        <div class="panel-body">
                           
                        <h5>{{$reserva->observacoes}}</h5>
                        </div>
                      </div>
                </div>
            </div>
            
                
            @endif
    </div>
    </div>
    </div>
    </div>

@endsection