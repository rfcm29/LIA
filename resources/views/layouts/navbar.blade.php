<div class="row navbar-blue">
    <div class="col-sm-12">
        <ul class="nav float-sm-right">
                @guest
                    <li class="nav-item bg-blue">
                        <a href="{{ route('login') }}" class="nav-link">LOGIN</a>
                    </li>
                @else
                    <li class="nav-item bg-blue">
                        <a href="/perfil/{{Auth::user()->id}}" class="nav-link">Olá, {{Auth::user()->name}}</a>
                    </li>
                    @if (session()->has('reserve'))
                        <li class="nav-item bg-blue">
                            <a href="/reserve/info" class="nav-link fas fa-shopping-cart" with=90%></a>
                        </li>
                    @else
                        <li class="nav-item bg-blue">
                            <a href="/reserve" class="nav-link fas fa-shopping-cart" with=90%></a>
                        </li>
                    @endif
                    

                    @if (/*Auth::user()*/ true)
                        <li class="nav-item bg-blue">
                            <a href="{{ route('admin.home') }}" class="nav-link">Admin</a>
                        </li>
                    @endif
                    @if (Auth::user()->user_type == 2 || /*Auth::user()->isAdmin()*/true)
                        <li class="nav-item bg-blue">
                            <a href="/lia-space" class="nav-link">Espaço.Lia</a>
                        </li>
                    @endif

                    <li class="nav-item bg-blue">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 d-flex justify-content-center ">
        <nav class="navbar navbar-expand-xl navbar-white navbar-light">
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item">
                    <a class="navbar-brand" href="/">
                        <img src="{{url('/images/logo_1.png')}}" width="90">
                    </a>
                </li>
                <li style="font-size: 1.5rem" class="nav-item">
                    <a class="nav-link" href="/categoria/1">CÂMARAS</a>
                </li>
                <li style="font-size: 1.5rem" class="nav-item">
                    <a class="nav-link" href="/categoria/2">LENTES</a>
                </li>
                <li style="font-size: 1.5rem" class="nav-item">
                    <a class="nav-link" href="/categoria/3">ILUMINAÇÃO</a>
                </li>
                <li style="font-size: 1.5rem" class="nav-item">
                    <a class="nav-link" href="/categoria/4">AUDIO</a>
                </li>
                <li style="font-size: 1.5rem" class="nav-item">
                    <a class="nav-link" href="/categoria/5">TRIPÉS</a>
                </li>
                <li style="font-size: 1.5rem" class="nav-item">
                    <a class="nav-link" href="/categoria/6">ACESSÓRIOS</a>
                </li>
                <li style="font-size: 1.5rem" class="nav-item">
                    <a class="nav-link" href="{{-- route('contactos') --}}">CONTACTOS</a>
                </li>
            </ul>
        </nav>
    </div>
</div>