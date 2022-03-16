@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('nucleos.index')}}" class="breadcrumb">Núcleos</a>
@endsection
@section('title') Núcleos registrados @endsection
@section('content')
    @include('layouts.Sessoes.mensagem_red')
    @include('layouts.Sessoes.mensagem_green')
    <div class="z-depth-4">
        <div class="card-panel">
            @include('layouts.Sessoes.quant')
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_list</i>Filtros</div>
                    <div class="collapsible-body">
                        <form action="{{route('nucleos_procurar')}}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="input-field col s10 xl5">
                                    <i class="material-icons prefix">filter_tilt_shift</i>
                                    <input name="nome" id="icon_nome" type="text">
                                    <label for="icon_nome">Nome da núcleo:</label>
                                </div>
                                <div class="input-field col s10 xl5 right">
                                    <i class="material-icons prefix">sim_card_alert</i>&emsp;&emsp; Núcleo ativo | inativo:
                                    <div style="margin-left: 30%;">
                                        <p>
                                            <label>
                                                <input value="1" name="inativo" type="radio"/>
                                                <span>Ativo</span>
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input value="2" name="inativo" type="radio"/>
                                                <span>Inativo</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s10 xl5">
                                    <i class="material-icons prefix">location_city</i>&emsp;&emsp;&emsp;Bairros
                                    <select name="bairro">
                                        <option value="" selected disabled>Selecione o núcleo</option>
                                        @foreach ($bairroslist as $bairro)
                                            <option value="{{$bairro}}">{{$bairro}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s10 xl5">
                                    <i class="material-icons prefix">confirmation_number</i>
                                    <input name="rua" id="icon_rua" type="text">
                                    <label for="icon_rua">Rua:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s10 xl5">
                                    <i class="material-icons prefix">location_on</i>
                                    <input name="numero_endereco" id="icon_numero_endereco" type="number">
                                    <label for="icon_numero_endereco">Numero de endereço:</label>
                                </div>
                                <div class="input-field col s10 xl5">
                                    <i class="material-icons prefix">location_city</i>
                                    <input onkeydown="javascript: fMasc(this, mCEP)" name="cep" id="icon_cep" type="text">
                                    <label for="icon_cep">CEP:</label>
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
                        <th>Nome do núcleo</th>
                        <th>Endereço</th>
                        <th>Situação</th>
                        @can('autorizacao', 3)<th>Mudar estado</th>@endcan
                        @can('autorizacao', 3)<th>Ações</th>@else<th>Informações</th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @php $arraynucleos = []; @endphp
                    @foreach ($nucleoslist as $nucleo)
                        @php array_push($arraynucleos, $nucleo->id); @endphp
                        <tr>
                            <td>{{$nucleo->nome}}</td>
                            <td><p>{{$nucleo->bairro}} <br> {{$nucleo->rua}} <br> {{$nucleo->numero_endereco}} {{$nucleo->complemento}}</p></td>
                            <td>@if($nucleo->inativo == 2) Inativo @else Ativo @endif <br><i class="small material-icons" @if($nucleo->inativo == 2) style="color: red;" @else style="color: green;" @endif>sim_card_alert</i></td>
                            @can('autorizacao', 3)
                                @if ($nucleo->inativo == 2)
                                    <td>
                                        <a class="waves-effect waves-light btn blue modal-trigger" id="btn-modal_ativar_objeto" href="#modalobjetoativar"
                                            data-idobjeto="{{$nucleo->id}}" data-nomeobjeto="{{$nucleo->nome}}">
                                            <i class="material-icons right">lock_open</i>Ativar
                                        </a>
                                    </td>
                                @else
                                    <td>
                                        <a class="waves-effect waves-light btn blue modal-trigger" id="btn-modal_inativar_objeto" href="#modalobjetoinativar"
                                            data-idobjeto="{{$nucleo->id}}" data-nomeobjeto="{{$nucleo->nome}}">
                                            <i class="material-icons right">lock_outline</i>Inativar
                                        </a>
                                    </td>
                                @endif
                            @endcan
                            <td>
                                <a class="tooltipped" data-position="top" data-tooltip="Informações de {{$nucleo->nome}}" href="{{route('nucleo_info', $nucleo->id)}}"><i class="small material-icons">info</i></a>
                                @can('autorizacao', 3)<a class="tooltipped" data-position="top" data-tooltip="Editar {{$nucleo->nome}}" href="{{Route('nucleos.edit', $nucleo->id)}}"><i class="small material-icons">edit</i></a>@endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @can('autorizacao', 3)
                <br>
                <div class="container">
                    <a class="tooltipped btn-floating btn-large waves-effect waves-light light-blue darken-1" data-position="top" data-tooltip="Adicionar núcleo" href="{{route('nucleos.create')}}"><i class="material-icons">add_to_queue</i></a>
                    &emsp;&emsp;
                    <a class="tooltipped btn-floating btn-large waves-effect waves-light light-blue darken-1" data-position="top" data-tooltip="Relatório de turmas" href="{{route('menu_nucleos_pdf', json_encode($arraynucleos))}}"><i class="material-icons">picture_as_pdf</i></a>
                </div>
            @endcan
        </div>
    </div>

    @can('autorizacao', 3)
        <div id="modalobjetoativar" class="modal">
            <div class="col s1.5 right">
                <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
            </div>
            <form action="{{Route('nucleos_ativar_inativar')}}" method="POST">
                @csrf
                <input class="validate" type="text" name="nucleo_id" id="id_modal_ativar" hidden>
                <div class="modal-content">
                    <h4>Ativar</h4>
                    <h5 id="texto_ativar"></h5>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="input-field col s7">
                            <i class="material-icons prefix">comment</i>&emsp;&emsp; Comentario para Ativação (opcional):
                            <textarea id="textarea1" class="materialize-textarea" name="comentario"></textarea>
                            <label for="textarea1"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn waves-effect waves-light green" type="submit" name="action">Ativar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>
        
        <div id="modalobjetoinativar" class="modal">
            <div class="col s1.5 right">
                <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
            </div>
            <form action="{{Route('nucleos_ativar_inativar')}}" method="POST">
                @csrf
                <input class="validate" type="text" name="nucleo_id" id="id_modal_inativar" hidden>
                <div class="modal-content">
                    <h4>Inativar</h4>
                    <h5 id="texto_inativar"></h5>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="input-field col s7">
                            <i class="material-icons prefix">comment</i>&emsp;&emsp; Comentario para Inativação (obrigatório):
                            <textarea id="textarea1" class="materialize-textarea" name="comentario" required></textarea>
                            <label for="textarea1"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn waves-effect waves-light green" type="submit" name="action">Inativar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>
    @endcan
@endsection