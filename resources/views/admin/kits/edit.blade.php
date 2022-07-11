@php
$i = 0
@endphp
@extends('adminlte::page')

@section('title', 'Kits')

@section('content_header')
    <h1>{{ $kit->description }}</h1>
@stop

@section('content')
    <div class="d-flex flex-column">
        <form action="{{ route('kits.update', $kit->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $kit->description) }}">
                <span style="color:red">{{$errors->first('description')}}</span>
            </div>
            <div class="form-group">
                <label for="lia_code">Codigo LIA</label>
                <input type="text" name="lia_code" class="form-control" value="{{ old('lia_code', $kit->lia_code) }}">
                <span style="color:red">{{$errors->first('lia_code')}}</span>
            </div>
            <div class="form-group">
                <label for="ref_ipvc">Referência IPVC</label>
                <input type="text" name="ipvc_ref" class="form-control" value="{{ old('ipvc_ref', $kit->ipvc_ref) }}">
                <span style="color:red">{{$errors->first('ref_ipvc')}}</span>
            </div>
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select class="form-control" name="category">
                    @foreach ($categories as $category)
                        @if ($category->id == $kit->kitCategory->id)
                            <option value="{{ $category->id }}" selected>{{ $category->description }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->description }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="text" name="price" id="preco" class="form-control" value="{{ old('price', $kit->price) }}">
                <span style="color:red">{{$errors->first('price')}}</span>
            </div>

            <h1>Itens</h1>
            <button type="button" class="addItem btn btn-primary">Adicionar Item</button>

            <table id="tableItem" class="table">
                <tbody>
                    @foreach ($kit->items as $item)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <td>
                                <label for="descricao">Descrição</label>
                                <input type="text" name="itens[{{ $item->id }}][description]" class="form-control" value="{{ $item->description }}">
                            </td>
                            <td>
                                <label for="descricao">Modelo</label>
                                <input type="text" name="itens[{{ $item->id }}][model]" class="form-control" value="{{ $item->model }}">
                            </td>
                            <td>
                                <label for="descricao">Serial Number</label>
                                <input type="text" name="itens[{{ $item->id }}][serial_number]" class="form-control" value="{{ $item->serial_number }}">
                            </td>
                            <td>
                                <label for="descricao">Referencia IPVC</label>
                                <input type="text" name="itens[{{ $item->id }}][ipvc_ref]" class="form-control" value="{{ $item->ipvc_ref }}">
                            </td>
                            <td>
                                <input type="button" class="btn btn-danger" value="Remover" onclick="deleteRowItem(this)">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table id="tableKit" class="table">
                <tbody>
                    <tr>
                        <td>
                            <select name="kits[]" class="form-control" id="kits" multiple>
                                @foreach ($kits as $formKit)
                                    @if($kit->kits)
                                        @foreach ($kit->kits as $item)
                                            @if ($item->id == $formKit->id)
                                                <option value="{{ $formKit->id }}" selected>{{ $formKit->lia_code }} - {{ $formKit->description }}</option>
                                            @else
                                                <option value="{{ $formKit->id}}">{{ $formKit->lia_code }} - {{ $formKit->description }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="{{ $formKit->id }}" {{ (collect(old('kits'))->contains($formKit->id)) ? 'selected':'' }}>{{ $formKit->lia_code }} - {{ $formKit->description }}</option>
                                    @endif
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
        var i = {{ $i }};
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