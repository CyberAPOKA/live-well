@extends('layouts.app')
@section('breadcrumbs')
    @can('autorizacao', 3)
        <a href="{{route('home')}}" class="breadcrumb">Home</a>
        <a href="{{route('professor.index')}}" class="breadcrumb">Professores</a>
    @endcan
        <a href="{{route('professor_turmas', $professor->id)}}" class="breadcrumb">Turmas</a>
@endsection
@section('title') 
    @can('autorizacao', 3)
        @section('title') 
            Lista de turmas para vinculação <br> <h5><b>Nome da professor: {{$professor->nome}}</b></h5> 
        @endsection
    @else 
        Suas turmas 
    @endcan
@endsection
@section('content')
    @include('layouts.Sessoes.mensagem_green')   
    <div class="container z-depth-4">
        <div class="card-panel">
            @include('layouts.Sessoes.quant')
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_list</i>Filtros</div>
                    <div class="collapsible-body">
                        <form action="{{route('turmas_procurar')}}" method="GET">
                            @csrf
                            <input type="text" name="id" value="{{$professor->id}}" hidden>
                            <div class="row">
                                <div class="input-field col s10 xl5">
                                    <i class="material-icons prefix">group</i>
                                    <label for="icon_nome">Nome da turma:</label>
                                    <input name="nome" id="icon_nome" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s10 xl2">
                                    <i class="material-icons prefix">assignment</i>
                                    <label for="limite_search">Limite:</label>
                                    <input id="limite_search" type="number" name="limite">
                                </div>
                                <div class="input-field col s10 xl3">
                                    <i class="material-icons prefix">hourglass_full</i>
                                    <label for="icon_horario_inicial">Horário Inicial:</label>
                                    <input name="horario_inicial" id="icon_horario_inicial" type="text" class="timepicker">
                                </div>
                                <div class="input-field col s10 xl3">
                                    <i class="material-icons prefix">hourglass_empty</i>
                                    <label for="icon_horario_final">Horário Final:</label>
                                    <input name="horario_final" id="icon_horario_final" type="text" class="timepicker">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s10 xl4">
                                    <i class="material-icons prefix">date_range</i>&emsp;&emsp; Dias da semana
                                    <select name="data_semanal[]" multiple>
                                        @foreach ($dias_semana as $dia)
                                            <option value="{{$dia}}">{{$dia}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s10 xl4">
                                    <i class="material-icons prefix">filter_tilt_shift</i>&emsp;&emsp; Núcleos
                                    <select name="nucleo_id">
                                        <option value="" selected disabled>Selecione o núcleo</option>
                                        @foreach ($nucleoslist as $nucleo)
                                            <option value="{{$nucleo->id}}">{{$nucleo->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m5 l5">
                                    <i class="material-icons prefix">beenhere</i>&emsp;&emsp; Opção de Página:
                                    <div style="margin-left: 30%;">
                                        <p>
                                            <label>
                                                <input value="3" name="pagina" type="radio"/>
                                                <span>Desvinculados</span>
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input value="1" name="pagina" type="radio"/>
                                                <span>Ativos</span>
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                <input value="2" name="pagina" type="radio"/>
                                                <span>Inativos</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                                <div class="input-field col s12 m5 l5">
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
                        <th>Nome da turma</th>
                        @can('autorizacao', 3)
                            <th>Núcleo pertencente</th>
                            <th>Estado</th>
                            <th>Vinculo</th>
                            <th>Mudar vinculo</th>
                        @else
                            <th>Estado</th>
                            <th>Lista de alunos</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($turmaslist as $turma)
                        <tr>
                            <td><p>{{$turma->nome}}</p> <a class="tooltipped" data-position="top" data-tooltip="Informações de {{$turma->nome}}" href="{{route('turma_info', $turma->id)}}"><i class="small material-icons">info_outline</i></a></td>
                            @can('autorizacao', 3)
                                <td><p>{{$turma->nucleo->nome}}</p> <a class="tooltipped" data-position="top" data-tooltip="Informações de {{$turma->nucleo->nome}}" href="{{route('nucleo_info', $turma->nucleo->id)}}"><i class="small material-icons">info_outline</i></a></td>
                            @endcan
                            <td> 
                                <p>
                                    @if($turma->inativo == 2)
                                        @if($turma->nucleo->inativo == 2) Núcleo inativo
                                        @else Turma inativa @endif
                                    @else 
                                        @if($turma->nucleo->inativo == 2) Núcleo inativo
                                        @else Turma ativa @endif @endif
                                </p>
                                <i class="small material-icons" 
                                    @if($turma->inativo == 2 || $turma->nucleo->inativo == 2)  
                                        style="color: red;" 
                                    @else 
                                        style="color: green;" 
                                    @endif>sim_card_alert
                                </i>
                            </td>
                            @can('autorizacao', 3)
                                @php $ids = -1; @endphp
                                @if(isset($turma->professores)) 
                                    @for ($i = 0; $i < count($turma->professores); $i++) 
                                        @if($turma->professores[$i]->id == $professor->id) @php $ids = $i; break; @endphp @endif
                                    @endfor
                                @endif
                                @if ($ids == -1)
                                    <td><p>Desvinculado</p><i class="small material-icons" style="color: red;" >sim_card_alert</i></td>
                                    <td>
                                        <a class="waves-effect waves-light btn blue modal-trigger btn-modal_vincular" href="#modalidturmavincular"
                                            data-idusuario="{{$professor->id}}" data-idturma="{{$turma->id}}" data-nomeusuario="{{$professor->nome}}" data-nometurma="{{$turma->nome}}">
                                            <i class="material-icons right">lock_outline</i>Vincular
                                        </a>
                                    </td>
                                @else
                                    @if($turma->professores[$ids]->pivot->inativo == 1)
                                        <td><p>Ativado</p><i class="small material-icons" style="color: green;" >sim_card_alert</i></td>
                                        <td><a class="waves-effect waves-light btn blue modal-trigger btn-modal_inativar" href="#modalidturmainativar"
                                                data-idusuario="{{$professor->id}}" data-idturma="{{$turma->id}}" data-nomeusuario="{{$professor->nome}}" data-nometurma="{{$turma->nome}}">
                                                <i class="material-icons right">speaker_notes_off</i>Inativar
                                            </a>
                                        </td>
                                    @else
                                        <td><p>Inativado</p><i class="small material-icons darken-1" style="color: #ffd600;" >sim_card_alert</i></td>
                                        <td><a class="waves-effect waves-light btn blue modal-trigger btn-modal_ativar" href="#modalidturmaativar"
                                                data-idusuario="{{$professor->id}}" data-idturma="{{$turma->id}}" data-nomeusuario="{{$professor->nome}}" data-nometurma="{{$turma->nome}}">
                                            <i class="material-icons right">speaker_notes</i>Ativar
                                            </a>
                                        </td>
                                    @endif
                                @endif
                            @else
                                <td><a class="tooltipped" data-position="top" data-tooltip="Alunos da {{$turma->nome}}" href="{{route('professor_meus_alunos', [$professor->id,$turma->id])}}"><i class="small material-icons">group</i></a></td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="modalidturmavincular" class="modal" style="width: 60%;">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <form action="{{Route('professores_turmas_vincular')}}" method="POST">
            @csrf
            <input hidden class="validate" type="text" name="professor_id" id="id_modal_vincular">
            <input hidden class="validate" type="text" name="turma_id" id="id_turma_modal_vincular">
            <div class="modal-content">
                <h4>Vincular</h4>
                <h5 id="texto_id_vincular"></h5>
                <hr>
                <h5><b>Atenção:</b></h5>
                <div class="row">
                    <div class="input-field col s1">
                        <i class="medium material-icons" style="color: red;" >sim_card_alert</i>
                    </div>
                    <div class="input-field col s11">
                        <h6>Ao fazer o vinculo, o professor não poderá ser desvinculada, você terá opção somente de ativar e inativar o professor da turma!</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s7">
                        <i class="material-icons prefix">comment</i>&emsp;&emsp; Comentario do vinculo (opcional):
                        <textarea id="textarea1" class="materialize-textarea" name="comentario"></textarea>
                        <label for="textarea1"></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn waves-effect waves-light green" type="submit" name="action">Vincular
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </form>
    </div>

    <div id="modalidturmaativar" class="modal">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <form action="{{route('professores_turmas_ativar_inativar')}}" method="POST">
            @csrf
            <input hidden class="validate" type="text" name="professor_id" id="id_modal_ativar">
            <input hidden class="validate" type="text" name="turma_id" id="id_turma_modal_ativar">
            <div class="modal-content">
                <h4>Ativar</h4>
                <h5 id="texto_id_ativar"></h5>
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

    <div id="modalidturmainativar" class="modal">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <form action="{{route('professores_turmas_ativar_inativar')}}" method="POST">
            @csrf
            <input hidden class="validate" type="text" name="professor_id" id="id_modal_inativar">
            <input hidden class="validate" type="text" name="turma_id" id="id_turma_modal_inativar">
            <div class="modal-content">
                <h4>Inativar</h4>
                <h5 id="texto_id_inativar"></h5>
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
@endsection