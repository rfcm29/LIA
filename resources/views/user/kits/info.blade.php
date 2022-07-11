@extends('index')

@section('content')
    <div>
        <div class="container">
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <img src="https://images.unsplash.com/photo-1510127034890-ba27508e9f1c?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2250&q=80" width="100%">
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">
                                {{ $kit->description }}
                            </h3>
                            <p>{{ $kit->kitCategory->description }}</p>
                            <hr>
                            <h4>Preço</h4>
                            <h5>{{ $kit->price }} €</h5>
                            <div class="mt-4">
                                <form action="{{ route('kit.add', ['id' => $kit->id]) }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <button type="send" class="btn btn-primary btn-lg">
                                        <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                        ADICIONAR À RESERVA
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><h3>Conteudo do Kit</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kit->items as $item)
                                    <tr>
                                        <th>{{ $item->description }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection