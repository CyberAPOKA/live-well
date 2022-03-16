@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('pessoas.index')}}" class="breadcrumb">Pessoas</a>
    <a href="{{Route('pessoas.edit', $pessoa->id)}}" class="breadcrumb">Editar</a>
@endsection
@section('title') Editar <?php $nomes = explode(' ',$pessoa->nome);?> {{$nomes[0]}} @endsection
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
            <form id="formulario" class="col s12" action="{{route('pessoas.update', $pessoa->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="text" id="id" name="id" value="{{$pessoa->id}}" hidden/>
                <h5>Registro da pessoa:</h5>
                <a id="muda_foto" onclick="muda_foto('{{asset('/img/unset_image_3x4.png')}}')" class="waves-effect waves-light btn-large blue" href="#!">Trocar para pastas&emsp;&nbsp; <i class="material-icons">satellite</i></a>
                <div id="image_file" class="row" style="display: none">
                    <div class="file-field input-field col s12 m12 l8 xl6">
                        <br><br>
                        <p>Foto 3 por 4 (.jpeg | .png | .jpg):</p>
                        <div class="btn blue">
                            <span>Abrir arquivo</span>
                            <input onchange="change_img_3x4()" id="img_3x4" type="file" name="img_3x4">
                        </div>
                        <a onclick="apagar_3_4()" class="waves-effect waves-light btn blue" style="margin-left: 5%;">Limpar</a>
                        <br><br><br>
                        <div class="file-path-wrapper container left">
                            <input id="3x4" class="file-path" type="text" value="{{$pessoa->foto}}">
                        </div>
                    </div>
                    <div class="input-field col s12 m12 l5">
                        <img id="3x4_image" class="materialboxed imagensparafoto" src="@if(!is_null($pessoa->foto)) {{asset($pessoa->foto)}} @else {{asset('/img/unset_image_3x4.png')}} @endif">
                    </div>
                </div>
                <div id="image_web" class='row'>
                    <div class="file-field input-field col s12 m12 l8 xl6">
                        <br><br>
                        <p>Foto 3 por 4:</p>
                        <a href="#fotomodal" onclick="foto()" class="modal-trigger btn-large light-blue darken-1">Abrir webcam</a>
                        <a onclick="apagar_web()" class="btn-large waves-effect waves-light blue" style="margin-left: 5%;">limpar</a>
                    </div>
                    <div class="file-field input-field col s12 s12 m12 l5">
                        <img id="img_web" class="materialboxed imagensparafoto" src="@if(!is_null($pessoa->foto)) {{asset($pessoa->foto)}} @else {{asset('/img/unset_image_3x4.png')}} @endif">
                        <input id="web_image" type="text" name="foto_web" id="base64" hidden>
                        <canvas id="canvas_foto" width="400" height="300" hidden></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">account_circle</i>
                        <label for="nome">Nome:  <span style="color: red;">*</span></label>
                        <input name="nome" id="nome" type="text" value="{{$pessoa->nome}}" maxlength="100">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">child_friendly</i>
                        <label for="nascimento">Data de nascimento:  <span style="color: red;">*</span></label>
                        <input id="nascimento" type="text" class="datepicker" name="nascimento" value="{{$pessoa->nascimento}}" maxlength="10">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">credit_card</i>
                        <label for="cpf">CPF próprio:</label>
                        <input onkeydown="javascript: fMasc(this, mCPF)" name="cpf" id="cpf" type="text" value="{{$pessoa->cpf}}" maxlength="14">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">credit_card</i>
                        <label for="cpf_responsavel">CPF do responsavel:</label>
                        <input onkeydown="javascript: fMasc(this, mCPF)" name="cpf_responsavel" id="cpf_responsavel" type="text" value="{{$pessoa->cpf_responsavel}}" maxlength="14">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">assignment_ind</i>
                        <label for="rg">RG:</label>
                        <input name="rg" id="rg" type="text" value="{{$pessoa->rg}}" maxlength="13">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">assignment_ind</i>
                        <label for="rg_responsavel">RG do responsavel:</label>
                        <input name="rg_responsavel" id="rg_responsavel" type="text" value="{{$pessoa->rg_responsavel}}" maxlength="13">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">business</i>
                        <label for="cidade">Cidade:</label>
                        <input name="cidade" id="cidade" type="text" value="{{$pessoa->cidade}}" maxlength="70">
                    </div>
                    <div class="input-field col s12 m5">
                        <a class="btn-floating right light-blue darken-1" style="margin-top: -10%;" onclick="change_bairro()"><i class="material-icons">cached</i></a>
                        <div id="div_bairro_list" @if($pessoa->bairro != null) hidden @endif>
                            <i class="material-icons prefix">location_city</i>&emsp;&emsp;&emsp;Bairros
                            <select name="bairro" id="bairro_select">
                                <option value="" selected disabled>Selecione o bairro</option>
                                @foreach ($bairroslist as $bairro)
                                    <option value="{{$bairro}}">{{$bairro}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="div_bairro_string" @if($pessoa->bairro == null) hidden @endif>
                            <i class="material-icons prefix">location_city</i>
                            <label for="string_bairro">Bairro:</label>
                            <input id="string_bairro" name="string_bairro" type="text" value="{{$pessoa->bairro}}" maxlength="70">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">confirmation_number</i>
                        <label for="rua">Rua:</label>
                        <input name="rua" id="rua" type="text"  value="{{$pessoa->rua}}" maxlength="70">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">explore</i>
                        <label for="cep">CEP:</label>
                        <input onkeydown="javascript: fMasc(this, mCEP)" name="cep" id="cep" type="text" value="{{$pessoa->cep}}" maxlength="9">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">location_on</i>
                        <label for="numero_endereco">Número:</label>
                        <input onkeydown="javascript: fMasc(this, mNum)" name="numero_endereco" id="numero_endereco" type="number" value="{{$pessoa->numero_endereco}}" maxlength="5">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">bookmark</i>
                        <label for="complemento">Complemento de endereço:</label>
                        <input name="complemento" id="complemento" type="text" value="{{$pessoa->complemento}}" maxlength="10">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">phone</i>
                        <label for="icon_telephone">Telefone:</label>
                        <input onkeydown="javascript: fMasc(this, mTel)" name="telefone" id="icon_telephone" type="tel" value="{{$pessoa->telefone}}" maxlength="16">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">contact_phone</i>
                        <label for="icon_telephone">Telefone de emergência:</label>
                        <input onkeydown="javascript: fMasc(this, mTel)" name="telefone_emergencia" id="icon_telephone" type="tel" value="{{$pessoa->telefone_emergencia}}" maxlength="16">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">person</i>
                        <label for="nome_do_pai">Nome do pai:</label>
                        <input name="nome_do_pai" id="nome_do_pai" type="text" value="{{$pessoa->nome_do_pai}}" maxlength="100">
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">person_outline</i>
                        <label for="nome_da_mae">Nome da mãe:</label>
                        <input name="nome_da_mae" id="nome_da_mae" type="text" value="{{$pessoa->nome_da_mae}}" maxlength="100">
                    </div>
                    <div class="input-field col s4">
                        <i class="material-icons prefix">person_add</i>
                        <label for="pessoa_emergencia">Pessoa emergência:</label>
                        <input name="pessoa_emergencia" id="pessoa_emergencia" type="text" value="{{$pessoa->pessoa_emergencia}}" maxlength="100">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="material-icons prefix">child_care</i>
                        <label for="filhos">Filhos:</label>
                        <input name="filhos" id="filhos" type="number" value="{{$pessoa->filhos}}">
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="material-icons prefix">people</i>
                        <label for="irmaos">Irmãos:</label>
                        <input name="irmaos" id="irmaos" type="number" value="{{$pessoa->irmaos}}">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        Possui convênio médico?
                        <p>
                            <label>
                                <input onclick="convenio_medico_click('S')" value="1" name="convenio_medico" type="radio" @if($pessoa->convenio_medico != -1) checked @endif/>
                                <span>Sim</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input onclick="convenio_medico_click('N')" value="2" name="convenio_medico" type="radio" @if($pessoa->convenio_medico == -1) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="convenio_icon" class="material-icons prefix" @if($pessoa->convenio_medico == -1) hidden @endif>add_box</i>
                        <label id="convenio_label" for="string_convenio_medico" @if($pessoa->convenio_medico == -1) hidden @endif>Convênio médico:</label>
                        <input id="string_convenio_medico" name="string_convenio_medico" type="text" @if($pessoa->convenio_medico != -1) value="{{$pessoa->convenio_medico}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m8 l7 xl5">
                        <div class="file-field input-field">
                            <p>matricula escolar (.pdf):</p>
                            <div class="btn blue">
                                <span>matricula escolar</span>
                                <input onchange="change_img_matricula()" id="img_matricula" type="file" name="img_matricula">
                            </div>
                            <a onclick="apagar_matricula()" class="waves-effect waves-light btn blue" style="margin-left: 5%;">Limpar</a>
                            <br><br><br>
                            <div class="file-path-wrapper">
                                <input id="matricula" name="matricula" class="file-path" type="text" value="{{$pessoa->matricula}}">
                            </div>
                        </div>
                    </div>
                </div>             
                <div class="row">
                    <div class="input-field col s12 m3">
                        Sexo: <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input value="M" name="sexo" type="radio" @if($pessoa->sexo == 'M') checked @endif/>
                                <span>Masculino</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="F" name="sexo" type="radio"  @if($pessoa->sexo == 'F') checked @endif/>
                                <span>Feminino</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m3">
                        Mora com os pais?
                        <p>
                            <label>
                                <input value="1" name="mora_com_os_pais" type="radio" @if($pessoa->mora_com_os_pais == 1) checked @endif/>
                                <span>Sim</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="2" name="mora_com_os_pais" type="radio" @if($pessoa->mora_com_os_pais == 2) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m3">
                        Estado Civil:
                        <p>
                            <label>
                                <input value="Solteiro(a)" name="estado_civil" type="radio" @if($pessoa->estado_civil == 'Solteiro(a)') checked @endif/>
                                <span>Solteiro(a)</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="Casado(a)" name="estado_civil" type="radio" @if($pessoa->estado_civil == 'Casado(a)') checked @endif/>
                                <span>Casado(a)</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="Viuvo(a)" name="estado_civil" type="radio" @if($pessoa->estado_civil == 'Viuvo(a)') checked @endif/>
                                <span>Viuvo(a)</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="Divorciado(a)" name="estado_civil" type="radio" @if($pessoa->estado_civil == 'Divorciado(a)') checked @endif/>
                                <span>Divorciado(a)</span>
                            </label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        A pessoa faleceu?
                        <p>
                            <label>
                                <input onclick="morte_click('S')" value="1" name="morte" type="radio" @if($pessoa->morte != null) checked @endif/>
                                <span>Sim</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input onclick="morte_click('N')" value="2" name="morte" type="radio" @if($pessoa->morte == null) checked @endif/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="morte_icon" class="material-icons prefix" @if($pessoa->morte == null) hidden @endif>event_busy</i>
                        <label id="morte_label" for="string_morte" @if($pessoa->morte == null) hidden @endif>Data do falecimento:</label>
                        <input id="string_morte" name="string_morte" class="datepicker" type="text" @if($pessoa->morte != null) value="{{$pessoa->morte}}" @else hidden @endif>
                    </div>
                </div>
                <div class="row">
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
    <script src="{{asset('js/validation/validation-pessoas/validation-pessoas-edit.js')}}"></script>
@endsection