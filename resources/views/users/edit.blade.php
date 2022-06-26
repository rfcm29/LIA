@extends('layout.layout')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
        <h2>Editar user {{$user->name}}</h2>
          
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br/>

          <!-- form -->
          <form  method="POST" action="/users/{{$user->id}}" class="form-horizontal form-label-left">
            @method('PATCH')
            @csrf
            
               
            <!-- campo da categoria -->
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"> Grupo</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control"name="grupo_id" >
                      @foreach ($grupos as $grupo)
                        <option value="{{$grupo->id}}">{{$grupo->name}}</option>
                      @endforeach
                  </select>                         
                <span id="msg_desc" name="grupo_id" style="color:red"> {{session('message')}}</span>
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