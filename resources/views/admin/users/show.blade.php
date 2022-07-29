@extends('adminlte::page')

@section('title', 'Utilizadores')

@section('content_header')
    <h1>Perfil de Utilizador</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">
                        {{ $user->name ? $user->name : 'Utilizador' }}
                    </h3>
                    <p class="text-muted text-center">{{ $user->userType->description }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Telefone</b> <a class="float-right">{{ $user->phone }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Estado de Utilzador</b> <a class="float-right">{{ $user->userStatus->description }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Permissões do Utilizador
                    </h3>
                </div>
                <div class="card-body">
                    @foreach ($permissions as $permission)
                        <div class="row align-items-center">
                            <i class="{{ $user->permissions->contains($permission) ? 'far fa-fw fa-check-square' : 'far fa-fw fa-square'}}"></i>
                            <div>{{ $permission->description }}</div>
                        </div>
                    @endforeach 
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary" href="#">Editar Permissões</a>
                </div>
            </div>
        </div>
    </div>
@endsection