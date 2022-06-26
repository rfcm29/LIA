@extends('layout.layout')

@section('content')
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Criar item</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br/>

                    <!-- form -->
                    <form  method="POST" action="/items" class="form-horizontal form-label-left">
                        @csrf
                      
                            <!-- campo da nome -->
                      <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text"name="name" class="form-control col-md-7 col-xs-12">
                              <span id="name" name="name" style="color:red"></span>
                            </div>
                          </div>
                        
                          <!-- campo da descricao -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Descrição </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="descricao" class="form-control col-md-7 col-xs-12">
                          <span id="msg_descricao" name="msg" style="color:red"></span>
                        </div>
                      </div>

                      

                      <!-- campo da marca -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="marca">Marca </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="marca" class="form-control col-md-7 col-xs-12">
                          <span id="msg_marca" name="msg" style="color:red"></span>
                        </div>
                      </div>

                      <!-- campo do modelo -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="modelo">Modelo </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="modelo" class="form-control col-md-7 col-xs-12">
                          <span id="msg_modelo" name="msg" style="color:red"></span>
                        </div>
                      </div>
                      
                      <!-- campo do serial number -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="serialnumber">Serial Number </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="serial_number" class="form-control col-md-7 col-xs-12" min="1">
                          <span id="msg_serialnumber" name="msg" style="color:red"></span>
                        </div>
                      </div>

                      

                      <!-- campo do serial ipvc 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipvcnumber">Serial IPVC </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="serial_ipvc" class="form-control col-md-7 col-xs-12" min="1">
                          <span id="msg_ipvcnumber" name="msg" style="color:red"></span>
                        </div>
                      </div>

                      -->

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ipvcnumber">Preço</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" name="preco" class="form-control col-md-7 col-xs-12" min="1">
                            <span id="msg_ipvcnumber" name="msg" style="color:red"></span>
                          </div>
                        </div>

                      <!-- campo do visivel -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Visivel</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="radio" class="flat" name="visivel" value="1" checked> Sim<br>
                          <input type="radio" class="flat" name="visivel" value="0"> Não<br>
                          <span id="msg_visivel" name="msg" style="color:red"></span>
                        </div>
                      </div>

                      <!-- campo da categoria -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Categoria </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control"name="categoria" >
                                @foreach ($categorias as $categoria)
                                  <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                                @endforeach
                            </select>                         
                          <span id="msg_desc" name="categoria" style="color:red"></span>
                        </div>
                      </div>

                      <!-- campo da fotografia -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Fotografia </label>
                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                          <input type="file"name="fotografia_caminho" class="form-control col-md-7 col-xs-12" />
                          <span id="msg_image"style="color:red"></span>
                        </div>
                        <div class="control-label">
                          <!-- tooltip -->
                          <a  data-toggle="tooltip" title="A imagem tem de ter uma extensão válida (JPEG/JPG/PNG) e também tem como limite 10 mb! " class="fa fa-info fa-lg pull-left"></a>
                        </div>
                      </div>

                      <!-- campo da quantidade -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Quantidade de itens a inserir <span style="color:red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">                         
                          <input type="number" name="quantidade" class="form-control col-md-7 col-xs-12" min="1" max ="20">
                          <span id="msg_qtd" name="msg" style="color:red"></span>
                        </div>
                        <div class="control-label">
                          <!-- tooltip -->
                          <a  data-toggle="tooltip" title="Tem de indicar a quantidade de itens deseja criar com esta informação, tem como limite 20 itens!" class="fa fa-info fa-lg pull-left"></a>
                        </div>
                      </div>
                      <div class="form-group">
                          <div class="ln_solid"></div> 
                      </div>

                      

                    @if(count($errors->all()) > 0)
                    @foreach ($errors->all() as $error)
                      <div>{{ $error }}</div>
                    @endforeach
                    @endif


                     

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

