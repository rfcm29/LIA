@extends('layout.layout')

@section('content')

<div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Criar grupo </h2>
            <div class="clearfix"></div>
          </div>
            <div class="x_content">
            <br />
                <form id="demo-form2"  action="/grupos" method="POST" class="form-horizontal form-label-left">
                    @csrf

                    <!-- campo descricao -->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Nome <span style="color:red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                        <span id="msg_descricao" name="msg" style="color:red"></span>
                    </div>
                    </div>
                    
                    <!-- campo da permissao ver kits -->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gerir items e kits</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="radio" class="flat" name="gerirItemsKits" value="1" checked> Sim<br>
                        <input type="radio" class="flat" name="gerirItemsKits" value="0"> Não<br>
                        <span id="msg_ver" name="msg" style="color:red"></span>
                    </div>
                    </div>

                    <!-- campo da permissao reservar kits -->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gerir Reservas</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="radio" class="flat" name="gerirReservas" value="1" checked> Sim<br>
                        <input type="radio" class="flat" name="gerirReservas" value="0"> Não<br>
                        <span id="msg_reservar" name="msg" style="color:red"></span>
                    </div>
                    </div>

                    <!-- campo da permissao ver itens escondidos -->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gerir Grupos</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="radio" class="flat" name="gerirGrupos" value="1" checked> Sim<br>
                        <input type="radio" class="flat" name="gerirGrupos" value="0"> Não<br>
                        <span id="msg_ver_admin" name="msg" style="color:red"></span>
                    </div>
                    </div>

                    <!-- campo da permissao editar reservas -->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gerir Categorias</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="radio" class="flat" name="gerirCategorias" value="1" checked> Sim<br>
                        <input type="radio" class="flat" name="gerirCategorias" value="0"> Não<br>
                        <span id="msg_reservas" name="msg" style="color:red"></span>
                    </div>
                    </div>

                    <!-- campo da permissao criar e editar -->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gerir Centros de Custos</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="radio" class="flat" name="gerirCentros" value="1" checked> Sim<br>
                        <input type="radio" class="flat" name="gerirCentros" value="0"> Não<br>
                        <span id="msg_criar_editar" name="msg" style="color:red"></span>
                    </div>
                    </div>

                    <!-- campo da permissao ver utilizadores -->
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gerir Users</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="radio" class="flat" name="gerirUsers" value="1" checked> Sim<br>
                        <input type="radio" class="flat" name="gerirUsers" value="0"> Não<br>
                        <span id="msg_user_ver" name="msg" style="color:red"></span>
                    </div>
                    </div>

                    <!-- campo da permissao ver utilizadores -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fazer Reservas</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="radio" class="flat" name="reservar" value="1" checked> Sim<br>
                            <input type="radio" class="flat" name="reservar" value="0"> Não<br>
                            <span id="msg_user_ver" name="msg" style="color:red"></span>
                        </div>
                        </div>
   
                    <!-- botoes reset e submit -->
                    <div class="ln_solid"></div>
                    <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Submeter</button>
                        <span id="msg" name="msg" class="control-label col-md-5 col-sm-3 col-xs-12"></span>
                    </div>
                    </div>
                </form>

                @if(count($errors->all()) > 0)
                    @foreach ($errors->all() as $error)
                      <div>{{ $error }}</div>
                    @endforeach
                    @endif


            </div>
        </div>
    </div>
    </div>
</div>
</div>

    
@endsection

