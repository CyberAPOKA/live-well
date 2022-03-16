@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('turmas.index')}}" class="breadcrumb">Turmas</a>
    <a href="{{route('turmas.edit', $turma->id)}}" class="breadcrumb">Editar</a>
@endsection
@section('title') Editar {{$turma->nome}} @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('turmas.update', $turma->id)}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">group</i>
                        <label for="_prefix">Nome da turma: <span style="color: red;">*</span></label>
                        <input name="nome" id="prefix" type="text" value="{{$turma->nome}}" data-error=".errorTxt1" maxlength="30">
                        <div class="errorTxt1"></div>
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">assignment</i>
                        <label for="prefix">Limite: <span style="color: red;">*</span></label>
                        <input name="limite" id="prefix" type="number" value="{{$turma->limite}}" data-error=".errorTxt2">
                        <div class="errorTxt2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">hourglass_full</i>
                        <label for="icon_horario_inicial">Horário Inicial: <span style="color: red;">*</span></label>
                        <input name="horario_inicial" id="icon_horario_inicial" type="text" class="timepicker" value="{{$turma->horario_inicial}}" data-error=".errorTxt3" maxlength="8">
                        <div class="errorTxt3"></div>
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">hourglass_empty</i>
                        <label for="icon_horario_final">Horário Final: <span style="color: red;">*</span></label>
                        <input name="horario_final" id="icon_horario_final" type="text" class="timepicker" value="{{$turma->horario_final}}" data-error=".errorTxt4" maxlength="8">
                        <div class="errorTxt4"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <input type="text" name="selectordatavalidation" id="selectordatavalidation" value="1" data-error=".errorTxt5" hidden>
                        <i class="material-icons prefix">date_range</i>&emsp;&emsp; Dias da semana <span style="color: red;">*</span>
                        <select multiple name="data_semanal[]" id="lista_de_dias">
                            @foreach ($dias_semana as $dia)
                                <option value="{{$dia}}" @foreach($datas_escolhidas as $data_escolhida) @if($data_escolhida == $dia) selected @endif @endforeach>{{$dia}}</option>
                            @endforeach
                        </select>
                        <div class="input-field">
                            <div class="errorTxt5" id="errorTxt5"></div>
                        </div>
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">filter_tilt_shift</i>&emsp;&emsp; Núcleos <span style="color: red;">*</span>
                        <select name="nucleo_id" id="lista_de_nucleos">
                            @foreach ($nucleoslist as $nucleo)
                                <option value="{{$nucleo->id}}" @if($turma->nucleo_id == $nucleo->id) selected @endif>{{$nucleo->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m10 l5">
                        <i class="material-icons prefix">description</i>
                        <label for="descricao">Complemento da turma:</label>
                        <textarea name="descricao" id="descricao" type="textarea" class="materialize-textarea" maxlength="100">{{$turma->descricao}}</textarea>
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
    <script src="{{asset('js/validation/validation-turmas/validation-turmas-edit.js')}}"></script>
@endsection