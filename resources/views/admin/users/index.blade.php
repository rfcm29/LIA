@extends('adminlte::page')

@section('title', 'Utilizadores')

@section('content_header')
    <h1>Utilizadores</h1>
@stop

@section('content')
    <div class="container-fluid">
        <table id="users" class="table table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Tipo de Utilizador</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->userStatus->description }}</td>
                        <td>{{ $user->userType->description }}</td>
                        <td><a href="{{ route('user.show', $user->id) }}" class="btn btn-primary">Ver Utilizador</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script>
        jQuery(function($){
            var table = 
            $('#users').DataTable({
                "columnDefs": [{ targets: 'no-sort', orderable: false }]
            });
        })
    </script>
@endsection