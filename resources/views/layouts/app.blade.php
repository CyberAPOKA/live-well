<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SEMEL</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        {!! MaterializeCSS::include_full() !!}

        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{asset('css/validation.css')}}">
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    </head>
    <body>
        <header>
            <div class="navbar-fixed">
                <nav class="#039be5 light-blue darken-1">
                    <div class="container nav-wrapper">
                        <a href="{{route('home')}}" class="brand-logo center"><b>Viver Bem</b></a>
                        <div class="col s12">
                            @guest
                                <ul id="nav-mobile" class="right">
                                    <li><a href="{{route('login')}}"><b>Login</b></a></li>
                                </ul>
                            @else
                                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                <ul class="left hide-on-med-and-down">
                                    @php
                                        $nickusuario = explode(' ', auth()->user()->nick);
                                    @endphp
                                    <h6><b>Usuário: &emsp;{{$nickusuario[0]}}</b></h6>
                                    <h6><b>Nível: &emsp;&emsp; @can('autorizacao', 3) Administrador @else Professor @endcan</b></h6>
                                </ul>
                                <ul id="nav-mobile" class="right">
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons left">exit_to_app</i><b>{{ __('Sair') }}</b></a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                    </li>
                                </ul>
                            @endguest
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        @guest
            <main>
                @yield('content')
            </main>
        @else
            <div class="row">
                <div class="section">
                    <div class="col m2 hide-on-med-and-down">
                        <ul class="collapsible">
                            @can('autorizacao', 3)
                                @include('layouts.menu')
                            @else
                                <div class="collection">
                                    <b><a class="collection-item" href="{{Route('professor_turmas', auth()->user()->permissao)}}" style="color: #039be5;">Minhas turmas</a></b>
                                    <b><a class="collection-item" href="{{Route('professor_info', $professor->id)}}" style="color: #039be5;">Minhas informações</a></b>
                                </div>
                            @endcan
                        </ul>
                    </div>
                    <div class="col m12 l10">
                        <div class="card-panel" style="border-radius: 25px;">
                            <nav class="hide-on-med-and-down" style="border-radius: 25px;">
                                <div class="nav-wrapper blue" style="border-radius: 25px;">
                                    <div class="container"><b>@yield('breadcrumbs')</b></div>
                                </div>
                            </nav>
                            <div class="container">
                                <h2><b>@yield('title')</b></h2>
                            </div>
                            <br><br>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <ul class="sidenav grey lighten-2" id="mobile-demo">
                <div class="row">
                    <div class="col s12 blue white-text">
                    @php $nickusuario = explode(' ', auth()->user()->nick); @endphp
                    <h6><b>Usuário: &emsp;{{$nickusuario[0]}}</b></h6>
                    <h6><b>Nivel: &emsp;&emsp; @can('autorizacao', 3) Administrador @else Professor @endcan</b></h6>
                    </div>
                    <div class="col s12">
                        <div class="card">
                            <ul class="collapsible">
                                @include('layouts.menu')
                            </ul>
                        </div>
                    </div>
                </div>
            </ul>
        @endguest
        <script>M.AutoInit();</script>
        <script src="{{asset('js/messages_pt_BR.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/modais.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/script.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/ajax.js')}}"></script>
    </body>
</html>