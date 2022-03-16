@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('audits.index')}}" class="breadcrumb">Auditorias</a>
@endsection
@section('title') Auditorias registradas @endsection
@section('content')
    <div class="z-depth-4">
        <div class="card-panel">
            @include('layouts.Sessoes.quant')
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">location_searching</i>Filtros</div>
                    <div class="collapsible-body">
                        <form action="{{route('audits_procurar')}}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="input-field col s11 m5">
                                    Tabela
                                    <select name="tabelas[]">
                                        <option value="" selected disabled>Selecione a tabela</option>
                                        @for($i = 0; $i < count($tabelas); $i++)
                                            <option value="{{$i}}">{{$tabelas[$i]}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="input-field col s11 m6 right">
                                    <i class="material-icons prefix">event_note</i>&emsp;&emsp; Evento:
                                    <div style="margin-left: 30%;">
                                        <p>
                                            <label>
                                                <input value="1" name="eventos" type="radio"/>
                                                <span>Criação</span>
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input value="2" name="eventos" type="radio"/>
                                                <span>Edição</span>
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
                        <th>Id Usuário</th>
                        <th>Tipo</th>
                        <th>Evento</th>
                        <th>Data:Hora</th>
                        <th>Mais informações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($auditslist as $audit)
                        <tr>
                            <td><p>{{$audit->user_id}}</p></td>
                            <td><p>{{$audit->auditable_type}}</p></td>
                            <td><p>{{$audit->event}}</p></td>
                            @php
                                $horario = explode(" ",$audit->created_at);
                                $diamesano = explode("-", $horario[0]);
                                $horario[0] = $diamesano[2].'/'.$diamesano[1].'/'.$diamesano[0];
                            @endphp
                            <td><p>{{$horario[0]}}<br>{{$horario[1]}}</p></td>
                            <td><a class="tooltipped" data-position="top" data-tooltip="Informações da auditoria" href="{{route('audits_info', $audit->id)}}"><i class="small material-icons">info</i></a></td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
@endsection