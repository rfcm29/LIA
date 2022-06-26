@extends('layout.layout')

@section('content')
    

    <div class="clearfix"></div>
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
        <h2>Carrinho</h2>
        <div class="clearfix"></div>
</div>
    <div class="x_content">
        <br />

        
        

        <div class="form-group">
        <!-- tabela de utilizadores -->
        <table id="table" class="table table-striped table-bordered bulk_action dt-responsive text-center nowrap" cellspacing="0" width="100%">
        
        <thead>
                <tr>
                <th class="text-center">Item Name</th>
                <th class="text-center">Remover</th>
                
                
                </tr>
        </thead>                        
        <tbody>
                
                @foreach ($linhas as $item)
                        @if ($item instanceof \App\Item)
                        <tr>
                       
                                <td class="text-center">{{$item->itemKit->name}} </td>
                        

                                <td class="text-center">
                                        <form action="/insertItemCarrinho/{{$item->itemKit->id}}"method="POST">
                                                @method('PATCH')
                                                @csrf
                                                <input type="hidden" name ="pag"value="0">
                                                <input name="id" value="{{$item->itemKit->id}}" hidden>
                                                <button type="submit" class="btn btn-success" >Adicionar</button>
                                        </form>
                                
                                </td>
                                <td class="text-center">
                                        <form action="/removeItemCarrinho/{{$item->itemKit->id_atributos}}"method="POST">
                                                @method('PATCH')
                                                @csrf
                                                <input type="hidden" name ="pag" value="0">
                                                <input name="id" value="{{$item->itemKit->id}}" hidden>
                                                <button type="submit" class="btn btn-danger" >Remover</button>
                                        </form>
                                
                                </td>
                                
                        </tr>
                        @else
                        <tr>
                                <td class="text-center">{{$item->itemKit->name}} </td>
                            
                                <td class="text-center">
                                        <form action="/removeItemCarrinho/{{$item->itemKit->id_atributos}} "method="POST">
                                                @method('PATCH')
                                                @csrf
                                                <input name="id" value="{{$item->itemKit->id}}" hidden>
                                                <input type="hidden" name ="pag" value="0">
                                                <button type="submit" class="btn btn-danger" >Remover</button>
                                        </form>
                                </td>
        
                            
                    </tr>
                        @endif
                        

                @endforeach
                

        </tbody>
        </table>                        
        </div>
        
        
</div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>





@endsection