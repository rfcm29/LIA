@extends('adminlte::page')

@section('title', 'Kits')

@section('content_header')
    <h1>Novo Kit</h1>
@stop

@section('content')
    <div class="d-flex flex-column">
        <form action="{{ route('kits.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}">
                <span style="color:red">{{$errors->first('description')}}</span>
            </div>
            <div class="form-group">
                <label for="lia_code">Codigo LIA</label>
                <input type="text" name="lia_code" class="form-control" value="{{ old('lia_code') }}">
                <span style="color:red">{{$errors->first('lia_code')}}</span>
            </div>
            <div class="form-group">
                <label for="ref_ipvc">Referência IPVC</label>
                <input type="text" name="ipvc_ref" class="form-control" value="{{ old('ipvc_ref') }}">
                <span style="color:red">{{$errors->first('ref_ipvc')}}</span>
            </div>
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select class="form-control" name="category">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="text" name="price" id="preco" class="form-control" value="{{ old('price') }}">
                <span style="color:red">{{$errors->first('price')}}</span>
            </div>
            <div class="form-group">
                <label for="">Imagem para Kit</label>
                <input type="file" class="form-control-file" name="image" id="image">
            </div>

            <h1>Itens</h1>
            <button type="button" class="addItem btn btn-primary">Adicionar Item</button>

            <table id="tableItem" class="table">
                <tbody>
                    @isset($itens)
                        @foreach ($itens as $item)
                            <tr>
                                <td>
                                    <label for="">Descrição</label>
                                </td>
                            </tr>
                        @endforeach 
                    @endisset   
                </tbody>
            </table>
            <table id="tableKit" class="table">
                <tbody>
                    <tr>
                        <td>
                            <select name="kits[]" class="form-control" id="kits" multiple>
                                @foreach ($kits as $kit)
                                    <option value="{{ $kit->id }}" {{ (collect(old('kits'))->contains($kit->id)) ? 'selected':'' }}>{{ $kit->lia_code }} - {{ $kit->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Criar Kit</button>
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
    $(document).ready(function(){
        var i = 0;
        $(".addItem").click(function(){
            i++
            var markup =
                "<tr>" +
                    '<td>' +
                        '<label for="itens">Descrição</label>' +
                        '<input type="text" name="itens['+i+'][description]" class="form-control" > </td>' +
                        '<td> <label for="itens">Modelo</label>' +
                        '<input type="text" name="itens['+i+'][model]" class="form-control"> </td>' +
                        '<td> <label for="itens">Serial Number</label>' +
                        '<input type="text" name="itens['+i+'][serial_number]" class="form-control"> </td>' +
                        '<td><label for="itens">Referencia IPVC</label>' +
                        '<input type="text" name="itens['+i+'][ipvc_ref]" class="form-control">' +
                    '</td>' +
                    '<td>' +
                        '<input type="button" class="btn btn-danger" value="Remover" onclick="deleteRowItem(this)">' +
                    '</td>' +
                "</tr>" ;
            $("#tableItem tbody").append(markup);
        });
        $("#kits").select2({
            placeholder: 'Selecione os kits para adicionar'
        });
    });

    function deleteRowItem(btn){
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function deleteRowKit(btn){
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        $(".addKit").trigger
    }
    </script>
@endsection