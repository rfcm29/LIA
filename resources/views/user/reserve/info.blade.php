@extends('index')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Informações da reserva</h3>
        </div>

        <div class="card-body">
            <div>
                <div class="callout callout-info">
                    <h5>Motivo de reserva</h5>
                    <p>{{ session()->get('reserve.description') }}</p>
                </div>
                <div class="callout callout-info">
                    <h5>Data de Inicio</h5>
                    <p>{{ session()->get('reserve.start_date') }}</p>
                </div>
                <div class="callout callout-info">
                    <h5>Data de fim</h5>
                    <p>{{ session()->get('reserve.end_date') }}</p>
                </div>
                <div class="callout callout-info">
                    <h5>Kits a ser reservados</h5>
                    @if (session()->has('reserve.kits'))
                        <table class="table">
                            <tbody>
                                @foreach (session()->get('reserve.kits') as $kit)
                                    <tr>
                                        <td>{{ $kit->description }}</td>
                                        <td>{{ $kit->price }}</td>
                                        <td>
                                            <form action="{{ route('kit.remove', ['id' => $kit->id]) }}" method="post">
                                                @csrf
                                                @method('POST')
                                                <button type="send" class="btn btn-danger float-end">Retirar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-auto">
                    <form action="{{ route('reserve.cancel') }}" method="post">
                        @csrf
                        @method('POST')
                        <button type="send" class="btn btn-danger">CANCELAR RESERVA</button>
                    </form>
                </div>
                <div class="col-md-auto">
                    <form action="{{ route('reserve.confirm') }}" method="post">
                        @csrf
                        @method('POST')
                        <button type="send" class="btn btn-primary">CONCLUIR RESERVA</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection