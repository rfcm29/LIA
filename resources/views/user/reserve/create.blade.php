@extends('index')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h2 class="card-title">Nova Reserva</h2>
        </div>
        <form action="{{ route('reserve.create') }}" method="post">
            @csrf
            @method('POST')
            <div class="card-body">
                <div class="form-group">
                    <label for="startDate">Data de Inicio</label>
                    <input name="start_date" type="date" class="form-control">
                    @error('start_date') <span style="color:red" class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="endDate">Data de Fim</label>
                    <input name="end_date" type="date" class="form-control">
                    @error('end_date') <span style="color:red" class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="description">Motivo de requisição</label>
                    <input name="description" type="text" class="form-control">
                    @error('description') <span style="color:red" class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="cost_center_id">Centro de custos</label>
                    <select class="form-control" name="cost_center_id">
                        @foreach ($costCenters as $costCenter)
                            <option value="{{ $costCenter->id }}">{{ $costCenter->name }}</option>
                        @endforeach
                    </select>
                    @error('cost_center') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cria carrinho</button>
            </div>
        </form>
    </div>

@endsection