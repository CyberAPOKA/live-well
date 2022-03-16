@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="container">
            <br><br>
            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="card" style="border-radius: 25px;">
                    <div class="row card-action light-blue darken-1" style="border-radius: 25px;">
                        <div class="col s5">
                            <h3 style="color: white;"><b>Fazer Login</b></h3>
                        </div>
                        <div class="col s5 right" style="margin-top: 8%; margin-right: 10%;">
                            @include('layouts.Sessoes.mensagem_red')
                            @include('vendor.sessionout.notify')
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-content">
                            <div class="form-field">
                                <label for="identity"><h6>Usuário</h6></label>
                                <input type="text" id="identity" name="identity" required>
                            </div>
                            <br>
                            <div class="form-field">
                                <label for="password"><h6>Senha</h6></label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <br>
                            <div class="form-field center-align">
                                <button id="enter" class="btn-large light-blue darken-1">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
