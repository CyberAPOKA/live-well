@extends('layouts.app')
@section('breadcrumbs')
    @can('autorizacao', 3)
        <a href="{{route('home')}}" class="breadcrumb">Home</a>
        <a href="{{route('nucleos.index')}}" class="breadcrumb">Núcleos</a>
    @else
        <a href="{{route('professor_turmas', 1)}}" class="breadcrumb">Minhas turmas</a>
    @endcan
    <a href="{{route('nucleo_info', $nucleo->id)}}" class="breadcrumb">Informações</a>
@endsection
@section('title') Informações do Núcleo @endsection
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
                    <table>
                        <thead class="centered">
                            <tr>
                                <th style='width: 90px;'>Situação</th>
                                <th style='width: 150px;'>Comentário</th>
                                <th style='width: 150px;' class='center'>Data</th>
                                <th style='width: 100px;' class='center'>Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histnucleo as $historic)
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
                            <td><h6>{{$nucleo->nome}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Bairro:</b></h6></td>
                            <td><h6>{{$nucleo->bairro}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Rua:</b></h6></td>
                            <td><h6>{{$nucleo->rua}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Numero de endereço:</b></h6></td>
                            <td><h6>{{$nucleo->numero_endereco}}@if(isset($nucleo->complemento)), {{$nucleo->complemento}}@endif</h6></td>

                        </tr>
                        <tr>
                            <td><h6><b>CEP:</b></h6></td>
                            <td><h6>{{$nucleo->cep}}</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Complemento:</b></h6></td>
                            <td><h6>@if($nucleo->descricao == null) Nnehum complemento de núcleo. @else {{$nucleo->descricao}}@endif</h6></td>
                        </tr>
                        <tr>
                            <td><h6><b>Está inativo:</b></h6></td>
                            <td><h6>@if($nucleo->inativo == 1) Não @else Sim @endif</h6></td>
                        </tr>
                        <tr>
                            @php
                                $horario = explode(" ",$nucleo->created_at);
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
                <br><br>
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
                    <div class="col s8">
                        <table>
                            <tr>
                                <td><h6><b>Quantidade total de turmas:</b></h6></td>
                                <td><h6><b>{{$dadosgerais2[0]}}</b></h6></td>
                                <td><i class="small material-icons" style="color: black;">assignment</i></td>
                            </tr>
                            <tr>
                                <td><h6><b>Quantidade de turmas Ativa:</b></h6></td>
                                <td><h6><b>{{$dadosgerais2[1]}}</b></h6></td>
                                <td><i class="small material-icons" style="color: green;">assignment_turned_in</i></td>
                            </tr>
                            <tr>
                                <td><h6><b>Quantidade de turmas Inativa:</b></h6></td>
                                <td><h6><b>{{$dadosgerais2[2]}}</b></h6></td>
                                <td><i class="small material-icons" style="color: red;">assignment_late</i></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="row">
                        <div class="col s12">
                            <a class="waves-effect waves-light btn-large modal-trigger blue" href="#modalregistroturmas">Lista de turmas do núcleo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div id="modalregistroturmas" class="modal">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <div class="container">
            <div class="col s12">
                <table class="centered responsive-table highlight bordered">
                    <thead>
                        <th>Nome da turma</th>
                        <th>Estado</th>
                        <th>Mais Informações</th>
                    </thead>
                    <tbody>
                        @foreach ($nucleo->turmas as $turma)
                            <tr>
                                <td>{{$turma->nome}}</td>
                                <td><i class="small material-icons" style="color: @if($turma->inativo == 1) green @else red @endif;">@if($turma->inativo == 1) assignment_turned_in @else assignment_late  @endif</i></td>
                                <td><a class="tooltipped" data-position="top" data-tooltip="Informações de {{$turma->nome}}" href="{{route('turma_info', $turma->id)}}"><i class="small material-icons">info_outline</i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection