@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('turmas.index')}}" class="breadcrumb">Turmas</a>
    @php $arrayturmas = []; @endphp
    @foreach ($turmaslist as $turma)@php array_push($arrayturmas, $turma->id); @endphp @endforeach
    <a href="{{route('menu_turmas_pdf', json_encode($arrayturmas))}}" class="breadcrumb">PDF</a>
@endsection
@section('title') Administração para PDF (turmas) @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form action="{{route('turmas_pdf', json_encode($arrayturmas))}}" method="GET">
                @csrf
                <div class="row">
                    <div class="input-field col s6">
                        <button class="btn waves-effect waves-light blue" type="submit" name="action">Gerar relatório
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                    <div class="input-field col s6">
                        <p>
                            <label>
                                <input id="check1" onclick="mudaCheck(1)" name="option_order" value='nome' type="checkbox" checked/>
                                <span>Ordenar por Nome</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input id="check2" onclick="mudaCheck(2)" name="option_order" value='data' type="checkbox" />
                                <span>Ordenar por data de criação</span>
                            </label>
                        </p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="input-field col s6">
                        <h5><b>Limite</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="limite" type="checkbox" checked>
                                <span class="lever"></span>
                                Sim
                            </label>
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <i class="material-icons prefix" style="color:green;">check_circle</i>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="input-field col s6">
                        <h5><b>Quantidade Atual</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="quant_atual" type="checkbox" checked>
                                <span class="lever"></span>
                                Sim
                            </label>
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <i class="material-icons prefix" style="color:green;">check_circle</i>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="input-field col s6">
                        <h5><b>Data semanal</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="data_semanal" type="checkbox" checked>
                                <span class="lever"></span>
                                Sim
                            </label>
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <i class="material-icons prefix" style="color:green;">check_circle</i>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="input-field col s6">
                        <h5><b>Horario inicial e final</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="horario" type="checkbox" checked>
                                <span class="lever"></span>
                                Sim
                            </label>
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <i class="material-icons prefix" style="color:green;">check_circle</i>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="input-field col s6">
                        <h5><b>Inatividade</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="inativo" type="checkbox" checked>
                                <span class="lever"></span>
                                Sim
                            </label>
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <i class="material-icons prefix" style="color:green;">check_circle</i>
                    </div>
                </div>
                <hr>
            </form>
        </div>
    </div>
@endsection