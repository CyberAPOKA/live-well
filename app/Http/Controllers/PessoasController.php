<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

//REQUEST PARA CONTROLE:
use App\Http\Requests\Pessoa\PessoaCreateFormRequest;
use App\Http\Requests\Pessoa\PessoaEditFormRequest;
use App\Http\Requests\Pessoa\PessoaProcurarFormRequest;

//MODELOS PARA CONTROLE:
use App\Pessoa;
use App\Professor;
use App\Nucleo;
use App\Doenca;
use App\Turma;
use App\Anamnese;
use App\HistoricoPT;
use App\Quant;
use Validator;
use JsValidator;
use PDF;

//CONTROLE DE PESSOAS:
//Comentarios em cima, código comentado em baixo.
class PessoasController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //FUNÇÃO DE FERRAMENTAS:
    //Ferramenta saveDbImage3x4: Salva a imagem 3 por 4 vindo das requisições do formulário.
    public function saveDbImage3x4($req, $op){
        $data = $req->all();
        date_default_timezone_set('America/sao_paulo');
        $num = date('Y_m_d_H.i.s');
        $dir = "img/img_3x4";
        $ex = '.png';
        if($op == 1){
            $imagem = $req->file('img_3x4');
            $ex = $imagem->guessClientExtension();
            $nomeImagem = "imagem_".$num.".".$ex;
            $imagem->move($dir, $nomeImagem);
            $data['img_3x4'] = $dir."/".$nomeImagem;

            return $data['img_3x4'];
        }
        else{
            $data['img_3x4'] = $dir.'/imagem_'.$num.$ex;
            Image::make($data['foto_web'])->save($data['img_3x4']);

            return $data['img_3x4'];
        }
    }

    //Ferramenta saveDbImageMatricula: Salva o pdf de matricula vindo das requisições do formulário.
    public function saveDbImageMatricula($req){
        $data = $req->all();
        date_default_timezone_set('America/sao_paulo');
        $num = date('Y_m_d_H.i.s');
        $dir = "img/img_matricula";
        $imagem = $req->file('img_matricula');
        $ex = $imagem->guessClientExtension();
        $nomeImagem = "pdf_".$num.".".$ex;
        $imagem->move($dir, $nomeImagem);
        $data['img_matricula'] = $dir."/".$nomeImagem;
        return $data['img_matricula'];
    }

    //Ferramenta saveDbImageMatricula: Salva o pdf de atestado vindo das requisições do formulário.
    public function saveDbImageAtestado($req){
        $data = $req->all();
        date_default_timezone_set('America/sao_paulo');
        $num = date('Y_m_d_H.i.s');
        $dir = "img/img_atestado";
        $imagem = $req->file('img_atestado');
        $ex = $imagem->guessClientExtension();
        $nomeImagem = "pdf_".$num.".".$ex;
        $imagem->move($dir, $nomeImagem);
        $data['img_atestado'] = $dir."/".$nomeImagem;
        return $data['img_atestado'];
    }

    //Ferramenta checar_estado: Verifica se todos os parametros necessarios para completar um perfil estão preenchidos.
    public function checar_estado($listadados, $nascimento){
        if($listadados['img_3x4'] == null && $listadados['foto_web'] == null){return 2;}
        if($listadados['bairro'] == null){return 2;}
        if($listadados['rua'] == null){return 2;}
        if($listadados['numero_endereco'] == null){return 2;}
        if($listadados['cep'] == null){return 2;}
        if($listadados['telefone'] == null){return 2;}
        if($listadados['telefone_emergencia'] == null){return 2;}
        if($listadados['convenio_medico'] == null){return 2;}
        if($listadados['pessoa_emergencia'] == null){return 2;}
        if($listadados['estado_civil'] == null){return 2;}
        if($listadados['mora_com_os_pais'] == null){return 2;}
        //Verifica de o usuário é menor de idade.
        if($nascimento < 18){
            //Se sim, matricula, cpf_responsavel e rg_responsavel serão contados.
            if($listadados['img_matricula'] == null){return 2;}
            if($listadados['cpf_responsavel'] == null){return 2;}
            if($listadados['rg_responsavel'] == null){return 2;}
        }
        else{
            //Se não, cpf e rg serão contados.
            if($listadados['cpf'] == null){return 2;}
            if($listadados['rg'] == null){return 2;}
        }
        return 1;
    }

    //Ferramenta mostrar_data: retornar a data (YYYY-mm-dd) convertida em idade e (dd/mm/YYYY).
    public function mostrar_data($data, $opcao){
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        list($ano, $mes, $dia) = explode('-', $data);

        //Caso 1: Converte de YYYY-mm-dd para idade.
        //Caso 2: Converte de idade para dd/mm/YYYY.
        if($opcao == 1){
            $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
            $data = (int)floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        }
        else{
            $data = $dia.'/'.$mes.'/'.$ano;
        }
        return $data;
    }
    
    //FUNÇÕES DE REDIRECIONAMENTO:
    //Função index: Retorna a página de registros de pessoas.
    public function index(){
        $ano = date('Y');

        //Encontra todos os registros de pessoas e ordena por nome.
        $pessoaslist = Pessoa::orderBy('nome')->get();
        foreach($pessoaslist as $pessoa){
            //Converter YYYY-mm-dd para idade.
           $pessoa['nascimento'] = $this->mostrar_data($pessoa['nascimento'], 1);
        }

        $turmaslist = Turma::orderBy('nome')->get();

        //Define variavel $count para informação de quantidade de registros.
        $count = Pessoa::all();
        Session::put('quant', count($count).' pessoas cadastradas.');

        return view ('pessoas_file.pessoas', compact('pessoaslist','ano', 'turmaslist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Função create: Retorna a página de criação de registros de pessoas.
    public function create(){
        //Encontra todos os registros de doenças.
        $doencaslist = Doenca::orderBy('nome')->get();
        
        //Criando array de bairros de São Leopoldo.
        $bairroslist = ['Arroio da Manteiga','Boa Vista','Campestre','Campina','Centro','Cristo Rei','Duque de Caxias',
                        'Fazenda Sao Borja','Feitoria','Fiao','Jardim America','Morro do Espelho','Padre Reus','Pinheiro',
                        'Rio Branco','Rio dos Sinos','Santa Tereza','Santo Andre','Santos Dumont','Sao Joao Batista',
                        'Sao Jose','Sao Miguel','Scharlau','Vicentina'];
                        
        return view ('pessoas_file.pessoas_create', compact('doencaslist','bairroslist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    //Função store: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de pessoas e turmas.
    public function store(PessoaCreateFormRequest $request){
        $dataForm = $request->all();

        $filhos = $request->input('filhos'); 
        if($filhos == null){
        $dataForm['filhos'] = 0;
        }
 
        $irmaos = $request->input('irmaos'); 
        if($irmaos == null){
        $dataForm['irmaos'] = 0;
        }

        //Adiciona a variavel nascimento a idade da pessoa.
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        list($dia, $mes, $ano) = explode('/', $dataForm['nascimento']);
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
        $nascimento = (int)floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        $errors = [];

        //Checar se a pessoa é maior de 18 anos.
        if($nascimento > 18){
            //Se sim, anular valores de matricula, cpf_responsavel e rg_responsavel.
            $dataForm['img_matricula'] = null;
            $dataForm['cpf_responsavel'] = null;
            $dataForm['rg_responsavel'] = null;
        }
        else{
            //Se sim, salvar imagem de matricula no banco de dados.
            if(isset($dataForm['img_matricula'])){$dataForm['img_matricula'] = $this->saveDbImageMatricula($request);}
            else{$dataForm['img_matricula'] = null;}
        }

        //Checar se convenio médico foi marcado
        if(isset($dataForm['convenio_medico'])){
            if($dataForm['convenio_medico'] == 2){$dataForm['string_convenio_medico'] = null;}
        }
        else{
            $dataForm['string_convenio_medico'] = -1;
        }
        
        //Se imagem foi passada, salva imagem 3 por 4 no banco de dados.
        if(isset($dataForm['img_3x4'])){$dataForm['img_3x4'] = $this->saveDbImage3x4($request, 1);}
        else{$dataForm['img_3x4'] = null;}
        
        if(isset($dataForm['foto_web'])){$dataForm['img_3x4'] = $this->saveDbImage3x4($request, 2);}

        //Verifica se foi informado bairro, se não, seta como nulo.
        if(!isset($dataForm['bairro'])){$dataForm['bairro'] = null;}

        //Verifica de o bairro como input (type=text) foi informado, se sim, substitui variavel bairro pela strin_bairro.
        if($dataForm['string_bairro'] != null){$dataForm['bairro'] = $dataForm['string_bairro'];}

        //Verifica se foi informado estado_civil, se não, seta como nulo.
        if(!isset($dataForm['estado_civil'])){$dataForm['estado_civil'] = null;}

        //Verifica se foi informado mora_com_os_pais, se não, seta como nulo.
        if(!isset($dataForm['mora_com_os_pais'])){$dataForm['mora_com_os_pais'] = null;}

        //Converte a data de nascimento dd/mm/YY para YY-mm-dd
        $nascimento = explode('/', $dataForm['nascimento']);
        $dataForm['nascimento'] = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];

        //Verifica se os todos os campos obrigatórios estão preenchidos:
        //se sim, seta estado como 1 (completo)
        //se não, seta estado como 2 (incompleto)
        $estado = $this->checar_estado($dataForm, $nascimento);

        //Cria pessoa no banco de dados com todos os atributos abaixo:
        $pessoa = Pessoa::create([
            'foto' => $dataForm['img_3x4'],
            'nome' => $dataForm['nome'],
            'nascimento' => $dataForm['nascimento'],
            'sexo' => $dataForm['sexo'],
            'rg' => $dataForm['rg'],
            'rg_responsavel' => $dataForm['rg_responsavel'],
            'cpf' => $dataForm['cpf'],
            'cpf_responsavel' => $dataForm['cpf_responsavel'],
            'cidade' => $dataForm['cidade'],
            'rua' => $dataForm['rua'],
            'bairro' => $dataForm['bairro'],
            'numero_endereco' => $dataForm['numero_endereco'],
            'complemento' => $dataForm['complemento'],
            'cep' => $dataForm['cep'],
            'telefone' => $dataForm['telefone'],
            'telefone_emergencia' => $dataForm['telefone_emergencia'],
            'estado_civil' => $dataForm['estado_civil'],
            'nome_do_pai' => $dataForm['nome_do_pai'],
            'nome_da_mae' => $dataForm['nome_da_mae'],
            'pessoa_emergencia' => $dataForm['pessoa_emergencia'],
            'filhos' => $dataForm['filhos'],
            'convenio_medico' => $dataForm['string_convenio_medico'],
            'irmaos' => $dataForm['irmaos'],
            'mora_com_os_pais' => $dataForm['mora_com_os_pais'],
            'matricula' => $dataForm['img_matricula'],
            'estado' => $estado,
            'morte' => null,
        ]);

        //Verifica atributos de anamnese,
        //Se foi selecionado sim, adiciona ao campo de input (type=text).
        //Se foi selecionado não, adiciona -1 para o banco de dados.
        if(!empty($dataForm['doencas'])){$dataForm['possui_doenca'] = 1;}
        if($dataForm['toma_medicacao'] == 2){$dataForm['string_toma_medicacao'] = -1;}
        if($dataForm['alergia_medicacao'] == 2){$dataForm['string_alergia_medicacao'] = -1;}
        if($dataForm['cirurgia'] == 2){$dataForm['string_cirurgia'] = -1;}
        if($dataForm['dor_ossea'] == 2){$dataForm['string_dor_ossea'] = -1;}
        if($dataForm['dor_muscular'] == 2){$dataForm['string_dor_muscular'] = -1;}
        if($dataForm['dor_articular'] == 2){$dataForm['string_dor_articular'] = -1;}
        if($dataForm['fumante'] == 2){$dataForm['string_fumante'] = -1;}

        //Se imagem foi passada, salva imagem atestado no banco de dados.
        if(isset($dataForm['img_atestado'])){$dataForm['img_atestado'] = $this->saveDbImageAtestado($request);}
        else{$dataForm['img_atestado'] = null;}

        //Cria anamnese no banco de dados com todos os atributos abaixo:
        $anamnese = Anamnese::create([
            'ano' => date('Y'),
            'possui_doenca' => $dataForm['possui_doenca'],
            'toma_medicacao' => $dataForm['string_toma_medicacao'],
            'alergia_medicacao' => $dataForm['string_alergia_medicacao'],
            'peso' => $dataForm['peso'],
            'altura' => $dataForm['altura'],
            'fumante' => $dataForm['string_fumante'],
            'cirurgia' => $dataForm['string_cirurgia'],
            'dor_muscular' => $dataForm['string_dor_muscular'],
            'dor_articular' => $dataForm['string_dor_articular'],
            'dor_ossea' => $dataForm['string_dor_ossea'],
            'atestado' => $dataForm['img_atestado'],
            'observacao' => $dataForm['observacao'],
            'pessoas_id' => $pessoa->id,
        ]);
        
        //Vincula doenças na anamnese se elas foram informadas no formulário.
        if(isset($dataForm['doencas'])){$anamnese->doencas()->attach($dataForm['doencas']);}

        //Define sessões de informação para apresentação na página.
        Session::put('pessoa', $pessoa->id);
        Session::put('mensagem_green', $pessoa->nome.' criado(a) com sucesso!');
        
        return redirect()->Route('pessoas_turmas', $pessoa->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função edit: Retorna a página de edição de registros de pessoas.
    public function edit($id){
        //Encontra a pessoa no banco de dados.
        $pessoa = Pessoa::find($id);

        //Converter YYYY-mm-dd para dd/mm/YYYY.
        $pessoa['nascimento'] = $this->mostrar_data($pessoa['nascimento'], 2);
        if($pessoa['morte'] != null){
            $pessoa['morte'] = $this->mostrar_data($pessoa['morte'], 2);
        }

        //Encontra todos os registros de doenças.
        $doencaslist = Doenca::orderBy('nome')->get();

        //Criando array de bairros de São Leopoldo.
        $bairroslist = ['Arroio da Manteiga','Boa Vista','Campestre','Campina','Centro','Cristo Rei','Duque de Caxias',
                        'Fazenda Sao Borja','Feitoria','Fiao','Jardim America','Morro do Espelho','Padre Reus','Pinheiro',
                        'Rio Branco','Rio dos Sinos','Santa Tereza','Santo Andre','Santos Dumont','Sao Joao Batista',
                        'Sao Jose','Sao Miguel','Scharlau','Vicentina'];
        
        return view ('pessoas_file.pessoas_edit', compact('doencaslist','bairroslist','pessoa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função update: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de index.
    public function update(PessoaEditFormRequest $request, $id){

        $dataForm = $request->all();

        //Encontra a pessoa no banco de dados.
        $pessoa = Pessoa::find($id);

        //Verifica se a imagem 3 por 4 por arquivo foi passada pelo formulário.
        if(isset($dataForm['img_3x4'])){
            //Se sim, remove imagem antiga e salva imagem nova no banco de dados.
            if(!empty($pessoa['foto'])){unlink($pessoa['foto']);}
            $dataForm['img_3x4'] = $this->saveDbImage3x4($request, 1);
        }
        elseif(isset($dataForm['3x4'])){
            //Se a imagem não foi passada, porém permanece com o link antigo, apenas repete o valor que está no banco de dados para criação
            $dataForm += ['img_3x4' => $pessoa['foto']];
        }
        else{
            //Se não, atribuir nulo e deleta a imagem.
            $dataForm += ['img_3x4' => null];
        }

        //Verifica se a imagem 3 por 4 por webcam foi passada pelo formulário.
        if(isset($dataForm['foto_web'])){
            //Se sim, remove imagem antiga e salva imagem nova no banco de dados.
            if(!empty($pessoa['foto'])){unlink($pessoa['foto']);}
            $dataForm['foto_web'] = $this->saveDbImage3x4($request, 2);
        }
        

        //Adiciona a variavel nascimento a idade da pessoa.
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        list($dia, $mes, $ano) = explode('/', $dataForm['nascimento']);
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
        $nascimento = (int)floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        //Checar se a pessoa é maior de 18 anos.
        if($nascimento > 18){
            //Se sim, anular valores de matricula, cpf_responsavel e rg_responsavel.
            $dataForm['img_matricula'] = null;
            $dataForm['cpf_responsavel'] = null;
            $dataForm['rg_responsavel'] = null;
        }
        else{
            //Verifica se a imagem de matricula foi passada pelo formulário.
            if(isset($dataForm['matricula'])){
                if($pessoa['matricula'] == $dataForm['matricula']){
                    //Se o pdf não foi passada, porém permanece com o link antigo, apenas repete o valor que está no banco de dados para criação
                    $dataForm += ['img_matricula' => $pessoa['matricula']];
                }
                else{
                    //Se sim, remove imagem antiga e salva o pdf novo no banco de dados.
                    if(!empty($pessoa['matricula'])){unlink($pessoa['matricula']);}
                    $dataForm['img_matricula'] = $this->saveDbImageMatricula($request);
                }
            }
            else{
                //Atribui o valor 'img_matricula' para null.
                $dataForm += ['img_matricula' => null];

                //Verifica de a pessoa não possui uma matricula registrada.
                if($pessoa['matricula'] != null){
                    //Se não, atribuir nulo e deleta o pdf.
                    unlink($pessoa['matricula']);
                }
            }
        }
        //checar se convenio médico foi marcado.
        if($dataForm['convenio_medico'] == 2){$dataForm['string_convenio_medico'] = -1;}

        //checar se falecimento da pessoa foi marcada.
        if($dataForm['morte'] == 2){
            $dataForm['string_morte'] = null;
        }
        else{
            if($dataForm['string_morte'] != ''){
                //Converte a data de falecimento dd/mm/YY para YY-mm-dd
                $falecimento = explode('/', $dataForm['string_morte']);
                $dataForm['string_morte'] = $falecimento[2].'-'.$falecimento[1].'-'.$falecimento[0];
            }
        }

        //Verifica se foi informado bairro, se não, seta como nulo.
        if(!isset($dataForm['bairro'])){$dataForm['bairro'] = null;}

        //Verifica de o bairro como input (type=text) foi informado, se sim, substitui variavel bairro pela strin_bairro.
        if($dataForm['string_bairro'] != null){$dataForm['bairro'] = $dataForm['string_bairro'];}

        //Verifica se foi informado estado_civil, se não, seta como nulo.
        if(!isset($dataForm['estado_civil'])){$dataForm['estado_civil'] = null;}
 
        //Verifica se foi informado mora_com_os_pais, se não, seta como nulo.
        if(!isset($dataForm['mora_com_os_pais'])){$dataForm['mora_com_os_pais'] = null;}

        //Converte a data de nascimento dd/mm/YY para YY-mm-dd
        $nascimento = explode('/', $dataForm['nascimento']);
        $dataForm['nascimento'] = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];

        //Verifica se os todos os campos obrigatórios estão preenchidos:
        //se sim, seta estado como 1 (completo)
        //se não, seta estado como 2 (incompleto)
        $estado = $this->checar_estado($dataForm, $nascimento);

        //Edita pessoa no banco de dados com todos os atributos abaixo:
        $pessoa->update([
            'foto' => $dataForm['img_3x4'],
            'nome' => $dataForm['nome'],
            'nascimento' => $dataForm['nascimento'],
            'sexo' => $dataForm['sexo'],
            'rg' => $dataForm['rg'],
            'rg_responsavel' => $dataForm['rg_responsavel'],
            'cpf' => $dataForm['cpf'],
            'cpf_responsavel' => $dataForm['cpf_responsavel'],
            'cidade' => $dataForm['cidade'],
            'rua' => $dataForm['rua'],
            'bairro' => $dataForm['bairro'],
            'numero_endereco' => $dataForm['numero_endereco'],
            'complemento' => $dataForm['complemento'],
            'cep' => $dataForm['cep'],
            'telefone' => $dataForm['telefone'],
            'telefone_emergencia' => $dataForm['telefone_emergencia'],
            'estado_civil' => $dataForm['estado_civil'],
            'nome_do_pai' => $dataForm['nome_do_pai'],
            'nome_da_mae' => $dataForm['nome_da_mae'],
            'pessoa_emergencia' => $dataForm['pessoa_emergencia'],
            'filhos' => $dataForm['filhos'],
            'convenio_medico' => $dataForm['string_convenio_medico'],
            'irmaos' => $dataForm['irmaos'],
            'mora_com_os_pais' => $dataForm['mora_com_os_pais'],
            'matricula' => $dataForm['img_matricula'],
            'estado' => $estado,
            'morte' => $dataForm['string_morte'],
        ]);

        return redirect()->Route('pessoas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função destroy: Deletar a pessoa.
    public function destroy(Request $request, $id){
        //Função de deletar não ultilizada para pessoas.
    }

    //Função pessoas_info: Seleciona informações necessarias para vizualização e retorna a página de informações da pessoa.
    public function pessoas_info($id){
        $ano = date('Y');
        
        //Encontra a pessoa no banco de dados.
        $pessoa = Pessoa::find($id);

        //Atribui idade da pessoa a variavel $idade utilizando função de conversão.
        $idade = $this->mostrar_data($pessoa->nascimento, 1);

        //Encontra a ultima anamnese da pessoa no banco de dados.
        $anamnese = $pessoa->anamneses->last();

        //Converter YYYY-mm-dd para dd/mm/YYYY.
        $pessoa['nascimento'] = $this->mostrar_data($pessoa['nascimento'], 2);
        if($pessoa['morte'] != null){
            $pessoa['morte'] = $this->mostrar_data($pessoa['morte'], 2);
        }

        //Seleciona todo o histórico da pessoa encontrada.
        $histpessoa = HistoricoPT::orderBy('created_at', 'desc')->where('pessoa_id', '=', $pessoa->id)->get();

        //Contagem de turmas:
        //A = Todas as turmas (Atribuir ao A).
        //B = Todas as turmas ativas (Se o pivot inativo é 1, contar para B).
        //C = Todas as turmas inativas (Subtrai A pelo B e adiciona o número ao C).
        //Adiciona id de núcleos ao array de idsnucleos e depois excluir números repetidos.
        $a = 0; $b = 0; $idsnucleos = [];
        foreach($pessoa->turmas as $turma){
            if($turma->pivot->inativo == 1)
                array_push($idsnucleos, $turma->nucleo_id);{
                $b++;
            }
            $a++;
        }
        $c = $a - $b;
        $dadosgerais = [$a,$b,$c];
        $idsturmas = array_unique($idsnucleos);

        //Encontra todos os núcleos que estão no array de idsnucleos.
        $listnucleopessoa = Nucleo::whereIn('id', $idsnucleos)->get();
        
        //Encontra todas as anamneses da pessoa para vizualização.
        $anamneses = Anamnese::where('pessoas_id', '=', $id)->orderBy('ano', 'desc')->get();

        return view ('pessoas_file.pessoas_info', compact('pessoa', 'anamnese','histpessoa','dadosgerais','listnucleopessoa','anamneses','ano','idade'));
    }

    //Função pessoas_turmas: Seleciona informações necessarias para vizualização e retorna a página de turmas e pessoas.
    public function pessoas_turmas($id){
        //Encontra todos os núcleos registrados.
        $nucleoslist = Nucleo::orderBy('nome')->get();

        //Criando array de dias da semana.
        $dias_semana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'];

        //Encontra a pessoa no banco de dados.
        $pessoa = Pessoa::find($id);

        //Encontra todas as turmas registradas.
        $turmaslist = Turma::orderBy('inativo')->orderBy('nome')->get();

        //Atribui count para definir sessão de informação.
        $count = Turma::all();
        Session::put('quant', count($count).' turmas cadastradas.');

        return view ('pessoas_file.pessoas_turmas', compact('pessoa', 'turmaslist', 'dias_semana', 'nucleoslist'));
    }

    //Função pessoas_turmas_vincular: Vincula uma pessoa em uma turma e retorna a página de pessoas e turmas.
    public function pessoas_turmas_vincular(Request $request){
        //Encontra pessoa no banco de dados.
        $dataForm = $request->all();
        $pessoa = Pessoa::find($dataForm['pessoa_id']);

        //Checa se a quantidade de turmas que a pessoa possui ativadas é igual ou mais a quantidade limite registrada.
        //Calcula quantas turmas a pessoa possui ativa
        $limite = Quant::find(1);
        $quant = 0;
        foreach($pessoa->turmas as $turma){if($turma->pivot->inativo == 1){$quant++;}}
        
        //Se a pessoa possui um numero igual ou maior de turma do que a quantidade limite registrada, retorna a página de pessoas e turmas
        if($quant >= $limite->quantidade){
            //Define uma sessão para informar que a pessoa não foi vinculada pelo fato de estar no limite ou além da quantidade de turmas
            Session::put('mensagem_red', $pessoa->nome . " não pode ser vinculada a turma, limite de turmas atingido");

            return redirect()->Route('pessoas_turmas', $pessoa->id);
        }

        //Encontra turma do banco de dados.
        $turma = Turma::find($dataForm['turma_id']);

        //Adiciona o campo 'operario' para informações.
        $dataForm += ['operario' => auth()->user()->name];

        //Soma +1 no campo de quantidade atual de pessoas na turma.
        DB::update(DB::raw('update turmas set quant_atual = :quant where id = :turma'), ['quant'=>$turma->quant_atual+1, 'turma'=>$dataForm['turma_id']]);

        //Vincula a pessoa a turma.
        $pessoa->turmas()->attach($turma->id, ['inativo'=>$dataForm['inativo']]);

        //Adiciona registro de alteração no histórico de pessoas e turmas.
        HistoricoPT::create($dataForm);

        //Define a sessão a ser apresentada:
        //Se a quantidade atual da turma for maior que o limite possivel dela, devolve sessão amarela, caso contrario, devolve sessão verde
        if($turma->quant_atual+1 > $turma->limite){
            Session::put('mensagem_yellow', "A turma " . $turma->nome . " está além de seu limite máximo!");
        }
        else{
            Session::put('mensagem_green', $pessoa->nome . " foi vinculado a turma" . $turma->nome ." com sucesso!");
        }

        return redirect()->Route('pessoas_turmas', $pessoa->id);
    }

    //Função pessoas_turmas_ativar_inativar: Ativa ou inativa uma pessoa em uma turma e retorna a página de pessoas e turmas.
    public function pessoas_turmas_ativar_inativar(Request $request){
        $dataForm = $request->all();
        //Encontra a turma no banco de dados.
        $turma = Turma::find($dataForm['turma_id']);

        //Calcula quantas turmas a pessoa possui ativa
        $limite = Quant::find(1);
        
        //Encontra a pessoa percorrendo todas as pessoas da turma para saber qual sua inatividade na turma
        $aux = -1;
        for($i = 0; $i < count($turma->pessoas); $i++){
            if($turma->pessoas[$i]->id == $dataForm['pessoa_id']){$aux = $i;}
        }


        //Define variaveis construtivas:
        //STRING = Query para mandar para o banco de dados.
        //TEXTO = Texto para mandar para sessão de informação.
        //CONTA = Para checagem final para envio de sessão.
        $string = ''; $texto = ''; $conta = 0;

        //Checa se a inatividade da pessoa é ativa ou inativa:
        if($turma->pessoas[$aux]->pivot->inativo == 1){
            //Se sim:
            //1 - Diminui 1 na quantidade atual de pessoas na turma.
            //2 - Seta 2 no campo de inativo na tabela de turma_pessoa, aonde tem o id da pessoa e da turma.
            //3 - Adiciona linhas no texto.
            DB::update(DB::raw('update turmas set quant_atual = :quant where id = :turma'), ['quant'=>$turma->quant_atual-1, 'turma'=>$turma->id]);
            $string = 'update turmas_pessoas set inativo = 2 where pessoa_id = :sujeito and turma_id = :turma';
            $texto = ' foi removido a turma ';
            $conta = $turma->quant_autal-1;

            //Adiciona registro da alteração no histórico de pessoas e turmas.
            HistoricoPT::create([
                'pessoa_id' => $dataForm['pessoa_id'],
                'turma_id' => $dataForm['turma_id'],
                'comentario' => $dataForm['comentario'],
                'operario' => auth()->user()->name,
                'inativo' => 2,
                
            ]);
        }
        else{
            //Se não:

            //Encontra a pessoa no banco de dados.
            $pessoa = Pessoa::find($dataForm['pessoa_id']);

            //Calcula quantas pessoas ativar existem na turma e atribui a variavel quant.
            $quant = 0;
            foreach($pessoa->turmas as $turma){
                if($turma->pivot->inativo == 1){$quant++;}
            }

            //Se a variavel quant é maior que o limite da quantidade, cria-se uma sessão alerta e retorna para página de pessoas e turmas
            if($quant >= $limite->quantidade){
                Session::put('mensagem_red', $pessoa->nome . " não pode ser vinculada a turma, limite de turmas atingido");
            
                return redirect()->Route('pessoas_turmas', $pessoa->id);
            }
            
            //Se o código continuar:
            //1 - Aumenta 1 na quantidade atual de pessoas na turma
            //2 - Seta 1 no campo de inativo na tabela de turma_pessoa, aonde tem o id da pessoa e da turma.
            //3 - Adiciona linhas no texto. 
            DB::update(DB::raw('update turmas set quant_atual = :quant where id = :turma'), ['quant'=>$turma->quant_atual+1, 'turma'=>$turma->id]);
            $string = 'update turmas_pessoas set inativo = 1 where pessoa_id = :sujeito and turma_id = :turma';
            $texto = ' foi adicionado a turma ';
            $conta = $turma->quant_autal+1;

            //Adiciona registro da alteração histórico.
            HistoricoPT::create([
                'pessoa_id' => $dataForm['pessoa_id'],
                'turma_id' => $dataForm['turma_id'],
                'comentario' => $dataForm['comentario'],
                'operario' => auth()->user()->name,
                'inativo' => 1,
            ]);
        }

        //Executa o a variavel string no banco de dados que construida nos passos anteriores.
        DB::update(DB::raw($string), ['sujeito'=>$dataForm['pessoa_id'], 'turma'=>$dataForm['turma_id']]);

        //Encontra a pessoa no banco de dados.
        $pessoa = Pessoa::find($dataForm['pessoa_id']);

        //Verifica se a variavel conta é maior que o limite de pessoas que podem estar na turma:
        //Se sim, cria-se uma sessão amarela para alertar o usuário.
        //Se não, cria-se uma sessão verde para alertar o usuário. 
        if($conta > $turma->limite){Session::put('mensagem_yellow', "A turma " . $turma->nome . " está além de seu limite máximo!");}
        else{Session::put('mensagem_green', $pessoa->nome . $texto . $turma->nome ." com sucesso!");}

        return redirect()->Route('pessoas_turmas', $pessoa->id);
    }
}