@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('professor_turmas', 1)}}" class="breadcrumb">Turmas</a>
    <a href="{{Route('professor.edit', $professor->id)}}" class="breadcrumb">Alunos</a>
@endsection
@section('title') Alunos de: {{$turma->nome}} @endsection
@section('content')
    <br><br>
    <div class="container z-depth-4">
        <div class="card-panel">¨
            @include('layouts.Sessoes.quant')
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_list</i>Filtros</div>
                    <div class="collapsible-body">
                        <form action="{{route('professor_procurar_aluno')}}" method="GET">
                            @csrf
                            <input type="text" name="professorid" value="{{$professor->id}}" hidden>
                            <input type="text" name="idturma" value="{{$turma->id}}" hidden>
                            <div class="row">
                                <div class="input-field col s11 m6 l5">
                                    <i class="material-icons prefix">account_circle</i>
                                    <label for="nome_search">Nome:</label>
                                    <input id="nome_search" type="text" name="nome">
                                </div>
                                <div class="col s3 m1 l1"><label>Idade:</label></div>
                                <div class="input-field col s4 m2 l2">
                                    <label for="de_search">De:</label>
                                    <input id="de_search" type="text" class="datepicker" name="de">
                                </div>
                                <div class="input-field col s4 m2 l2">
                                    <label for="ate_search">Até:</label>
                                    <input id="ate_search" type="text" class="datepicker" name="ate">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s11 m6 l5">
                                    <i class="material-icons prefix">phone</i>
                                    <label for="icon_telephone">Telephone:</label>
                                    <input name="telefone" id="icon_telephone" type="tel">
                                </div>
                                <div class="input-field col s3 m1 l1"><label>Sexo:</label></div>
                                <div class="input-field col s8 m4 l3">
                                    <p>
                                        <label>
                                            <input value="F" name="sexo" type="radio"/>
                                            <span>Feminino</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input value="M" name="sexo" type="radio"/>
                                            <span>Masculino</span>
                                        </label>
                                    </p>
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
            <table class="centered responsive-table highlight bordered">
                <thead>
                    <tr>
                        <th>Nome do Alunos</th>
                        <th>Ultima anamnese</th>
                        <th>Doenças</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pessoaslist as $aluno)
                        <tr>
                            <td>{{$aluno->nome}}</td>
                            <td><a class="tooltipped" data-position="top" data-tooltip="Informações da anamnese" href="{{Route('anamnese_info', $aluno->anamneses[count($aluno->anamneses)-1])}}"><i class="small material-icons">info</i></a></td>
                            @if(isset($aluno->anamneses[count($aluno->anamneses)-1]->doencas))
                                <td>@if(count($aluno->anamneses[count($aluno->anamneses)-1]->doencas) == 0) Não possui @else <a class="tooltipped modal-trigger" data-position="top" data-tooltip="Doenças da anamnese" href="#listadoencas" onclick="modal_doencas({{$aluno->anamneses[count($aluno->anamneses)-1]->doencas}})"><i class="small material-icons">info_outline</i></a> @endif</td>
                            @else
                                Não possui
                            @endif
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="modal" id="listadoencas">
        <div class="container">
            <table class="centered responsive-table highlight bordered" id="lista_de_doencas"></table>
        </div>
    </div>
@endsection