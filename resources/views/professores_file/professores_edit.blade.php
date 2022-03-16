@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('professor.index')}}" class="breadcrumb">Professores</a>
    <a href="{{route('professor.edit', $professor->id)}}" class="breadcrumb">Editar</a>
@endsection
@section('title') Editar <?php $nomes = explode(' ',$professor->nome);?> {{$nomes[0]}} @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('professor.update', $professor->id)}}" method="post">
                @csrf
                <input type="text" id="id" name="id" value="{{$professor->id}}" hidden/>
                <input type="text" id="id" name="id_user" value="{{$professor->user_id}}" hidden/>
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">account_circle</i>
                        <label for="nome">Nome: <span style="color: red;">*</span></label>
                        <input name="nome" id="nome" type="text" value="{{$professor->nome}}" maxlength="100">
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">child_friendly</i>
                        <label for="nascimento">Nascimento: <span style="color: red;">*</span></label>
                        <input name="nascimento" id="nascimento" type="text" class="datepicker" value="{{$professor->nascimento}}" maxlength="10">
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">recent_actors</i>
                        <label for="matricula">Matricula: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mNum)" id="matricula" name="matricula" type="text" value="{{$professor->matricula}}" maxlength="30">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">business</i>
                        <label for="bairro">Cidade: <span style="color: red;">*</span></label>
                        <input name="cidade" id="bairro" type="text" value="{{$professor->cidade}}" maxlength="70">
                    </div>
                    <div class="input-field col s12 m5">
                        <a  onclick="change_bairro()" class="waves-effect waves-light btn-floating right" style="margin-top: -10%; background-color: #039be5;"><i class="material-icons">cached</i></a>
                        <div id="div_bairro_list" @if($professor->bairro != null) hidden @endif>
                            <i class="material-icons prefix">location_city</i>&emsp;&emsp; Bairros <span style="color: red;">*</span>
                            <select name="bairro" id="bairro_select">
                                <option value="" selected disabled>Selecione o bairro</option>
                                @foreach ($bairroslist as $bairro)
                                    <option value="{{$bairro}}">{{$bairro}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="div_bairro_string" @if($professor->bairro == null) hidden @endif>
                            <i class="material-icons prefix">location_city</i>
                            <label for="string_bairro">Bairro: <span style="color: red;">*</span></label>
                            <input id="string_bairro" name="string_bairro" type="text" value="{{$professor->bairro}}" maxlength="70">
                        </div>
                        <input type="text" name="selectorbairrovalidation" id="selectorbairrovalidation" value='1' hidden>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">confirmation_number</i>
                        <label for="rua">Rua: <span style="color: red;">*</span></label>
                        <input name="rua" id="rua" type="text" value="{{$professor->rua}}" maxlength="70">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">explore</i>
                        <label for="cep">CEP: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mCEP)" name="cep" id="cep" type="text" value="{{$professor->cep}}" maxlength="9">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">location_on</i>
                        <label for="numero_endereco">Número: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mNum)" name="numero_endereco" id="numero_endereco" type="number" value="{{$professor->numero_endereco}}" maxlength="5">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">location_on</i>
                        <label for="complemento">Complemento de endereço:</label>
                        <input onkeydown="javascript: fMasc(this, mNum)" name="complemento" id="complemento" type="number" value="{{$professor->numero_endereco}}" maxlength="10">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">phone</i>
                        <label for="telephone">Telephone: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mTel)" name="telefone" id="icon_telephone" type="tel" value="{{$professor->telefone}}" maxlength="16">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">email</i>
                        <label for="email">E-mail: <span style="color: red;">*</span></label>
                        <input name="email" id="email" type="tel" value="{{$professor->email}}" maxlength="80">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">credit_card</i>
                        <label for="cpf">CPF: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mCPF)" name="cpf" id="cpf" type="text" value="{{$professor->cpf}}" maxlength="14">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">assignment_ind</i>
                        <label for="rg">RG: <span style="color: red;">*</span></label>
                        <input name="rg" id="rg" type="text" value="{{$professor->rg}}" maxlength="13">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">school</i>
                        <label for="formacao">Formação: <span style="color: red;">*</span></label>
                        <input name="formacao" id="formacao" type="text" value="{{$professor->formacao}}" maxlength="30">
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">book</i>
                        <label for="curso">Curso: <span style="color: red;">*</span></label>
                        <input name="curso" id="curso" type="text" value="{{$professor->curso}}" maxlength="30">
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">directions_bike</i>
                        <label for="cref">CREF: <span style="color: red;">*</span></label>
                        <input name="cref" id="cref" type="text" value="{{$professor->cref}}" maxlength="30">
                    </div>
                </div>
                <div class="container">
                    <div class="input-field col s12 m3 right">
                        <button class="btn-floating btn-large waves-effect waves-light light-blue darken-1" type="submit" name="action">
                            <i class="large material-icons left">add</i>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('js/validation/validation-professores/validation-professores-edit.js')}}"></script>
@endsection