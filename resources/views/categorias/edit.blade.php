@extends('layout.layout')

@section('content')
<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Criar Categoria</h2>
              
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br/>

              <!-- form -->
            <form  method="POST" action="/categorias/{{$categoria->id}}" class="form-horizontal form-label-left">
                @method('PATCH')
                  @csrf
                  
                
                      <!-- campo da nome -->
                <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text"name="name" class="form-control col-md-7 col-xs-12" value="{{$categoria->name}}">
                        <span id="name" name="name" style="color:red"></span>
                      </div>
                    </div>
                  
                    <!-- campo da descricao -->
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Descrição </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="descricao" class="form-control col-md-7 col-xs-12"  value="{{$categoria->descricao}}">
                    <span id="msg_descricao" name="msg" style="color:red"></span>
                  </div>
                </div>

                

               

                <!-- botoes reset e submit -->
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Recomeça</button>
                    <button type="submit" class="btn btn-success">Submeter</button>
                    <span id="msg" name="msg" class="control-label col-md-5 col-sm-3 col-xs-12"></span>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

@endsection