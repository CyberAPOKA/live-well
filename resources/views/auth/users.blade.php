@extends('layouts.app')

@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a class="breadcrumb" href="{{route('users.index')}}">Administradores</a>
@endsection
@section('title')
    <div class="row">
        <div class="input-field col s12 xl8">
            Usuários registrados 
        </div>
        <div class="input-field col s12 xl4 left">
            @can('autorizacao', 2)<a href="#modalreset" class="waves-effect waves-light btn blue modal-trigger btn-modal_ativar">&emsp;Inativar em lote <i class="material-icons right">access_time</i>@endcan</a>
            <br>
            @can('autorizacao', 2)<a href="#modalquantbloqueio" class="waves-effect waves-light btn blue modal-trigger btn-modal_ativar">Quantidade limite<i class="material-icons right">https</i>@endcan</a>
        </div>
    </div>
@endsection
@section('content')
    @include('layouts.Sessoes.mensagem_green')
    @include('layouts.Sessoes.mensagem_red')
    <div class="z-depth-4">
        <div class="card-panel">
            @include('layouts.Sessoes.quant')
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_list</i>Filtros</div>
                    <div class="collapsible-body">
                        <form action="{{route('usuarios_procurar')}}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="input-field col s11 xl5">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input id="usuario_search" type="text" name="usuario">
                                    <label for="usuario_search">Usuário:</label>
                                </div>
                                <div class="input-field col s11 xl5">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input id="nome_search" type="text" name="nome">
                                    <label for="nome_search">Nome:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s11 xl5">
                                    <i class="material-icons prefix">email</i>
                                    <input id="email_search" name="email" type="text">
                                    <label for="email_search">E-mail:</label>
                                </div>
                                <div class="input-field col s11 xl5">
                                    <i class="material-icons prefix">verified_user</i>&emsp;&emsp;&emsp;Tipo de usuário
                                    <select name="tipo">
                                        <option value="" selected disabled>Selecione o tipo de usuário</option>
                                        <option value="2">Administrador</option>
                                        <option value="4">Professor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s10 xl5">
                                    <i class="material-icons prefix">sim_card_alert</i>&emsp;&emsp; Deletado | inativo:
                                    <div style="margin-left: 30%;">
                                        <p>
                                            <label>
                                                <input value="1" name="inativo" type="radio"/>
                                                <span>Deletados</span>
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input value="2" name="inativo" type="radio"/>
                                                <span>Ativo</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s3">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">Procurar
                                        <i class="material-icons right">search</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
            <table id="employee_data" class="centered responsive-table highlight bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Tipo de usuário</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userslist as $user)
                        <tr>
                            <td><p>{{$user->id}}</p></td>
                            <td><p>{{$user->nick}}</p></td>
                            <td><p>@if($user->permissao < 4) Administrador @else Professor @endif</p></td>
                            <td>@if($user->deleted_at == null) Ativo @else Inativo @endif <i class="small material-icons" @if($user->deleted_at == null) style="color: green; vertical-align: -5px;" @else style="color: red; vertical-align: -5px;"  @endif>sim_card_alert</i></td>
                            <td>
                                <a class="tooltipped" data-position="top" data-tooltip="Informações de {{$user->name}}" href="{{Route('user_info', $user->id)}}"><i class="small material-icons">info</i></a>
                                <a class="tooltipped" data-position="top" data-tooltip="Informações de {{$user->nick}}" href="{{Route('users.edit', $user->id)}}"><i class="small material-icons">edit</i></a>
                                @if($user->deleted_at == null)
                                    <a id="btn_delete" class="tooltipped modal-trigger" data-position="top" data-tooltip="Deletar {{$user->nick}}" href="#modaldelete"
                                       data-id="{{$user->id}}" data-name="{{$user->nick}}" data-tipo="{{$user->admin_professor}}">
                                       <i class="small material-icons">do_not_disturb</i>
                                    </a>
                                @else
                                    @if($user->permissao != 1)
                                        <a id="btn-restore" class="tooltipped modal-trigger" data-position="top" data-tooltip="Restaurar {{$user->nick}}" href="#modalrestore"
                                            data-id="{{$user->id}}" data-name="{{$user->nick}}" data-tipo="{{$user->admin_professor}}">
                                            <i class="small material-icons">restore</i>
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
            <br>
            <div class="container">
                <a class="tooltipped btn-floating btn-large waves-effect waves-light light-blue darken-1" data-position="top" data-tooltip="Adicionar Administrador" href="{{route('register')}}"><i class="material-icons">add_to_queue</i></a>
                @can('autorizacao', 1)
                    <a class="tooltipped btn-floating btn-large waves-effect waves-light light-blue darken-1 right" data-position="top" data-tooltip="Criar novo secretario" href="{{route('secretario_register')}}"><i class="material-icons">remove_red_eye</i></a>
                @endcan
            </div>
        </div>
    </div>

    <div id="modaldelete" class="modal"  style="width: 30%;">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <form action="{{route('users.destroy', 'delete')}}" method="POST">
            @method('DELETE')
            @csrf
            <input name="id" type="number" id="id_delete" hidden>
            <div class="modal-content">
                <div class="row">
                    <h4>Deletar</h4>
                    <h6>Você tem certeza que deseja deletar o usuário abaixo?</h6>
                </div>
                <hr>
                <br>
                <div class="row">
                    <div class="input-field col s12">
                        <table>
                            <tr>
                                <td><b>Nome:</b></td>
                                <td><p><span id="name_delete"></span></p></td>
                            </tr>
                            <tr>
                                <td><b>Tipo de usuário:</b></td>
                                <td><p><span id="tipo_delete"></span></p></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn waves-effect waves-light blue" type="submit" name="action">Deletar
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </form>
    </div>

    @can('autorizacao', 2)
        <div id="modalrestore" class="modal"  style="width: 30%;">
            <div class="col s1.5 right">
                <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
            </div>
            <form action="{{route('users.restore')}}" method="GET">
                @csrf
                <input class="validate" name="id" type="number" id="id_restore" hidden>
                <div class="modal-content">
                    <div class="row">
                        <h4>Restaurar</h4>
                        <h6>Você tem certeza que deseja restaurar o usuário abaixo?</h6>
                    </div>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="input-field col s12">
                            <table>
                                <tr>
                                    <td><b>Nome:</b></td>
                                    <td><p><span id="name_restore"></span></p></td>
                                </tr>
                                <tr>
                                    <td><b>Tipo de usuário:</b></td>
                                    <td><p><span id="tipo_restore"></span></p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn waves-effect waves-light blue" type="submit" name="action">Restaurar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>
    @endcan

    <div id="modalreset" class="modal" style="width: 55%; height: 45%;">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <div class="container">
            <div class="row">
                <p class="center"><b>Ferramenta utilizada para retirar todas as pessoas de todas as turmas do sistema, confirmando esta requisição, não terá como voltar atrás: </b></p>
                <hr>
                <h5><b>Confirme o usuário e senha do administrador raiz:</b></h5>
            </div>
            <br>
            <div class="row">
                <form id="formulario" action="{{route('reset_sistema')}}" method="POST">
                    @csrf
                    <div class="input-field col s6">
                        <i class="material-icons prefix">perm_contact_calendar</i>
                        <input name="name" id="name" type="text"  required>
                        <label for="name">Usuário:</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">lock_outline</i>
                        <input name="password" id="password" type="password" required>
                        <label for="password">Senha:</label>
                    </div>
                    <br>
                    <div class="input-field col s12 center">
                        <button class="btn waves-effect waves-light light-blue darken-1" type="submit" name="action">Resetar sistema
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalquantbloqueio" class="modal" style="width: 38%; height: 40%;">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <div class="container">
            <div class="row">
                <p class="center"><b>Configuração de quantidade limite de permissão para adicionar pessoas em turmas: </b></p>
                <hr>
                <h5><b>Quantidade possível atual:&emsp;&emsp; {{$quantidade->quantidade}}</b></h5>
            </div>
            <br>
            <div class="row">
                <form action="{{route('define_quantidade')}}" method="POST">
                    @csrf
                    <div class="input-field col s6">
                            <i class="material-icons prefix">enhanced_encryption</i>
                            <input name="quantidade" id="quantidade" type="number" required>
                            <label for="quantidade">Quantidade [bloqueio]: </label>
                    </div>
                    <div class="input-field col s4 right">
                        <button class="btn waves-effect waves-light light-blue darken-1" type="submit" name="action">Definir
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection