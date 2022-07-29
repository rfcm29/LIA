@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')
    <div class="row">
        @foreach ($categories as $category)
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $category->description }}</h3>
                    </div>
                    <div class="card-content">
                        <img src="../{{ $category->image}}" width="100%">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ route('category.create') }}" class="btn btn-primary">Nova categoria</a>
@endsection