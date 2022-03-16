@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('pessoas.index')}}" class="breadcrumb">Pessoas</a>
    @php $arraypessoas = []; @endphp
    @foreach ($pessoaslist as $pessoa)@php array_push($arraypessoas, $pessoa->id); @endphp @endforeach
    <a href="{{route('menu_pessoas_pdf', [$op, json_encode($arraypessoas)])}}" class="breadcrumb">PDF</a>
@endsection
@section('title') Administração para PDF (pessoas) @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form action="{{route('pessoas_pdf', json_encode($arraypessoas))}}" method="GET">
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
                                <span>Ordenar por data de nascimento</span>
                            </label>
                        </p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="input-field col s6">
                        <h5><b>Endereço</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="endereco" type="checkbox" checked>
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
                        <h5><b>Telefone</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="telefone" type="checkbox" checked>
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
                        <h5><b>Data de nascimento</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="data_nascimento" type="checkbox" checked>
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
                        <h5><b>RG</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="rg" type="checkbox" checked>
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
                        <h5><b>Usuário falecido</b></h5></td>
                    </div>
                    <div class="input-field col s1">
                        <i class="material-icons prefix" style="color:red;">cancel</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:3%;">
                        <div class="switch">
                            <label>
                                Não
                                <input name="morto" type="checkbox" checked>
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
                @foreach ($pessoaslist as $pessoa)
                    @if ($op == 2)
                        <br>
                        <div class='row'>
                            <div class="input-field col s6">
                                <h6>{{$pessoa->nome}}</h6>
                            </div>
                            <div class="input-field col s6">
                                <p>
                                    <label>
                                        <input name='{{$pessoa->id}}' type="checkbox" checked/>
                                        <span>Adicionar ao relatório</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    @else
                        <input name='{{$pessoa->id}}' type="checkbox" checked hidden/>
                    @endif
                @endforeach
            </form>
        </div>
    </div>
@endsection