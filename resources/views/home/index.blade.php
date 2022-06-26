@extends('layout.layout')

@section('content')

@if (session('grupo')->name==='default')
    <h2>A sua conta encontra-se em fase de aprovação, poderá fazer reservas quando for aprovado</h2>
@endif


<img class="img-responsive" src="/images/default.png" alt="..." >
    
@endsection