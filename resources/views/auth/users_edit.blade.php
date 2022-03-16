@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a class="breadcrumb" href="{{route('users.index')}}">Administradores</a>
    <a class="breadcrumb" href="{{route('users.edit', $user->id)}}">Editar</a>
@endsection
@section('title') Editar administrador @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('users.update')}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input id="id" name="id" type="text" value="{{$user->id}}" hidden>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">person_pin</i>
                        <label for="icon_nick">Nome do @if($user->permissao < 4) administrador @else professor @endif: <span style="color: red;">*</span></label>
                        <input name="nick" id="icon_nick" type="text" value="{{$user->nick}}" maxlength="50">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">email</i>
                        <label for="icon_email">E-mail: <span style="color: red;">*</span></label>
                        <input name="email" id="icon_email" type="email" value="{{$user->email}}" maxlength="50">
                    </div>
                </div>
                <br><br><br>
                    <div class="card">
                        <div class="card-content ">
                            <h6>Redefinição de senha antiga (opcional).</h6>
                        </div>
                    </div>
                <br>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">lock_outline</i>
                        <label for="icon_lockout">Nova Senha:</label>
                        <input name="password" id="icon_lockout" type="password" maxlength="30">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">lock</i>
                        <label for="icon_lock">Confirmar senha:</label>
                        <input name="confirm_password" id="icon_lock" type="password" maxlength="30">
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
    <script src="{{asset('js/validation/validation-users/validation-users-edit.js')}}"></script>
@endsection
