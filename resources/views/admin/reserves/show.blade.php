@extends('adminlte::page')

@section('title', 'Kits')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Reserva</h1>
    </div>
    <div class="col-sm-6">
        <div class="float-sm-right">
            @if ($reserve->reserveState->id == 2)
                <a href="{{ route('pdf-download', $reserve->id) }}" class="btn btn-block btn-outline-primary">
                    <i class="fas fa-light fa-file-pdf"></i>
                    Download pdf
                </a>
            @endif
        </div>
    </div>
</div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        RESERVANTE
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Nome:</b>
                                <div class="float-right">{{ $reserve->user->name }}</div>
                            </li>
                            <li class="list-group-item">
                                <b>Email:</b>
                                <div class="float-right">{{ $reserve->user->email }}</div>
                            </li>
                            <li class="list-group-item">
                                <b>Telefone:</b>
                                <div class="float-right">{{ $reserve->user->phone }}</div>
                            </li>
                        </ul>
                    </div>  
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        INFO RESERVA
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Descrição: </b>{{ $reserve->description }}
                            </li>
                            <li class="list-group-item">
                                <b>Data de inicio: </b> {{ $reserve->start_date }}
                            </li>
                            <li class="list-group-item">
                                <b>Data de fim: </b>{{ $reserve->end_date }}
                            </li>
                            <li class="list-group-item">
                                <b>Estado da reserva: </b>{{ $reserve->reserveState->description }}
                            </li>
                            <li class="list-group-item">
                                <b>Centro de custos: </b>{{ $reserve->costCenter->name }}
                            </li>
                            <li class="list-group-item">
                                <b>Custo: </b>{{ $reserve->cost }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card card-primary card-outline">
            <div class="card-header">
                    KITS A SER RESERVADOS
            </div>
            <div class="card-body">
                <ul class="list-group list-group-unbordered">
                    @foreach ($reserve->kits as $kit)
                        @if ($kit->kits->isEmpty())
                            <li class="list-group-item">{{ $kit->lia_code }} - {{$kit->description }}</li>
                        @else
                            <li class="list-group-item" data-toggle="collapse" data-target="#collapseOne">{{ $kit->lia_code }} - {{$kit->description }}</li>
                            <div id="collapseOne" class="collapse">
                                @foreach ($kit->kits as $item)
                                    <li class="list-group-item">{{ $item->lia_code }} - {{$item->description }}</li>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="container-fluid">
                @if ($reserve->reserveState->id == 1)
                    <form action="{{ route('reserve.autorize', $reserve->id) }}" method="post">
                        @csrf
                        @method('POST')
                        <button type="send" class="btn btn-success">Autorizar</button>
                    </form>
                    <form action="{{ route('reserve.decline', $reserve->id) }}" method="post">
                        @csrf
                        @method('POST')
                        <button type="send" class="btn btn-danger">Recusar</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection