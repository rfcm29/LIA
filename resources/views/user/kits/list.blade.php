@extends('index')

@section('content')
<div>
    <form action="#" method="GET"> 
        <input class="form-control" name="search" type="text" placeholder="Procurar kits..." value="{{ request('search') }}"/>
    </form>
    <br>
    <div class="row">
        @foreach($kits as $kit)
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$kit->description}}</h4>
                        <p class="card-text">{{$kit->lia_code}}</p>
                        <p class="card-text card-text-preco">{{$kit->price}}€</p>
                        <a class="btn btn-primary" href="/kit/{{ $kit->id }}">VER DETALHES</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
