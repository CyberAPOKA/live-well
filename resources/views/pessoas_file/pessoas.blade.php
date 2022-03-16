@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('pessoas.index')}}" class="breadcrumb">Pessoas</a>
@endsection
@section('title') Pessoas registradas @endsection
@section('content')
    @include('layouts.Sessoes.mensagem_green')
    <div class="z-depth-4">
        <div class="card-panel">
            @include('layouts.Sessoes.quant')
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_list</i>Filtros</div>
                    <div class="collapsible-body">
                        <form action="{{route('pessoas_procurar')}}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="input-field col s11 m11 xl6">
                                    <i class="material-icons prefix">account_circle</i>
                                    <label for="nome_search">Nome da pessoa</label>
                                    <input id="nome_search" type="text" name="nome">
                                </div>
                                <div class="input-field col s3 m3 xl1"><i class="material-icons prefix">date_range</i></div>
                                <div class="input-field col s4 m4 xl2">
                                    <label for="de_search">Idade miníma:</label>
                                    <input id="de_search" type="number" name="de">
                                </div>
                                <div class="input-field col s4 m4 xl2">
                                    <label for="ate_search">Idade máxima:</label>
                                    <input id="ate_search" type="number" name="ate">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s11 m11 xl3">
                                    <i class="material-icons prefix">assignment_ind</i>
                                    <label for="rg_search">RG</label>
                                    <input id="rg_search" type="text" name=rg>
                                </div>
                                <div class="input-field col s11 m11 xl4">
                                    <i class="material-icons prefix">credit_card</i>
                                    <label for="cpf_search">CPF</label>
                                    <input onkeydown="javascript: fMasc(this, mCPF)" id="cpf_search" type="text" name="cpf">
                                </div>
                                <div class="input-field col s11 m11 xl4">
                                    <i class="material-icons prefix">phone</i>
                                    <label for="telefone_search">Telefone</label>
                                    <input onkeydown="javascript: fMasc(this, mTel)" id="telefone_search" type="text" name="telefone">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s11 m11 xl5">
                                    <i class="material-icons prefix">confirmation_number</i>
                                    <label for="rua">Rua:</label>
                                    <input name="rua" id="rua" type="text">
                                </div>
                                <div class="input-field col s11 xl6">
                                    <i class="material-icons prefix">location_city</i>
                                    <label for="bairro_search">Bairro</label>
                                    <input id="bairro_search" type="text" name="bairro">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s11 xl5">
                                    <i class="material-icons prefix">art_track</i>&emsp;&emsp;&emsp;Filtro de turmas
                                    <select name="turmas[]" multiple>
                                        @foreach ($turmaslist as $turma)
                                            <option value="{{$turma->id}}">{{$turma->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="input-field col s3 l2"><label>Falecido:</label></div>
                                    <div class="input-field col s10 l3">
                                        <p>
                                            <label>
                                                <input onclick="falecido_click('S')" value="1" name="falecido" type="radio"/>
                                                <span>Sim</span>
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input onclick="falecido_click('N')" value="2" name="falecido" type="radio"/>
                                                <span>Não</span>
                                            </label>
                                        </p>
                                    </div>
                                    <div class="input-field col s3 m3 l1 xl1"><i id="falecimento_icon" class="material-icons prefix" hidden>date_range</i></div>
                                    <div class="input-field col s4 m4 l2">
                                        <label id="falecimento_label_de" for="de_fal_search" hidden>Data mínima:</label>
                                        <input id="de_fal_search" name="de_fal_search" type="text" class="datepicker" hidden>
                                    </div>
                                    <div class="input-field col s4 m4 l2">
                                        <label id="falecimento_label_ate" for="ate_fal_search" hidden>Data máxima:</label>
                                        <input id="ate_fal_search" name="ate_fal_search" type="text" class="datepicker" hidden>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s3 l2"><label>Sexo:</label></div>
                                <div class="input-field col s10 l3">
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
                                <div class="input-field col s3 l2"><label>Estado civil:</label></div>
                                <div class="input-field col s10 l3">
                                    <p>
                                        <label>
                                            <input value="Solteiro(a)" name="estado_civil" type="radio"/>
                                            <span>Solteiro(a)</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input value="Casado(a)" name="estado_civil" type="radio"/>
                                            <span>Casado(a)</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input value="Viuvo(a)" name="estado_civil" type="radio"/>
                                            <span>Viuvo(a)</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s3 l2"><label>Completo:</label></div>
                                <div class="input-field col s10 l3">
                                    <p>
                                        <label>
                                            <input value="1" name="estado" type="radio"/>
                                            <span>Sim</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input value="2" name="estado" type="radio"/>
                                            <span>Não</span>
                                        </label>
                                    </p>
                                </div>
                                <div class="input-field col s3 l2"><label>Atualizado:</label></div>
                                <div class="input-field col s10 l3">
                                    <p>
                                        <label>
                                            <input value="S" name="atualizado" type="radio"/>
                                            <span>Sim</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input value="N" name="atualizado" type="radio"/>
                                            <span>Não</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s3">
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
                        <th>ID</th>
                        <th>Nome da pessoa</th>
                        <th>Atualizações</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @php $arraypessoas = []; @endphp
                    @foreach ($pessoaslist as $pessoa)
                        @php array_push($arraypessoas, $pessoa->id); @endphp
                        <tr>
                            <td><p>{{$pessoa->id}}</p></td>
                            <td><p>{{$pessoa->nome}}</p></td>
                            <td>{{$pessoa->anamneses->last()->ano}} <i class="small material-icons" @if($pessoa->anamneses->last()->ano != $ano) style="color: red; vertical-align: -5px;" @else style="color: green; vertical-align: -5px;"  @endif>sim_card_alert</i></td>
                            <td>@if($pessoa->estado == 2) Incompleto @else Completo @endif <i class="small material-icons" @if($pessoa->estado == 2) style="color: red; vertical-align: -5px;" @else style="color: green; vertical-align: -5px;"  @endif>sim_card_alert</i></td>
                            <td>
                                <a class="tooltipped" data-position="top" data-tooltip="Informações de {{$pessoa->nome}}" href="{{Route('pessoa_info', $pessoa->id)}}"><i class="small material-icons">info</i></a>
                                <a class="tooltipped" data-position="top" data-tooltip="Lista de turmas de {{$pessoa->nome}}" href="{{Route('pessoas_turmas', $pessoa->id)}}"><i class="small material-icons">group</i></a>
                                <a class="tooltipped" data-position="top" data-tooltip="Editar {{$pessoa->nome}}" href="{{Route('pessoas.edit', $pessoa->id)}}"><i class="small material-icons">edit</i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <div class="container">
                <a class="tooltipped btn-floating btn-large waves-effect waves-light light-blue darken-1" data-position="top" data-tooltip="Adicionar cliente" href="{{route('pessoas.create')}}"><i class="material-icons">add_to_queue</i></a>
                &emsp;&emsp;
                <a class="tooltipped btn-floating btn-large waves-effect waves-light light-blue darken-1" data-position="top" data-tooltip="Relatório de pessoas" href="{{route('menu_pessoas_pdf', [1, json_encode($arraypessoas)])}}"><i class="material-icons">picture_as_pdf</i></a>
            </div>
        </div>
    </div>
@endsection