@extends('adminlte::page')

@section('title', 'Kits')

@section('content_header')
    <h1>Novo espaço {{ $id }}</h1>
@stop

@section('content')
    <form action="{{ route('space.store', $id) }}" method="post">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="description">Descrição</label>
            <input class="form-control" type="text" name="description" id="description">
            <span style="color:red">{{$errors->first('description')}}</span>
        </div>

        <div class="form-group">
            <label for="lia_code">Custo</label>
            <input class="form-control" type="text" name="lia_code" id="lia_code">
            <span style="color:red">{{$errors->first('lia_code')}}</span>
        </div>

        <div class="form-group">
            <label for="price">Custo</label>
            <input class="form-control" type="number" name="price" id="price">
            <span style="color:red">{{$errors->first('price')}}</span>
        </div>

        <div class="form-group">
            <h3 class="content-header">Constituição do espaço</h3>
            <button type="button" class="btn btn-primary" onclick="addItem()">Adicionar novo item</button>
            <ul class="list-group" id="list">
                <li class="list-group-item">
                    <div class="row">
                        <input type="text" class="form-control" name="itens[1]" id="itens[1]">
                    </div>
                </li>
            </ul>
            <span style="color:red">{{$errors->first('itens.*')}}</span>
        </div>

        <button type="submit" class="btn btn-success">Criar</button>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        var i;
        function addItem(){
            i++;
            var markup = 
                '<li class="list-group-item">' +
                    '<div class="row">' +
                        '<input type="text" class="form-control col-11" name="itens[' + i +']" id="itens[' + i +']">' +
                        '<button type="button" class="btn btn-danger" onclick="removeItem(this)">Remover</button>' +
                    '</div>' +
                '</li>' ;
            $('#list').append(markup);
        }

        function removeItem(btn){
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        }
    </script>
@endsection