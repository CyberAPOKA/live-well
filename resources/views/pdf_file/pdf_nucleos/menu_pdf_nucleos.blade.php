@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('nucleos.index')}}" class="breadcrumb">Núcleos</a>
    @php $arraynucleos = []; @endphp
    @foreach ($nucleoslist as $nucleo)@php array_push($arraynucleos, $nucleo->id); @endphp @endforeach
    <a href="{{route('menu_nucleos_pdf', json_encode($arraynucleos))}}" class="breadcrumb">PDF</a>
@endsection
@section('title') Administração para PDF (núcleos) @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form action="{{route('nucleos_pdf', json_encode($arraynucleos))}}" method="GET">
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
                        <h5><b>Cidade</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="cidade" type="checkbox" checked>
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
                        <h5><b>Bairro</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="bairro" type="checkbox" checked>
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
                        <h5><b>Rua</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="rua" type="checkbox" checked>
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
                        <h5><b>Número de endereço</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="numero_endereco" type="checkbox" checked>
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
                        <h5><b>CEP</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="cep" type="checkbox" checked>
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
                        <h5><b>Ativo | Inativo</b></h5></td>
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