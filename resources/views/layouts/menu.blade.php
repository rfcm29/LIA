@extends('index')

@section('content')
    <div class="row">
        @foreach ($categories as $category)
            <div class="col-sm-4">
                <div class="card categoria-container">
                    <img src="{{ $category->image }}" width="100%"/>
                    <div class="nome">
                        <div class="nome-texto">
                            <a href="/categoria/1">{{ $category->description }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection