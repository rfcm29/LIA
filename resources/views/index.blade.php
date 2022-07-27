@extends('adminlte::master')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
@endsection

@section('body')
    @include('layouts.navbar')
    <div class="wrapper">
        <div class="{{ config('adminlte.classes_content') ?: 'container' }}">
            @yield('content')
        </div>
    </div>
@endsection

@section('adminlte_js')

@stop

