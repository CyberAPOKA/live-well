@extends('layouts.app')
@section('breadcrumbs')
    @can('autorizacao', 2)
        <a href="{{route('home')}}" class="breadcrumb">Home</a>
        <a href="{{route('turmas.index')}}" class="breadcrumb">Turmas</a>
    @else
        <a href="{{route('professor_turmas', 1)}}" class="breadcrumb">Minhas turmas</a>
    @endcan
    <a href="{{route('turma_info', $turma->id)}}" class="breadcrumb">Informações</a>
@endsection
@section('title') Informações da Turma @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <ul class="tabs blue">
                    <li class="tab col s4"><a href="#coluna1" style="color: white;"><b>Histórico do sistema</b></a></li>
                    <li class="tab col s4"><a href="#coluna2" style="color: white;"><b>Dados registrados</b></a></li>
                    <li class="tab col s4"><a href="#coluna3" style="color: white;"><b>Informações gerais</b></a></li>
                </ul>
            </div>
            <div id="coluna1" class="col s12">
                <div class="col s12">
                    <table id="employee_data">
                        <thead class="centered">
                            <tr>
                                <th style='width: 90px;'>Situação</th>
                                <th style='width: 150px;'>Comentário</th>
                                <th style='width: 150px;' class='center'>Data</th>
                                <th style='width: 100px;' class='center'>Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histturma as $historic)
                                <tr>
                                    <td>@if($historic->inativo == 1) Ativado @else Inativado @endif</td>
                                    <td>@if($historic->comentario == null) Sem comentarios @else {{$historic->comentario}} @endif</td>
                                    @php
                                        $horario = explode(" ",$historic->created_at);
                                        $diamesano = explode("-", $horario[0]);
                                        $horario[0] = $diamesano[2].'/'.$diamesano[1].'/'.$diamesano[0];
                                    @endphp
                                    <td class='center'><p>{{$horario[0]}}<br>{{$horario[1]}}</p></td>
                                    <td class='center'>{{$historic->operario}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="coluna2" class="col s12">
                <div class="col s10">
                    <table>
                        <tr>
                            <td><h6><b>Nome:</b></h6></td>
                            <td><h6>{{$turma->nome}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Limite:</b></h6></td>
                            <td><h6>{{$turma->limite}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Está inativo:</b></h6></td>
                            <td><h6>@if($turma->inativo == 1) Não @else Sim @endif</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Complemento:</b></h6></td>
                            <td><h6>@if (isset($turma->descricao)) {{$turma->descricao}} @else Nenhum complemento escrito @endif</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Horario Inicial:<br>Horario Final:</b></h6></td>
                            <td><h6>{{$turma->horario_inicial}}<br>{{$turma->horario_final}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Dias da semana:</b></h6></td>
                            <td>
                                @foreach ($dias as $dia)
                                    <h6>{{$dia}}</h6>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            @php
                                $horario = explode(" ",$turma->created_at);
                                $diamesano = explode("-", $horario[0]);
                                $horario[0] = $diamesano[2].'/'.$diamesano[1].'/'.$diamesano[0];
                            @endphp
                            <td><h6><b>Data de criação</b></h6></td>
                            <td><h6>{{$horario[0]}}<br>{{$horario[1]}}</h6></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="coluna3" class="col s12">
                <div class="col s10">
                    <div class="row">
                        <div class="col s8">
                            <table>
                                <tr>
                                    <td><h6><b>Quantidade total de pessoas:</b></h6></td>
                                    <td><h6><b>{{$dadosgerais[0]}}</b></h6></td>
                                    <td><i class="small material-icons" style="color: black;">assignment</i></td>
                                </tr>
                                <tr>
                                    <td><h6><b>Quantidade de pessoas Ativa:</b></h6></td>
                                    <td><h6><b>{{$dadosgerais[1]}}</b></h6></td>
                                    <td><i class="small material-icons" style="color: green;">assignment_turned_in</i></td>
                                </tr>
                                <tr>
                                    <td><h6><b>Quantidade de pessoas Inativa:</b></h6></td>
                                    <td><h6><b>{{$dadosgerais[2]}}</b></h6></td>
                                    <td><i class="small material-icons" style="color: red;">assignment_late</i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col s10">
                            <a class="waves-effect waves-light btn-large modal-trigger blue"href="#modalregistropessoasativas">Lista de pessoas ativas na turma &nbsp;&nbsp;&nbsp;<i class="small material-icons right" style="color: green;">assignment_turned_in</i></a>
                            &emsp;&emsp;
                            @php $arraypessoas = []; @endphp
                            @foreach($turma->pessoas as $pessoa)
                                @if($pessoa->pivot->inativo == 1)
                                    @php array_push($arraypessoas, $pessoa->id); @endphp
                                @endif
                            @endforeach
                            <a class="tooltipped btn-floating btn-large waves-effect waves-light light-blue darken-1" data-position="top" data-tooltip="Relatório de pessoas Ativas" href="{{route('menu_pessoas_pdf', [2, json_encode($arraypessoas)])}}"><i class="material-icons">assessment</i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s8">
                            <a class="waves-effect waves-light btn-large modal-trigger blue"href="#modalregistropessoasinativas">Lista de pessoas inativas na turma<i class="small material-icons right" style="color: red;">assignment_late</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalregistropessoasativas" class="modal">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <table class="centered">
                        <thead>
                            <tr>
                                <th>Nome da pessoa</th>
                                <th>Telefone</th>
                                <th>Mais Informações</th>
                            </tr>
                        </thead>
                        @foreach($turma->pessoas as $pessoa)
                            @if($pessoa->pivot->inativo == 1)
                                @php array_push($arraypessoas, $pessoa->id); @endphp
                                <tr>
                                    <td>{{$pessoa->nome}}</td>
                                    <td>{{$pessoa->telefone}}</td>
                                    <td><a class="tooltipped" data-position="top" data-tooltip="Informações de {{$pessoa->nome}}" href="{{Route('pessoa_info', $pessoa->id)}}"><i class="small material-icons" style="color: #039be5;">info_outline</i></a></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modalregistropessoasinativas" class="modal">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <table class="centered">
                        <thead>
                            <tr>
                                <th>Nome da pessoa</th>
                                <th>Telefone</th>
                                <th>Mais Informações</th>
                            </tr>
                        </thead>
                        @foreach($turma->pessoas as $pessoa)
                            @if($pessoa->pivot->inativo == 2)
                                <tr>
                                    <td>{{$pessoa->nome}}</td>
                                    <td>{{$pessoa->telefone}}</td>
                                    <td><a class="tooltipped" data-position="top" data-tooltip="Informações de {{$pessoa->nome}}" href="{{Route('pessoa_info', $pessoa->id)}}"><i class="small material-icons" style="color: #039be5;">info_outline</i></a></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection