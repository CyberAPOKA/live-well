@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('doencas.index')}}" class="breadcrumb">Doenças</a>
@endsection
@section('title') Doenças registradas @endsection
@section('content')
    @include('layouts.Sessoes.mensagem_green')
    <div class="z-depth-4">
        <div class="card-panel">
            @include('layouts.Sessoes.quant')
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_list</i>Filtros</div>
                    <div class="collapsible-body">
                        <form action="{{route('doencas_procurar')}}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12 xl4">
                                    <i class="material-icons prefix">warning</i>
                                    <input name="nome" id="icon_nome" type="text">
                                    <label for="icon_nome">Nome da doença:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 xl3">
                                    <button class="btn waves-effect waves-light light-blue darken-1" type="submit" name="action">Procurar
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
                        <th>Nome da doença</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doencaslist as $doenca)
                        <tr>
                            <td><p>{{$doenca->nome}}</p></td>
                            <td><p>{{$doenca->descricao}}</p></td>
                            <td>
                                <a class="tooltipped" data-position="top" data-tooltip="Editar Doença" href="{{Route('doencas.edit', $doenca->id)}}"><i class="small material-icons">edit</i></a>
                            </td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
            <br>
            <div class="container">
                <a class="tooltipped btn-floating btn-large waves-effect waves-light light-blue darken-1" data-position="top" data-tooltip="Adicionar doenças" href="{{route('doencas.create')}}"><i class="material-icons">add_to_queue</i></a>
            </div>
        </div>
    </div>
@endsection