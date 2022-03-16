@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('turmas.index')}}" class="breadcrumb">Turmas</a>
    <a href="{{route('turmas.create')}}" class="breadcrumb">Criar</a>
@endsection
@section('title') Criar turma @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('turmas.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">group</i>
                        <label for="icon_nome">Nome da turma: <span style="color: red;">*</span></label>
                        <input name="nome" id="icon_nome" type="text" data-error=".errorTxt1" maxlength="30">
                        <div class="errorTxt1"></div>
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">assignment</i>
                        <label for="icon_limite">Limite: <span style="color: red;">*</span></label>
                        <input name="limite" id="icon_limite" type="number" data-error=".errorTxt2">
                        <div class="errorTxt2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">hourglass_full</i>
                        <label for="icon_horario_inicial">Horário Inicial: <span style="color: red;">*</span></label>
                        <input name="horario_inicial" id="icon_horario_inicial" type="text" class="timepicker" data-error=".errorTxt3" maxlength="8">
                        <div class="errorTxt3" id="errorTxt3"></div>
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">hourglass_empty</i>
                        <label for="icon_horario_final">Horário Final: <span style="color: red;">*</span></label>
                        <input name="horario_final" id="icon_horario_final" type="text" class="timepicker" data-error=".errorTxt4" maxlength="8">
                        <div class="errorTxt4" id="errorTxt4"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <input type="text" name="selectordatavalidation" id="selectordatavalidation" data-error=".errorTxt5" hidden>
                        <i class="material-icons prefix">date_range</i>&emsp;&emsp;&emsp;Dias da semana <span style="color: red;">*</span>
                        <select multiple name="data_semanal[]" id="lista_de_dias">
                            @foreach ($dias_semana as $dia)
                                <option value="{{$dia}}">{{$dia}}</option>
                            @endforeach
                        </select>
                        <div class="input-field">
                            <div class="errorTxt5" id="errorTxt5"></div>
                        </div>
                    </div>
                    <div class="input-field col s12 m5">
                        <input type="text" name="selectornucleosvalidation" id="selectornucleosvalidation" data-error=".errorTxt6" hidden>
                        <i class="material-icons prefix">filter_tilt_shift</i>&emsp;&emsp;&emsp;Núcleos <span style="color: red;">*</span>
                        <select name="nucleo_id" id="lista_de_nucleos">
                            <option value="" selected disabled>Selecione o núcleo</option>
                            @foreach ($nucleoslist as $nucleo)
                                <option value="{{$nucleo->id}}">{{$nucleo->nome}}</option>
                            @endforeach
                        </select>
                        <div class="input-field">
                            <div class="errorTxt6" id="errorTxt6"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m10 l5">
                        <i class="material-icons prefix">description</i>
                        <label for="icon_descricao">Complemento da turma:</label>
                        <textarea name="descricao" id="icon_descricao" type="textarea" class="materialize-textarea" maxlength="100"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8 m5 xl4">
                        <input type="text" name="radiovalidation" id="radiovalidation" data-error=".errorTxt7" hidden>
                        <i class="material-icons prefix">sim_card_alert</i>&emsp;&emsp; Turma ativa | inativa: <span style="color: red;">*</span>
                        <div style="margin-left: 30%;">
                            <p>
                                <label>
                                    <input value="1" name="inativo" type="radio"/>
                                    <span>Ativa</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input value="2" name="inativo" type="radio"/>
                                    <span>Inativa</span>
                                </label>
                            </p>
                        </div>
                        <div class="input-field">
                            <div class="errorTxt7" id="errorTxt7"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="input-field col s12 m3 right">
                            <button class="btn-floating btn-large waves-effect waves-light light-blue darken-1" type="submit" name="action">
                                <i class="large material-icons left">add</i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('js/validation/validation-turmas/validation-turmas-create.js')}}"></script>
@endsection