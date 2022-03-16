@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a class="breadcrumb" href="{{route('users.index')}}">Administradores</a>
    <a href="{{route('user_info', $user->id)}}" class="breadcrumb">Informações</a>
@endsection
@section('title') <h4>Informações do usuário: {{$user->id}}</h4> @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m10">
                <table class="centered responsive-table highlight bordered">
                    <tbody>
                        <tr>
                            <td><h6>Usuário:</h6></td>
                            <td><h6>{{$user->name}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6>Nome:</h6></td>
                            <td><h6>{{$user->nick}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6>Email:</h6></td>
                            <td><h6>{{$user->email}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6>Tipo de usuário:</h6></td>
                            <td><h6>@if($user->permissao < 4) Administrador @else Professor @endif</h6></td>
                        </tr>
                        <tr>
                            @php
                                $horario = explode(" ",$user->created_at);
                                $diamesano = explode("-", $horario[0]);
                                $horario[0] = $diamesano[2].'/'.$diamesano[1].'/'.$diamesano[0];
                            @endphp
                            <td><h6>Data de criação:</h6></td>
                            <td><h6>{{$horario[0]}}<br>{{$horario[1]}}</h6></td>
                        </tr>
                        @if($user->deleted_at !=null)
                            <tr>
                                @php
                                    $horario = explode(" ",$user->deleted_at);
                                    $diamesano = explode("-", $horario[0]);
                                    $horario[0] = $diamesano[2].'/'.$diamesano[1].'/'.$diamesano[0];
                                @endphp
                                <td><h6>Data de exclusão:</h6></td>
                                <td><h6>{{$horario[0]}}<br>{{$horario[1]}}</h6></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection