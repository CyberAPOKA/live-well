@extends('layouts.app')

@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a class="breadcrumb" href="{{route('users.index')}}">Administradores</a>
    <a class="breadcrumb" href="{{route('secretario_register')}}">Criar</a>
@endsection
@section('title') Registrar novo secretario @endsection
@section('content')
    @include('layouts.Sessoes.mensagem_green')
    <div class="container">
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('secretario_store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">person_pin</i>
                        <label for="icon_nick">Nome do Secretario: <span style="color: red;">*</span></label>
                        <input name="nick" id="icon_nick" type="text" maxlength="50">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">email</i>
                        <label for="icon_email">E-mail: <span style="color: red;">*</span></label>
                        <input name="email" id="icon_email" type="email" maxlength="50">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">perm_contact_calendar</i>
                        <label for="icon_name">Usuário: <span style="color: red;">*</span></label>
                        <input name="name" id="icon_name" type="text" maxlength="30">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">lock_outline</i>
                        <label for="password">Senha: <span style="color: red;">*</span></label>
                        <input name="password" id="password" type="password" maxlength="30">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">lock</i>
                        <label for="confirm_password">Confirmar senha: <span style="color: red;">*</span></label>
                        <input name="confirm_password" id="confirm_password" type="password" class="validate" maxlength="30">
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <button class="btn-floating btn-large waves-effect waves-light light-blue darken-1" type="submit" name="action">
                            <i class="large material-icons left">add</i>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('js/validation/validation-users/validation-users-create.js')}}"></script>
@endsection