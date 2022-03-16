@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('nucleos.index')}}" class="breadcrumb">Núcleos</a>
    <a href="{{route('nucleos.edit', $nucleo->id)}}" class="breadcrumb">Editar</a>
@endsection
@section('title') Editar {{$nucleo->nome}} @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('nucleos.update', $nucleo->id)}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="input-field col s11 m5">
                        <i class="material-icons prefix">filter_tilt_shift</i>
                        <label for="icon_nome">Nome do núcleo: <span style="color: red;">*</span></label>
                        <input name="nome" id="icon_nome" type="text" value="{{$nucleo->nome}}" data-error=".errorTxt1" maxlength="30">
                        <div class="errorTxt1"></div>
                    </div>
                    <div class="input-field col s11 m5">
                        <i class="material-icons prefix">location_city</i>&emsp;&emsp; Bairros <span style="color: red;">*</span>
                        <select name="bairro" id="bairro_select" data-error=".errorTxt2">
                            <option value="" selected disabled>Selecione o bairro</option>
                            @foreach ($bairroslist as $bairro)
                                <option value="{{$bairro}}" @if($bairro == $nucleo->bairro) selected @endif>{{$bairro}}</option>
                            @endforeach
                        </select>
                        <div class="input-field">
                            <div class="errorTxt2"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">confirmation_number</i>
                        <label for="icon_rua">Rua: <span style="color: red;">*</span></label>
                        <input name="rua" id="icon_rua" type="text" value="{{$nucleo->rua}}" data-error=".errorTxt3" maxlength="100">
                        <div class="errorTxt3"></div>
                    </div>
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">explore</i>
                        <label for="icon_cep">CEP: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mCEP)" name="cep" id="icon_cep" type="text" value="{{$nucleo->cep}}" data-error=".errorTxt4" maxlength="9">
                        <div class="errorTxt4"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">location_on</i>
                        <label for="numero_endereco">Número: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mNum)" name="numero_endereco" id="numero_endereco" type="number" value="{{$nucleo->numero_endereco}}" data-error=".errorTxt5" maxlength="5">
                        <div class="errorTxt5"></div>
                    </div>
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">bookmark</i>
                        <label for="icon_complemento">Complemento:</label>
                        <input name="complemento" id="icon_complemento" type="text" value="{{$nucleo->complemento}}" data-error=".errorTxt6" maxlength="10">
                        <div class="errorTxt6"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">phone</i>
                        <label for="icon_telefone">Telefone: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mTel)" name="telefone" id="icon_telefone" type="text" value="{{$nucleo->telefone}}" data-error=".errorTxt7" maxlength="16">
                        <div class="errorTxt7"></div>
                    </div>
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">description</i>
                        <label for="descricao">Complemento do núcleo:</label>
                        <textarea name="descricao" id="descricao" type="textarea" class="materialize-textarea" maxlength="100">{{$nucleo->descricao}}</textarea>
                    </div>
                    <div class="container">
                        <div class="input-field col s11 m3 right">
                            <button class="btn-floating btn-large waves-effect waves-light light-blue darken-1" type="submit" name="action">
                                <i class="large material-icons left">add</i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('js/validation/validation-nucleos/validation-nucleos-edit.js')}}"></script>
@endsection