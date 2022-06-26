@extends('layout.layout')

@section('content')
    

    <div class="clearfix"></div>
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
        <div class="row">
            
            
            <div class="col-md-6">
                <h2>@if (isset($titulo))
                    {{$titulo}}
                
                @else 
                Todas as reservas
                @endif
                    
                </h2>
            </div>
            <div class="col-md-6">
              <form action="/searchReservas" method="POST">
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
                        <input type="date" name="data_entre_fim" >
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
            </form>
                    
            </div>
          
          </div>
            
            <div class="clearfix"></div>
    </div>
    <div class="x_content">
            <br />
            <div class="row">
                <div class="col-md-2">
                    <!-- campo da permissao ver itens escondidos -->
                    <div class="form-group">
                        
                        <a href="/reservas" class="btn btn-primary">Todas</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <!-- campo da permissao ver itens escondidos -->
                    <div class="form-group">
                        
                        <a href="/reservasPendentes" class="btn btn-primary">Reservas Pendentes</a>
                    </div>
                </div>
                
                <div class="col-md-2">
                    
                    <div class="form-group">
                         <a href="/reservasDecorrer" class="btn btn-primary">Em progresso</a>
                        
                        </div>
                </div>
                <div class="col-md-2">
                   
                    <div class="form-group">
                         <a href="/reservasRejeitadas" class="btn btn-primary">Rejeitadas</a>
                        
                    </div>
                </div>
                <div class="col-md-2">
                   
                    <div class="form-group">
                        <a href="/reservasConcluidas" class="btn btn-primary">Concluidas</a>
                        
                        </div>
                </div>
                <div class="col-md-2">
                   
                    <div class="form-group">
                        <a href="/reservasAtraso" class="btn btn-primary">Em Atraso</a>
                            
                        </div>
                </div>
            </div>
        
        <br/>
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
                    <th class="text-center">Curso/Disciplina</th>
                    <th class="text-center">Editar Reservas </th>
                    
                    </tr>
            </thead>                        
            <tbody>
                
                    @foreach ($listaReservas as $reserva)
                    
                            <tr class={{$reserva[0]->emAtraso ? "danger" : "" }} >
                                    <td class="text-center">{{$reserva[1]->name}} </td>
                                    
                                    <td class="text-center">{{$reserva[1]->email}}</td>

                                    <td class="text-center">{{$reserva[0]->data_inicio}}</td>

                                    <td class="text-center">{{$reserva[0]->data_fim}}</td>
                                    
                                    <td class="text-center">
                                        @if ($reserva[0]->isConcluido)
                                            Concluida
                                        @else 
                                            @if ($reserva[0]->emAtraso)
                                                Em atraso
                                            @else
                                                @if ($reserva[0]->wasVista && $reserva[0]->isAceite)
                                                    A decorrer
                                                @elseif ($reserva[0]->wasVista && !$reserva[0]->isAceite)
                                                    Reserva Rejeitada
                                                @else
                                                    Aguardando Resposta
                                                @endif
                                            @endif

                                        @endif

                                        

                                    </td>    

                                    <td class="text-center">{{$reserva[0]->curso_disciplina}}</td>
                                    <td class="text-center">
                                        <a href="/reservas/{{$reserva[0]->id}}" class="btn btn-primary" >Ver Reserva</a>
                                
                                    </td>
                                        
                                     
                            </tr>
                    @endforeach
            </tbody>
            </table>                        
            </div>
            
    </div>
    </div>
    </div>
    </div>

@endsection