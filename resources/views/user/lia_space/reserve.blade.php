@extends('index')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h2 class="card-title">Nova Reserva</h2>
    </div>
    <form action="{{ route('space.reserve', $space->id) }}" method="post">
        @csrf
        @method('POST')
        <div class="card-body">
            <div class="form-group">
                <label for="space">Espaço a ser reservado</label>
                <input type="text" class="form-control" value="Espaço {{ $space->space_code }}" readonly>
            </div>
            <div class="form-group">
                <label for="startDate">Data de Inicio</label>
                <input name="start_date" type="date" class="form-control" value="{{ $start_date }}" readonly>
            </div>
            <div class="form-group">
                <label for="endDate">Data de Fim</label>
                <input name="end_date" type="date" class="form-control"value="{{ $end_date }}" readonly>
            </div>
            <div class="form-group">
                <label for="description">Motivo da reserva</label>
                <input name="description" type="text" class="form-control" value="{{ old('description') }}">
                @error('description') <span style="color:red" class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="cost_center_id">Centro de custos</label>
                <select class="form-control" name="cost_center_id">
                    @foreach ($costCenters as $costCenter)
                        <option value="{{ $costCenter->id }}">{{ $costCenter->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                @if(collect($users)->isNotEmpty())
                    <label for="ocuppant_id">Ocupante</label>
                    <select class="form-control" name="occupant_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                @else
                    <label for="occupant_email">Email do ocupante</label>
                    <input name="occupant_email" type="text" class="form-control" value="{{ old('occupant_email') }}">
                    @error('occupant_email') <span style="color:red" class="error">{{ $message }}</span> @enderror
                @endif
                
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cria Reserva</button>
        </div>
    </form>
</div>
@endsection