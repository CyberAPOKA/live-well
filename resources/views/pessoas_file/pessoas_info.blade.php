@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('pessoas.index')}}" class="breadcrumb">Pessoas</a>
    @if(isset($pessoa->deleted_at)) <a href="{{route('pessoas_softdeletes')}}" class="breadcrumb">Deletadas</a> @endif
    <a href="{{Route('pessoa_info', $pessoa->id)}}" class="breadcrumb">Informações</a>
@endsection
@section('title') Informações de <?php $nomes = explode(' ',$pessoa->nome);?> {{$nomes[0]}} @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <ul class="tabs blue">
                    <li class="tab col s4"><a href="#coluna1" style="color: white;"><b>Dados registrados</b></a></li>
                    <li class="tab col s4"><a href="#coluna2" style="color: white;"><b>Informações gerais</b></a></li>
                    <li class="tab col s4"><a href="#coluna3" style="color: white;"><b>Histórico do sistema</b></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            
            <div id="coluna1" class="col s12">
                <div class="row">
                    <div class="col s6">
                        <table>
                            <tr>
                                <h6><b>Foto registrada:</b></h6>
                                @if(!is_null($pessoa->foto))
                                    <td><img id="3x4_image" class="materialboxed" style="width: 200px; height: 150px; border: solid 5px black" src="{{asset($pessoa->foto)}}"></td>
                                @else
                                    <td><img id="3x4_image" class="materialboxed" style="width: 200px; height: 150px; border: solid 5px black" src="{{asset('/img/unset_image_3x4.png')}}"></td>
                                @endif
                            </tr>
                        </table>
                    </div>
                    @if($idade < 18)
                        <div class="col s6">
                            <table>
                                <tr>
                                    <h6><b>Matricula:</b></h6>
                                    @if(!is_null($pessoa->matricula))
                                        <td><a class="waves-effect waves-light btn" href="{{asset($pessoa->matricula)}}">Matricula.pdf</td>
                                        <td><i class="small material-icons" style="color: green;">assignment_turned_ins</i></td>
                                    @else
                                        <td>Usuário sem matricula.</td>
                                        <td><i class="small material-icons" style="color: red;">assignment_late</i></td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col s6">
                        <table>
                            <tr>
                                <td><h6><b>Nome:</b></h6></td>
                                <td><h6>{{$pessoa->nome}}</h6></td>
                            </tr>
                            <tr>
                                <td><h6><b>Nascimento:</b></h6></td>
                                <td><h6>{{$pessoa->nascimento}}</h6></td>
                            </tr>
                            <tr>
                                <td><h6><b>RG:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->rg != null) {{$pessoa->rg}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            @if($idade < 18)
                                <tr>
                                    <td><h6><b>RG do responsavel:</b></h6></td>
                                    <td>
                                        <h6>
                                            @if($pessoa->rg_responsavel != null) {{$pessoa->rg_responsavel}} 
                                            @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                        </h6>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td><h6><b>CPF:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->cpf != null) {{$pessoa->cpf}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            @if($idade < 18)
                                <tr>
                                    <td><h6><b>CPF do responsavel:</b></h6></td>
                                    <td>
                                        <h6>
                                            @if($pessoa->cpf_responsavel != null) {{$pessoa->cpf_responsavel}} 
                                            @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                        </h6>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td><h6><b>Cidade:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->cidade != null) {{$pessoa->cidade}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Bairro:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->bairro != null) {{$pessoa->bairro}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Rua:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->rua != null) {{$pessoa->rua}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Numero:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->numero_endereco != null) {{$pessoa->numero_endereco}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>CEP:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->cep != null) {{$pessoa->cep}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Telefone:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->telefone != null) {{$pessoa->telefone}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Telefone de emergência:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->telefone_emergencia != null) {{$pessoa->telefone_emergencia}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col s6">
                        <table>
                            <tr>
                                <td><h6><b>Sexo:</b></h5></td>
                                <td><h6>@if ($pessoa->sexo == 'M') Masculino @else Feminino @endif</h6></td>
                            </tr>
                            <tr>
                                <td><h6><b>Estado civil:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->estado_civil != null) {{$pessoa->estado_civil}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Nome do pai:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->nome_do_pai != null) {{$pessoa->nome_do_pai}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Nome da mãe:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->nome_da_mae != null) {{$pessoa->nome_da_mae}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Pessoa para emergência:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->pessoa_emergencia != null) {{$pessoa->pessoa_emergencia}} 
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Convenio médico:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->convenio_medico != null || $pessoa->convenio_medico != -1)
                                            @if($pessoa->convenio_medico == -1) Não possui
                                            @else {{$pessoa->convenio_medico}} @endif
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Mora com os pais:</b></h6></td>
                                <td>
                                    <h6>
                                        @if($pessoa->mora_com_os_pais != null)
                                            @if($pessoa->mora_com_os_pais == 1) Sim @else Não @endif
                                        @else <i class="small material-icons" style="color: red;">assignment_late</i> @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h6><b>Quantidade de filhos:</b></h6></td>
                                <td><h6>{{$pessoa->filhos}}</h6></td>
                            </tr>
                            <tr>
                                <td><h6><b>Quantidade de irmãos:</b></h6></td>
                                <td><h6>{{$pessoa->irmaos}}</h6></td>
                            </tr>
                            <tr>
                                <td><h6><b>Está inativo:</b></h6></td>
                                <td><h6>@if($pessoa->inativo == null) Sim @else Não @endif</h6></td>
                            </tr>
                            <tr>
                                @php
                                    $horario = explode(" ",$pessoa->created_at);
                                    $diamesano = explode("-", $horario[0]);
                                    $horario[0] = $diamesano[2].'/'.$diamesano[1].'/'.$diamesano[0];
                                @endphp
                                <td><h6><b>Data de criação</b></h6></td>
                                <td><h6>{{$horario[0]}}<br>{{$horario[1]}}</h6></td>
                            </tr>
                            @if($pessoa->morte != null)
                                <tr>
                                    <td><h6><b>Data de falecimento:</b></h6></td>
                                    <td><h6>{{$pessoa->morte}}</h6></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div id="coluna2" class="col s12">
                <div class="col s10">
                    <div class="row">
                        <div class="col s8">
                            <table>
                                <tr>
                                    <td><h6><b>Quantidade total de turmas:</b></h6></td>
                                    <td><h6><b>{{$dadosgerais[0]}}</b></h6></td>
                                    <td><i class="small material-icons" style="color: black;">assignment</i></td>
                                </tr>
                                <tr>
                                    <td><h6><b>Quantidade de turmas Ativa:</b></h6></td>
                                    <td><h6><b>{{$dadosgerais[1]}}</b></h6></td>
                                    <td><i class="small material-icons" style="color: green;">assignment_turned_in</i></td>
                                </tr>
                                <tr>
                                    <td><h6><b>Quantidade de turmas Inativa:</b></h6></td>
                                    <td><h6><b>{{$dadosgerais[2]}}</b></h6></td>
                                    <td><i class="small material-icons" style="color: red;">assignment_late</i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col s12">
                            <a class="waves-effect waves-light btn-large modal-trigger blue" href="#modalregistroturmasnucleo">Lista de núcleos e turma da pessoa</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <a class="waves-effect waves-light btn-large modal-trigger blue" href="#modalregistroanamneses">Lista de anamneses&emsp;&nbsp; <i class="material-icons">insert_drive_file</i></a>
                            <a class="tooltipped waves-effect waves-light btn-large light-blue darken-1" data-position="top" data-tooltip="Criar nova anamnese para {{$nomes[0]}}" href="{{Route('anamnese_create', $pessoa->id)}}"><i class="material-icons">add_to_queue</i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="coluna3" class="col s12">
                <div class="col s12">
                    <table id="employee_data">
                        <thead class="centered">
                            <tr>
                                <th style='width: 90px;'>Situação</th>
                                <th style='width: 210px;'>Turma do registro</th>
                                <th style='width: 150px;'>Comentário</th>
                                <th style='width: 100px;' class='center'>Data</th>
                                <th style='width: 100px;' class='center'>Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histpessoa as $historic)
                                <tr>
                                    <td>@if($historic->inativo == 1) Ativado @else Inativado @endif</td>
                                    @php $idturma = $historic->turma_id @endphp
                                    <td>
                                        @foreach($pessoa->turmas as $turmadapessoa)
                                            @if($turmadapessoa->id == $historic->turma_id) {{$turmadapessoa->nome}} @php break @endphp @endif
                                        @endforeach
                                    </td>
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
    </div>

    <div id="modalregistroturmasnucleo" class="modal">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <div class="container">
            <div class="row">
                <h5>Núcleo no qual a pessoa está Ativa</h5>
                <div class="col s10">
                    <table class="centered responsive-table highlight bordered">
                        <thead>
                            <tr>
                                <th>Nome do núcleo</th>
                                <th>Estado</th>
                                <th>Mais Informações</th>
                            </tr>
                        </thead>
                        @foreach($listnucleopessoa as $nucleo)
                            <tr>
                                <td>{{$nucleo->nome}}</td>
                                <td><i class="small material-icons" style="color: @if($nucleo->inativo == 1) green @else red @endif;">@if($nucleo->inativo == 1) assignment_turned_in @else assignment_late  @endif</i></td>
                                <td><a class="tooltipped" data-position="top" data-tooltip="Informações de {{$nucleo->nome}}" href="{{route('nucleo_info', $nucleo->id)}}"><i class="small material-icons">info_outline</i></a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <br><br>
            <div class="row">
                <h5>Turmas no qual a pessoa está Ativa &nbsp; <i class="small material-icons" style="color: green;">assignment_turned_in</i></h5>
                <div class="col s10">
                    <table class="centered responsive-table highlight bordered">
                        <thead>
                            <th>Nome da turma</th>
                            <th>Estado da turma</th>
                            <th>Mais Informações</th>
                        </thead>
                        <tbody>
                            @foreach ($pessoa->turmas as $turma)
                                @if($turma->pivot->inativo == 1)
                                    <tr>
                                        <td>{{$turma->nome}}</td>
                                        <td><i class="small material-icons" style="color: @if($turma->inativo == 1) green @else red @endif;">@if($turma->inativo == 1) assignment_turned_in @else assignment_late  @endif</i></td>
                                        <td><a class="tooltipped" data-position="top" data-tooltip="Informações de {{$turma->nome}}" href="{{route('turma_info', $turma->id)}}"><i class="small material-icons">info_outline</i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br><br>
            <div class="row">
                <h5>Turmas no qual a pessoa está Inativa &nbsp; <i class="small material-icons" style="color: red;">assignment_late</i></h5>
                <div class="col s10">
                    <table class="centered">
                        <thead>
                            <th>Nome da turma</th>
                            <th>Estado da turma</th>
                            <th>Mais Informações</th>
                        </thead>
                        <tbody>
                            @foreach ($pessoa->turmas as $turma)
                                @if($turma->pivot->inativo == 2)
                                    <tr>
                                        <td>{{$turma->nome}}</td>
                                        <td><i class="small material-icons" style="color: @if($turma->inativo == 1) green @else red @endif;">@if($turma->inativo == 1) assignment_turned_in @else assignment_late  @endif</i></td>
                                        <td><a class="tooltipped" data-position="top" data-tooltip="Informações de {{$turma->nome}}" href="{{route('turma_info', $turma->id)}}"><i class="small material-icons">info_outline</i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modalregistroanamneses" class="modal">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <div class="container">
            <div class="col s12">
                <table class="centered responsive-table highlight bordered">
                    <thead>
                        <th>Estado</th>
                        <th>Ano do registro</th>
                        <th>Mais informações</th>
                        <th>Edição</th>
                    </thead>
                    <tbody>
                        @foreach ($anamneses as $anamnese)
                            <tr>
                                <td><i class="small material-icons" @if($anamnese->ano != $ano) style="color: red;" @else style="color: green;"  @endif>sim_card_alert</i></td>
                                <td><p>{{$anamnese->ano}}</p></td>
                                <td><a class="tooltipped" data-position="top" data-tooltip="Informações da anamnese" href="{{Route('anamnese_info', $anamnese->id)}}"><i class="small material-icons">info</i></a></td>
                                @if($anamnese->ano == $ano)
                                    <td><a class="tooltipped" data-position="top" data-tooltip="Editar anamneses de {{$anamnese->ano}}" href="{{Route('anamneses.edit', $anamnese->id)}}"><i class="small material-icons">edit</i></a></td>
                                @else
                                    <td><p>Esta anamnese não <br> pode ser mais editada</p></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection