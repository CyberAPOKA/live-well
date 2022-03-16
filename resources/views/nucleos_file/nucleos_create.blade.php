@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('nucleos.index')}}" class="breadcrumb">Núcleos</a>
    <a href="{{route('nucleos.create')}}" class="breadcrumb">Criar</a>
@endsection
@section('title') Criar núcleo @endsection
@section('content')
@if(isset($errors) && count($errors) > 0)
    @foreach($errors->all() as $error)
        <div style="margin-left: 15%; margin-top: 1%;">
            <div class="chip red lighten-2">
                {{$error}}
                <i class="close material-icons">close</i>
            </div>
        </div>
    @endforeach
@endif
    <div class="container">
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('nucleos.store')}}" method="post">
                @csrf
                <input type="text" name="cidade" value="São Leopoldo" hidden>
                <input type="number" name="inativo" value="1" hidden>
                <div class="row">
                    <div class="input-field col s11 m5">
                        <i class="material-icons prefix">filter_tilt_shift</i>
                        <label for="icon_nome">Nome do núcleo: <span style="color: red;">*</span></label>
                        <input name="nome" id="icon_nome" type="text" data-error=".errorTxt1" maxlength="30">
                        <div class="errorTxt1"></div>
                    </div>
                    <div class="col s11 m5">
                        <input type="text" name="selectorvalidation" id="selectorvalidation" data-error=".errorTxt2" hidden>
                        <i class="material-icons prefix">location_city</i>&emsp; Bairros <span style="color: red;">*</span>
                        <select name="bairro" id="bairro_select">
                            <option value="" disabled selected>Selecione o bairro</option>
                            @foreach ($bairroslist as $bairro)
                                <option value="{{$bairro}}">{{$bairro}}</option>
                            @endforeach
                        </select>
                        <div class="input-field">
                            <div class="errorTxt2" id="errorTxt2"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">confirmation_number</i>
                        <label for="icon_rua">Rua: <span style="color: red;">*</span></label>
                        <input name="rua" id="icon_rua" type="text" data-error=".errorTxt3" maxlength="100">
                        <div class="errorTxt3"></div>
                    </div>
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">explore</i>
                        <label for="icon_cep">CEP: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mCEP)" name="cep" id="icon_cep" type="text" data-error=".errorTxt4" maxlength="9">
                        <div class="errorTxt4"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">location_on</i>
                        <label for="icon_numero_endereco">Número: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mNum)" name="numero_endereco" id="icon_numero_endereco" type="number" data-error=".errorTxt5" maxlength="5">
                        <div class="errorTxt5"></div>
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">bookmark</i>
                        <label for="icon_complemento">Complemento de endereço:</label>
                        <input name="complemento" id="icon_complemento" type="text" maxlength="10">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11 m5 xl5">
                        <i class="material-icons prefix">phone</i>
                        <label for="icon_telefone">Telefone: <span style="color: red;">*</span></label>
                        <input onkeydown="javascript: fMasc(this, mTel)" name="telefone" id="icon_telefone" type="text" data-error=".errorTxt6" maxlength="16">
                        <div class="errorTxt6"></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s11 m5 xl5">
                            <i class="material-icons prefix">description</i>
                            <label for="icon_descricao">Complemento do núcleo:</label>
                            <textarea name="descricao" id="icon_descricao" type="textarea" class="materialize-textarea" maxlength="100"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11 m5 xl4">
                        <input type="text" name="radiovalidation" id="radiovalidation" data-error=".errorTxt7" hidden>
                        <i class="material-icons prefix">sim_card_alert</i>&emsp;&emsp; Núcleo ativo | inativo: <span style="color: red;">*</span>
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
                        <div class="input-field">
                            <div class="errorTxt7" id="errorTxt7"></div>
                        </div>
                    </div>
                    <div class="input-field col s11 m3 right">
                        <button class="btn-floating btn-large waves-effect waves-light light-blue darken-1" type="submit" name="action">
                            <i class="large material-icons left">add</i>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('js/validation/validation-nucleos/validation-nucleos-create.js')}}"></script>
@endsection