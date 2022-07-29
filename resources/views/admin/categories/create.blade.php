@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Nova Categoria</h1>
@stop

@section('content')
    <form action="{{ route('category.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="description">Descrição</label>
            <input class="form-control" type="text" name="description" id="description">
        </div>
        <div class="form-group">
            <label for="">Imagem para categoria</label>
            <input type="file" class="form-control-file" name="image" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Criar categoria</button>
    </form>
@endsection