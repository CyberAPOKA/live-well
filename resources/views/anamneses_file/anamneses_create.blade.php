@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{Route('home')}}" class="breadcrumb">Pessoas</a>
    <a href="{{Route('pessoa_info', $pessoa->id)}}" class="breadcrumb">Informações</a>
    <a href="{{Route('pessoas.create')}}" class="breadcrumb">Criar Anamnese</a>
@endsection
@section('title') Anamneses de <?php $nomes = explode(' ',$pessoa->nome);?> {{$nomes[0]}} @endsection
                               
@section('content')

    <div class="container">
        @if( @isset($errors) && count($errors) > 0)
<div class="materialize-red-text" style="font-size: 20px">
@foreach( $errors->all() as $error)
<p>{{$error}}</p>
@endforeach
</div>
@endif 
        <div class="row">
            <form id="formulario" class="col s12" action="{{route('anamneses.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="pessoas_id" value="{{$pessoa->id}}" hidden>
                <input type="text" id="nascimentoValid" value="{{$pessoa->nascimento}}" hidden>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">local_parking</i>
                        <label for="peso">Peso:</label>
                        <input name="peso" id="peso" type="number" value="{{old('peso', $ultimaanamnese->peso)}}">
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">format_color_text</i>
                        <label for="altura">Altura:</label>
                        <input name="altura" id="altura" type="number" value="{{old('altura', $ultimaanamnese->altura)}}">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        Toma algum medicamento? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="toma_medicacao_click('S')" value="1" name="toma_medicacao" type="radio" 
                                {{ old('toma_medicacao')=="1" ? 'checked='.'"'.'checked'.'"' : '' }}
                                @if($ultimaanamnese->toma_medicacao != -1) checked @endif/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="toma_medicacao_click('N')" value="2" name="toma_medicacao" type="radio"
                                {{ old('toma_medicacao')=="2" ? 'checked='.'"'.'checked'.'"' : '' }}
                                @if($ultimaanamnese->toma_medicacao == -1) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="toma_medicacao_icon" class="material-icons prefix" @if($ultimaanamnese->toma_medicacao == -1) hidden @endif>description</i>
                        <label id="toma_medicacao_label" for="string_toma_medicacao" @if($ultimaanamnese->toma_medicacao == -1) hidden @endif>Qual medicamento?</label>
                        <input id="string_toma_medicacao" name="string_toma_medicacao" type="text"
                        @if($ultimaanamnese->toma_medicacao != -1) value="{{$ultimaanamnese->toma_medicacao}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        Possui alergia a algum medicamento? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="alergia_medicacao_click('S')" value="1" 
                                 {{ old('alergia_medicacao')=="1" ? 'checked='.'"'.'checked'.'"' : '' }}
                                  name="alergia_medicacao" type="radio"
                                   @if($ultimaanamnese->alergia_medicacao != -1) checked @endif/>
                               
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="alergia_medicacao_click('N')" value="2" {{ old('alergia_medicacao')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} name="alergia_medicacao" type="radio"  @if($ultimaanamnese->alergia_medicacao == -1) checked @endif/>
                                
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="alergia_medicacao_icon" class="material-icons prefix" @if($ultimaanamnese->alergia_medicacao == -1) hidden @endif>description</i>
                        <label id="alergia_medicacao_label" for="string_alergia_medicacao" @if ($ultimaanamnese->alergia_medicacao == -1) hidden @endif>Qual alergia médica?</label>
                        <input id="string_alergia_medicacao" name="string_alergia_medicacao" type="text" @if($ultimaanamnese->alergia_medicacao != -1) value="{{ old('string_alergia_medicacao', $ultimaanamnese->alergia_medicacao)}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        O usuário já fez cirurgia? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="cirurgia_click('S')" value="1" {{ old('cirurgia')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} name="cirurgia" type="radio" @if($ultimaanamnese->cirurgia != -1) checked @endif/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="cirurgia_click('N')" value="2" {{ old('cirurgia')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} name="cirurgia" type="radio"  @if($ultimaanamnese->cirurgia == -1) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="cirurgia_icon" class="material-icons prefix" @if($ultimaanamnese->cirurgia == -1) hidden @endif>description</i>
                        <label id="cirurgia_label" for="string_cirurgia" @if($ultimaanamnese->cirurgia == -1) hidden @endif>Aonde foi a cirurgia?</label>
                        <input id="string_cirurgia" name="string_cirurgia" type="text" @if($ultimaanamnese->cirurgia != -1) value="{{ old('string_cirurgia', $ultimaanamnese->cirurgia)}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        Possui dores ósseas? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="dor_ossea_click('S')" value="1" {{ old('dor_ossea')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} name="dor_ossea" type="radio"  @if($ultimaanamnese->dor_ossea != -1) checked @endif/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="dor_ossea_click('N')" value="2" {{ old('dor_ossea')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} name="dor_ossea" type="radio" @if($ultimaanamnese->dor_ossea == -1) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="dor_ossea_icon" class="material-icons prefix" @if($ultimaanamnese->dor_ossea == -1) hidden @endif>description</i>
                        <label id="dor_ossea_label" for="string_dor_ossea" @if ($ultimaanamnese->dor_ossea == -1) hidden @endif>Aonde está a dor óssea?</label>
                        <input id="string_dor_ossea" name="string_dor_ossea" type="text" @if($ultimaanamnese->dor_ossea != -1) value="{{ old('string_dor_ossea', $ultimaanamnese->dor_ossea)}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        Possui dores musculares? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="dor_muscular_click('S')" value="1" {{ old('dor_muscular')=="1" ? 'checked='.'"'.'checked'.'"' : '' }}  name="dor_muscular" type="radio" @if($ultimaanamnese->dor_muscular != -1) checked @endif/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="dor_muscular_click('N')" value="2" {{ old('dor_muscular')=="2" ? 'checked='.'"'.'checked'.'"' : '' }}  name="dor_muscular" type="radio" @if($ultimaanamnese->dor_muscular == -1) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="dor_muscular_icon" class="material-icons prefix" @if($ultimaanamnese->dor_muscular == -1) hidden @endif>description</i>
                        <label id="dor_muscular_label" for="string_dor_muscular" @if($ultimaanamnese->dor_muscular == -1) hidden @endif>Aonde está a dor muscular?</label>
                        <input id="string_dor_muscular" name="string_dor_muscular" type="text" @if($ultimaanamnese->dor_muscular != -1) value="{{ old('string_dor_muscular', $ultimaanamnese->dor_muscular)}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        Possui dores articulares? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="dor_articular_click('S')" value="1" {{ old('dor_articular')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} name="dor_articular" type="radio" @if($ultimaanamnese->dor_articular != -1) checked @endif/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="dor_articular_click('N')" value="2" {{ old('dor_articular')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} name="dor_articular" type="radio" @if($ultimaanamnese->dor_articular == -1) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="dor_articular_icon" class="material-icons prefix" @if($ultimaanamnese->dor_articular == -1) hidden @endif>description</i>
                        <label id="dor_articular_label" for="string_dor_articular" @if($ultimaanamnese->dor_articular == -1) hidden @endif>Aonde está a dor articular?</label>
                        <input id="string_dor_articular" name="string_dor_articular" type="text" @if($ultimaanamnese->dor_articular != -1)
                         value="{{ old('string_dor_articular', $ultimaanamnese->dor_articular)}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        O usuário fuma? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="fumante_click('S')" value="1" name="fumante" type="radio"
                                {{ old('fumante')=="1" ? 'checked='.'"'.'checked'.'"' : '' }}
                                 @if($ultimaanamnese->fumante != -1) checked @endif/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="fumante_click('N')" value="2" name="fumante" type="radio" 
                                {{ old('fumante')=="2" ? 'checked='.'"'.'checked'.'"' : '' }}
                                 @if($ultimaanamnese->fumante == -1) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="fumante_icon" class="material-icons prefix" @if($ultimaanamnese->fumante == -1) hidden @endif>description</i>
                        <label id="fumante_label" for="string_fumante" @if($ultimaanamnese->fumante == -1) hidden @endif>Fuma há quanto tempo?</label>
                        <input id="string_fumante" name="string_fumante" type="text" @if($ultimaanamnese->fumante != -1)
                         value="{{ old('string_fumante', $ultimaanamnese->fumante)}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        Possui doenças?
                        <select multiple name="doencas[]" id="lista_de_doencas">
                            @foreach ($doencaslist as $doenca)
                                <option value="{{$doenca->id}}" 
                                   @foreach($ultimaanamnese->doencas as $doencaconfirm)
                                     @if (old("doencas")){{ (in_array($doenca->id, old("doencas")) ? "selected":"") }}@endif
                                     @if($doenca->id == $doencaconfirm->id) selected @endif @endforeach>{{$doenca->nome}}</option>
                            @endforeach
                        </select>
                        <input type="text" value="2"  name="possui_doenca" hidden>
                    </div>
                    <div class="input-field col s12 m5">
                        <a href="#adicionardoenca" class="btn-floating modal-trigger btn-modal_inativar light-blue darken-1"><i class="material-icons">note_add</i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m8 l7 xl5">
                        <div class="file-field input-field">
                            <p>Atestado médico (.pdf):  <span style="color: red;">*</span></p>
                            <div class="btn blue">
                                <span>Abrir arquivo</span>
                                <input onchange="change_img_atestado()" id="img_atestado" type="file" name="img_atestado">
                            </div>
                            <a onclick="apagar_atestado()" class="waves-effect waves-light btn blue" style="margin-left: 5%;">Limpar</a>
                            <br><br><br>
                            <div class="file-path-wrapper">
                                <input id="atestado" name="atestado" class="file-path" type="text" data-error=".errorTxt1">
                            </div>
                            <div class="input-field">
                                <div class="errorTxt1" id="errorTxt1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">description</i>
                        <label for="observacao" >Observação</label>
                        <textarea name="observacao" id="observacao" class="materialize-textarea" maxlength="100"> {{ old('observacao', $ultimaanamnese->observacao)}}</textarea>
                        
                    </div>
                    <div class="container">
                        <div class="input-field col s12 m5 right">
                            <button class="btn-floating btn-large waves-effect waves-light light-blue darken-1" type="submit" name="action">
                                <i class="large material-icons left">add</i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
        
    <div id="adicionardoenca" class="modal" style="width: 33%; height: 52%;">
        <div class="col s1.5 right">
            <a class="modal-close"><i class="material-icons medium" style="color: red;">cancel</i></a>
        </div>
        <br><br>
        <div class="container">
            <div class="row">
                <div class="input-field col s12 m5">
                    <h5>Criar Doença</h5>
                </div>
            </div>
            <form id="ajax_doenca">
                @csrf
                <div class="modal-content">
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <i class="material-icons prefix">new_releases</i>
                            <input id="nome_doenca" {{ old('nome_doenca')}} type="text">
                            <label for="nome_doenca">Nome da doença: <span style="color: red;">*</span></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s10 m10">
                            <i class="material-icons prefix">description</i>
                            <textarea id="descricao_doenca" class="materialize-textarea" maxlength="100"></textarea>
                            <label for="descricao_doenca">Observação: <span style="color: red;">*</span></label>
                        </div>
                        <div class="input-field col s2 m2 right">
                            <a class="btn-floating btn-large" id="botao_doenca"><i class="material-icons">add</i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('js/validation/validation-anamneses/validation-anamneses-create-edit.js')}}"></script>
@endsection