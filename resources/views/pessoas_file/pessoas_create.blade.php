@extends('layouts.app')
@section('breadcrumbs')
    <a href="{{route('home')}}" class="breadcrumb">Home</a>
    <a href="{{route('pessoas.index')}}" class="breadcrumb">Pessoas</a>
    <a href="{{route('pessoas.create')}}" class="breadcrumb">Criar</a>
@endsection
@section('title') Criar pessoa @endsection
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
            <form id="formulario" class="col s12" action="{{route('pessoas.store')}}" method="post" enctype="multipart/form-data">
                @csrf
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
                            <input id="3x4" class="file-path" type="text">
                        </div>
                    </div>
                    <div class="input-field col s12 m12 l5">
                        <img id="3x4_image" class="materialboxed imagensparafoto" src="{{asset('/img/unset_image_3x4.png')}}">
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
                        <img id="img_web" class="materialboxed imagensparafoto" src="{{asset('/img/unset_image_3x4.png')}}">
                        <input id="web_image" type="text" name="foto_web" id="base64" hidden>
                        <canvas id="canvas_foto" width="400" height="300" hidden></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">account_circle</i>
                        <label for="nome">Nome: <span style="color: red;">*</span></label>
                        <input name="nome" id="nome" type="text" value="{{ old('nome')}}" maxlength="100">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">child_friendly</i>
                        <label for="nascimento">Data de nascimento:  <span style="color: red;">*</span></label>
                        <input id="nascimento" type="text" value="{{ old('nascimento')}}" class="datepicker" name="nascimento" maxlength="10">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">credit_card</i>
                        <label for="cpf">CPF próprio:</label>
                        <input onkeydown="javascript: fMasc(this, mCPF)" value="{{ old('cpf')}}" name="cpf" id="cpf" type="text" maxlength="14">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">credit_card</i>
                        <label for="cpf_responsavel">CPF do responsável:</label>
                        <input onkeydown="javascript: fMasc(this, mCPF)" value="{{ old('cpf_responsavel')}}" name="cpf_responsavel" id="cpf_responsavel" data-error=".tee" type="text" maxlength="14">
                        <div class="tee" id="tee"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">assignment_ind</i>
                        <label for="rg">RG:</label>
                        <input name="rg" value="{{ old('rg')}}" id="rg" type="text" maxlength="13">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">assignment_ind</i>
                        <label for="rg_responsavel">RG do responsável:</label>
                        <input name="rg_responsavel" value="{{ old('rg_responsavel')}}" id="rg_responsavel" type="text" maxlength="13">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">business</i>
                        <label for="cidade">Cidade:</label>
                        <input name="cidade" value="{{ old('cidade')}}" id="cidade" type="text" value="São Leopoldo" maxlength="70">
                    </div>
                    <div class="input-field col s12 m5">
                        <a onclick="change_bairro()" class="waves-effect waves-light btn-floating right" style="margin-top: -10%; background-color: #039be5;"><i class="material-icons">cached</i></a>
                        <div id="div_bairro_list">
                            <i class="material-icons prefix">location_city</i>&emsp;&emsp;&emsp;Bairros
                            <select name="bairro" id="bairro_select">
                                <option selected disabled>Selecione o bairro</option>
                                @foreach ($bairroslist as $bairro)
                                    <option value="{{$bairro}}" {{ (Input::old("bairro") == $bairro ? "selected":"") }}>{{$bairro}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        <div id="div_bairro_string" hidden>
                            <i class="material-icons prefix">location_city</i>
                            <label for="string_bairro">Bairro:</label>
                            <input id="string_bairro" name="string_bairro" type="text" maxlength="70">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">confirmation_number</i>
                        <label for="rua">Rua:</label>
                        <input name="rua" value="{{ old('rua')}}" id="rua" type="text" maxlength="70">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">explore</i>
                        <label for="cep">CEP:</label>
                        <input onkeydown="javascript: fMasc(this, mCEP)" name="cep" value="{{ old('cep')}}" id="cep" type="text" maxlength="9">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">location_on</i>
                        <label for="numero_endereco">Número:</label>
                        <input onkeydown="javascript: fMasc(this, mNum)" name="numero_endereco" value="{{ old('numero_endereco')}}"value="{{ old('numero_endereco')}}" id="numero_endereco" type="number" maxlength="5">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">bookmark</i>
                        <label for="complemento">Complemento de endereço:</label>
                        <input name="complemento" value="{{ old('complemento')}}" id="complemento" type="text" maxlength="10">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">phone</i>
                        <label for="telephone">Telefone:</label>
                        <input onkeydown="javascript: fMasc(this, mTel)" value="{{ old('telefone')}}" name="telefone" id="telephone" type="tel" maxlength="16">
                    </div>
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">contact_phone</i>
                        <label for="telephone_emergencia">Telefone emergência:</label>
                        <input onkeydown="javascript: fMasc(this, mTel)" value="{{ old('telefone_emergencia')}}" name="telefone_emergencia" id="telephone_emergencia" type="tel" maxlength="16">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">person</i>
                        <label for="nome_do_pai">Nome do pai:</label>
                        <input name="nome_do_pai" value="{{ old('nome_do_pai')}}" id="nome_do_pai" type="text" maxlength="100">
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">person_outline</i>
                        <label for="nome_da_mae">Nome do mãe:</label>
                        <input name="nome_da_mae" value="{{ old('nome_da_mae')}}" id="nome_da_mae" type="text" maxlength="100">
                    </div>
                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">person_add</i>
                        <label for="pessoa_emergencia">Pessoa emergência:</label>
                        <input name="pessoa_emergencia" value="{{ old('pessoa_emergencia')}}" id="pessoa_emergencia" type="text" maxlength="100">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="material-icons prefix">child_care</i>
                        <label for="filhos">Filhos:</label>
                        <input name="filhos" id="filhos" type="number" min=0 value="{{old('filhos')}}">
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="material-icons prefix">people</i>
                        <input name="irmaos" id="irmaos" type="number" min=0 value="{{old('irmaos')}}">
                        <label for="irmaos">Irmãos:</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        Possui convênio médico?
                        <p>
                            <label>
                                <input onclick="convenio_medico_click('S')" {{ old('convenio_medico')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} value="1" name="convenio_medico" type="radio"/>
                                <span>Sim</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input onclick="convenio_medico_click('N')" {{ old('convenio_medico')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} value="2" name="convenio_medico" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="convenio_icon" class="material-icons prefix" hidden>add_box</i>
                        <label id="convenio_label" for="string_convenio_medico" hidden>Convênio médico:</label>
                        <input id="string_convenio_medico" value="{{ old('string_convenio_medico')}}" name="string_convenio_medico" type="text" hidden>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m8 l7 xl5">
                        <div class="file-field input-field">
                            <p>matricula escolar (.pdf):</p>
                            <div class="btn blue">
                                <span>Abrir arquivo</span>
                                <input onchange="change_img_matricula()" id="img_matricula" type="file" name="img_matricula">
                            </div>
                            <a onclick="apagar_matricula()" class="waves-effect waves-light btn blue" style="margin-left: 5%;">Limpar</a>
                            <br><br><br>
                            <div class="file-path-wrapper">
                                <input id="matricula" name="matricula" class="file-path" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <input type="text" name="sexovalidation" id="sexovalidation" data-error=".errorTxt1" hidden>
                        Sexo:  <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input value="M"  {{ old('sexo')=="M" ? 'checked='.'"'.'checked'.'"' : '' }} name="sexo" type="radio"/>
                                <span>Masculino</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="F"  {{ old('sexo')=="F" ? 'checked='.'"'.'checked'.'"' : '' }} name="sexo" type="radio"/>
                                <span>Feminino</span>
                            </label>
                        </p>
                        <div class="errorTxt1" id="errorTxt1" style="margin-left: -13%;"></div>
                    </div>
                    <div class="input-field col s12 m3" value="{{ old('mora_com_os_pais') }}">
                        Mora com os pais?
                        <p>
                            <label>
                                <input value="1" {{ old('mora_com_os_pais')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} name="mora_com_os_pais" type="radio"/>
                                <span>Sim</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="2" {{ old('mora_com_os_pais')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} name="mora_com_os_pais" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                    </div>
                    <div class="input-field col s12 m3">
                        Estado Civil:
                        <p>
                            <label>
                                <input value="Solteiro(a)" {{ old('estado_civil')=="Solteiro(a)" ? 'checked='.'"'.'checked'.'"' : '' }} name="estado_civil" type="radio"/>
                                <span>Solteiro(a)</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="Casado(a)" {{ old('estado_civil')=="Casado(a)" ? 'checked='.'"'.'checked'.'"' : '' }} name="estado_civil" type="radio"/>
                                <span>Casado(a)</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="Viuvo(a)" {{ old('estado_civil')=="Viuvo(a)" ? 'checked='.'"'.'checked'.'"' : '' }} name="estado_civil" type="radio"/>
                                <span>Viuvo(a)</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input value="Divorciado(a)" {{ old('estado_civil')=="Divorciado(a)" ? 'checked='.'"'.'checked'.'"' : '' }} name="estado_civil" type="radio"/>
                                <span>Divorciado(a)</span>
                            </label>
                        </p>
                    </div>
                </div>
                <br><br>
                <h5>Registro da anamnese:</h5>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">local_parking</i>
                        <label for="icon_prefix">Peso:</label>
                        <input name="peso" value="{{old('peso')}}" id="icon_prefix" type="number" step="0.01">
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">format_color_text</i>
                        <label for="icon_altura">Altura:</label>
                        <input name="altura" value="{{old('altura')}}" id="icon_altura" type="number" step="0.01">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input type="text" name="toma_medicacaovalidation" id="toma_medicacaovalidation" data-error=".errorTxt2" hidden>
                        Toma algum medicamento?  <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="toma_medicacao_click('S')" {{ old('toma_medicacao')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} value="1" name="toma_medicacao" type="radio"/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="toma_medicacao_click('N')"  {{ old('toma_medicacao')=="2" ? 'checked='.'"'.'checked'.'"' : '' }}  value="2" name="toma_medicacao" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                        <div class="errorTxt2" id="errorTxt2" style="margin-left: -13%;"></div>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="toma_medicacao_icon" class="material-icons prefix" hidden>description</i>
                        <label id="toma_medicacao_label" for="string_toma_medicacao" hidden>Qual medicamento?</label>
                        <input id="string_toma_medicacao" value="{{old('string_toma_medicacao')}}" name="string_toma_medicacao" type="text" hidden maxlength="50">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input type="text" name="alergia_medicacaovalidation" id="alergia_medicacaovalidation" data-error=".errorTxt3" hidden>
                        Possui alergia a algum medicamento? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="alergia_medicacao_click('S')" value="1"  {{ old('alergia_medicacao')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} name="alergia_medicacao" type="radio"/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="alergia_medicacao_click('N')" value="2"  {{ old('alergia_medicacao')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} name="alergia_medicacao" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                        <div class="errorTxt3" id="errorTxt3" style="margin-left: -13%;"></div>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="alergia_medicacao_icon" class="material-icons prefix" hidden>description</i>
                        <label id="alergia_medicacao_label" for="string_alergia_medicacao" hidden>Qual alergia médica?</label>
                        <input id="string_alergia_medicacao" value="{{old('string_alergia_medicacao')}}" name="string_alergia_medicacao" type="text" hidden maxlength="50">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input type="text" name="cirurgiavalidation" id="cirurgiavalidation" data-error=".errorTxt4" hidden>
                        O usuário já fez cirurgia? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="cirurgia_click('S')" {{ old('cirurgia')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} value="1" name="cirurgia" type="radio" />
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="cirurgia_click('N')" {{ old('cirurgia')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} value="2" name="cirurgia" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                        <div class="errorTxt4" id="errorTxt4" style="margin-left: -13%;"></div>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="cirurgia_icon" class="material-icons prefix" hidden>description</i>
                        <label id="cirurgia_label" for="string_cirurgia" hidden>Em que região foi a cirurgia?</label>
                        <input id="string_cirurgia" value="{{old('string_cirurgia')}}"  name="string_cirurgia" type="text" hidden maxlength="50">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input type="text" name="dor_osseavalidation" id="dor_osseavalidation" data-error=".errorTxt5" hidden>
                        Possui dores ósseas? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="dor_ossea_click('S')" value="1"  {{ old('cirurgia')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} name="dor_ossea" type="radio"/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="dor_ossea_click('N')" value="2"  {{ old('dor_ossea')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} name="dor_ossea" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                        <div class="errorTxt5" id="errorTxt5" style="margin-left: -13%;"></div>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="dor_ossea_icon" class="material-icons prefix" hidden>description</i>
                        <label id="dor_ossea_label" for="string_dor_ossea" hidden>Onde está a dor óssea?</label>
                        <input id="string_dor_ossea" value="{{old('string_dor_ossea')}}"  name="string_dor_ossea" type="text" hidden maxlength="50">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input type="text" name="dor_muscularvalidation" id="dor_muscularvalidation" data-error=".errorTxt6" hidden>
                        Possui dores musculares? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="dor_muscular_click('S')"  {{ old('dor_muscular')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} value="1" name="dor_muscular" type="radio"/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="dor_muscular_click('N')"  {{ old('dor_muscular')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} value="2" name="dor_muscular" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                        <div class="errorTxt6" id="errorTxt6" style="margin-left: -13%;"></div>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="dor_muscular_icon" class="material-icons prefix" hidden>description</i>
                        <input id="string_dor_muscular" value="{{old('string_dor_muscular')}}"  name="string_dor_muscular" type="text" hidden maxlength="50">
                        <label id="dor_muscular_label" for="string_dor_muscular" hidden>Onde está a dor muscular?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input type="text" name="dor_articularvalidation" id="dor_articularvalidation" data-error=".errorTxt7" hidden>
                        Possui dores articulares? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="dor_articular_click('S')" value="1" {{ old('dor_articular')=="1" ? 'checked='.'"'.'checked'.'"' : '' }}  name="dor_articular" type="radio"/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="dor_articular_click('N')" value="2" {{ old('dor_articular')=="2" ? 'checked='.'"'.'checked'.'"' : '' }}  name="dor_articular" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                        <div class="errorTxt7" id="errorTxt7" style="margin-left: -13%;"></div>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="dor_articular_icon" class="material-icons prefix" hidden>description</i>
                        <label id="dor_articular_label" for="string_dor_articular" hidden>Onde está a dor articular?</label>
                        <input id="string_dor_articular" value="{{old('string_dor_articular')}}" name="string_dor_articular" type="text" hidden maxlength="50">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input type="text" name="fumantevalidation" id="fumantevalidation" data-error=".errorTxt8" hidden>
                        O usuário fuma? <span style="color: red;">*</span>
                        <p>
                            <label>
                                <input onclick="fumante_click('S')" value="1" {{ old('fumante')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} name="fumante" type="radio"/>
                                <span>Sim</span>
                            </label>
                            &emsp;&emsp;
                            <label>
                                <input onclick="fumante_click('N')" value="2" {{ old('fumante')=="2" ? 'checked='.'"'.'checked'.'"' : '' }} name="fumante" type="radio"/>
                                <span>Não</span>
                            </label>
                        </p>
                        <div class="errorTxt8" id="errorTxt8" style="margin-left: -13%;"></div>
                    </div>
                    <div class="input-field col s12 m6">
                        <i id="fumante_icon" class="material-icons prefix" hidden>description</i>
                        <label id="fumante_label" for="string_fumante" hidden>Fuma há quanto tempo?</label>
                        <input id="string_fumante" value="{{old('string_fumante')}}" name="string_fumante" type="text" hidden maxlength="50">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        Possui doenças?
                        <select multiple name="doencas[]" id="lista_de_pessoas">
                            @foreach ($doencaslist as $doenca)
                        
                                <option value="{{$doenca->id}}">{{$doenca->nome}}
                                    @if (old("doencas")){{ (in_array($doenca->id, old("doencas")) ? "selected":"") }}@endif
                    
                                    
                                </option>
                            @endforeach
                        </select>
                        <input type="text" value="2" name="possui_doenca" hidden>
                    </div>
                    <div class="input-field col s12 m5">
                        <a href="#adicionardoenca" class="btn-floating modal-trigger light-blue darken-1"><i class="material-icons">note_add</i></a>
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
                                <input id="atestado" name="atestado" class="file-path" type="text" data-error=".errorTxt9">
                            </div>
                            <div class="input-field">
                                <div class="errorTxt9" id="errorTxt9"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <i class="material-icons prefix">description</i>
                        <label for="observacao">Observação</label>
                        <textarea name="observacao" id="observacao" class="materialize-textarea" maxlength="100">{{old('observacao')}}</textarea>
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
                            <label for="nome_doenca">Nome da doença: <span style="color: red;">*</span></label>
                            <input id="nome_doenca" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s10 m10">
                            <i class="material-icons prefix">description</i>
                            <label for="descricao_doenca">Observação: <span style="color: red;">*</span></label>
                            <textarea id="descricao_doenca" class="materialize-textarea" maxlength="100"></textarea>
                        </div>
                        <div class="input-field col s2 m2 right">
                            <a class="btn-floating btn-large" id="botao_doenca"><i class="material-icons">add</i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="fotomodal" class="modal">
        <div class="center">
            <br>
            <video id='video' class="grey lighten-1 center" style='border: solid 10px; black; width: 393px; height:300px;'></video>
            <div class='container'>
                <hr>
            </div>
            <br>
            <a id="capture" class="modal-close waves-effect waves-light btn-large modal-trigger blue" href="#!">Tirar foto&emsp;&nbsp; <i class="material-icons">contacts</i></a>
        </div>
        <br>
    </div>
    <script src="{{asset('js/validation/validation-pessoas/validation-pessoas-create.js')}}"></script>
@endsection