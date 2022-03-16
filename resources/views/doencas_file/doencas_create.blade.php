@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('doencas.index')}}" class="breadcrumb">Doenças</a>
    <a href="{{route('doencas.create')}}" class="breadcrumb">Criar</a>
@endsection
@section('title') Criar doença @endsection
@section('content')
    <div class="container">
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('doencas.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="input-field col s12 m8 l4">
                        <i class="material-icons prefix">new_releases</i> 
                        <label for="nome">Nome da doença: <span style="color: red;">*</span></label>
                        <input name="nome" id="nome" type="text" class="validate" data-error=".errorTxt1" maxlength="30">
                        <div class="errorTxt1"></div>
                    </div>
                    <div class="input-field col s12 m8 l4">
                        <i class="material-icons prefix">description</i>
                        <label for="descricao">Observação <span style="color: red;">*</span></label>
                        <textarea name="descricao" id="descricao" class="materialize-textarea" data-error=".errorTxt2" maxlength="100"></textarea>
                        <div class="errorTxt2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <button class="btn-floating btn-large waves-effect waves-light light-blue darken-1" type="submit" name="action">
                            <i class="large material-icons left">add</i>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('js/validation/validation-doencas.js')}}"></script>
@endsection