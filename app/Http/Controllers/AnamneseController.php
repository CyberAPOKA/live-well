<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;


//REQUEST PARA CONTROLE:
use App\Http\Requests\Anamnese\AnamneseCreateEditFormRequest;
use App\Http\Requests\Anamnese\AnamneseProcurarFormRequest;

//MODELOS PARA CONTROLE:
use App\Anamnese;
use App\Pessoa;
use App\Doenca;
use App\Professor;
use Validator;
use JsValidator;
use PDF;

//CONTROLE DE ANAMNESES:
//Comentarios em cima, código comentado em baixo.
class AnamneseController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //FUNÇÃO DE FERRAMENTAS:
    //Ferramenta saveDbImageAtestado: Salva a imagem de atestado vindo das requisições do formulário.
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
    
    //FUNÇÕES DE REDIRECIONAMENTO:
    //Função index: Retorna a página de registros de anamneses.


    public function index(){
        $ano = date('Y');

        //Encontra todos os registros de pessoas e ordena por ano decrescente.
        $anamneseslist = Anamnese::orderBy('ano','desc')->get();

        //Encontra todos os registros de doenças.
        $doencaslist = Doenca::all();

        //Define variavel $count para informação de quantidade de registros.
        $count = Anamnese::all();
        Session::put('quant', count($count).' anamneses cadastradas.');

        return view ('anamneses_file.anamneses', compact('anamneseslist','ano','doencaslist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Função create: Não utilizada devido ao fato de não poder receber parametros.
    public function create(){
        //Função de create não ultilizada para anamneses.
    }

    //Função anamnese_create: Função substituta da função create, retorna a página de criação de registros de anamneses.
    public function anamnese_create($id){

        //Encontra a pessoa no banco de dados.
        $pessoa = Pessoa::find($id);

        //Encontra todos os registros de doenças.
        $doencaslist = Doenca::all();

        //Encontra a ultima anamnese da pessoa no banco de dados.
        $ultimaanamnese = Anamnese::where('pessoas_id', '=', $id)->get()->last();

        //Calcula nascimento de dd:mm:YYYY 00:00:00 para idade.
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        list($ano, $mes, $dia) = explode('-', $pessoa['nascimento']);
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
        $pessoa['nascimento'] = (int)floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        
        return view ('anamneses_file.anamneses_create', compact('pessoa','doencaslist','ultimaanamnese'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Função store: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de registro de pessoas.
    public function store(AnamneseCreateEditFormRequest $request){
    
    
        $dataForm = $request->all();

        //Adiciona a variavel de ano para a criação.
        $dataForm += ['ano' => date('Y')];

        //error_log("string_medicacao:" . $dataForm['toma_medicacao']);
    
        //Verifica atributos de anamnese, 
        //se foi selecionado sim, adiciona ao campo de input (type=text).
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


        error_log("string_medicacao:" . $dataForm['string_toma_medicacao']);

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
            'pessoas_id' => $dataForm['pessoas_id'],
        ]);

        //Vincula doenças na anamnese se elas foram informadas no formulário.
        if(isset($dataForm['doencas'])){$anamnese->doencas()->attach($dataForm['doencas']);}

        //Define sessões de informação para apresentação na página.
        Session::put('mensagem_green','Anamnese adicionada com sucesso!');

        return redirect()->route('pessoas.index');
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

    //Função edit: Retorna a página de edição de registros de anamneses.
    public function edit($id){
        //Encontra a anamnese no banco de dados.
        $anamnese = Anamnese::find($id);

        //Encontra todos os registros de doenças. 
        $doencaslist = Doenca::all();

        //Calcula nascimento de dd:mm:YYYY 00:00:00 para idade.
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        list($ano, $mes, $dia) = explode('-', $anamnese->pessoas['nascimento']);
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
        $anamnese->pessoas['nascimento'] = (int)floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        return view ('anamneses_file.anamneses_edit', compact ('anamnese','doencaslist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função update: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de registro de anamneses.
    public function update(AnamneseCreateEditFormRequest $request, $id){
      
        $dataForm = $request->all();

        //Encontra a anamnese no banco de dados.
        $anamnese = Anamnese::find($id);

        //Busca os valores antigos da anamnese.
        $oldanamnese = (array)$anamnese;

        //Verifica atributos de anamnese, 
        //se foi selecionado sim, adiciona ao campo de input (type=text).
        //Se foi selecionado não, adiciona -1 para o banco de dados.
        if(!empty($dataForm['doencas'])){$dataForm['possui_doenca'] = 1;}
        if($dataForm['toma_medicacao'] == 2){$dataForm['string_toma_medicacao'] = -1;}
        if($dataForm['alergia_medicacao'] == 2){$dataForm['string_alergia_medicacao'] = -1;}
        if($dataForm['cirurgia'] == 2){$dataForm['string_cirurgia'] = -1;}
        if($dataForm['dor_ossea'] == 2){$dataForm['string_dor_ossea'] = -1;}
        if($dataForm['dor_muscular'] == 2){$dataForm['string_dor_muscular'] = -1;}
        if($dataForm['dor_articular'] == 2){$dataForm['string_dor_articular'] = -1;}
        if($dataForm['fumante'] == 2){$dataForm['string_fumante'] = -1;}

        //Verifica se a imagem de atestado foi passada pelo formulário.
        if(isset($dataForm['img_atestado'])){
            //Se sim, remove imagem antiga e salva imagem nova no banco de dados.
            if(!empty($anamnese['atestado'])){unlink($anamnese['atestado']);}
            $dataForm['img_atestado'] = $this->saveDbImageAtestado($request);
        }
        elseif(isset($anamnese['atestado'])){
            //Se a imagem não foi passada, porém permanece com o link antigo, apenas repeto o valor que está no banco de dados para criação
            $dataForm += ['img_atestado' => $anamnese['atestado']];
        }
        else{
            //Se não, atribuir nulo e deleta a imagem.
            unlink($anamnese['atestado']);
            $dataForm += ['img_atestado' => null];
        }

        //Edita anamnese no banco de dados com todos os atributos abaixo:
        $anamnese->update([
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
            'ano' => date('Y'),
            'pessoas_id' => $dataForm['pessoa_id'],
        ]);

        //Edita a vinculação doenças na anamnese se elas foram informadas no formulário.
        if(isset($dataForm['doencas'])){$anamnese->doencas()->sync($dataForm['doencas']);}

        //busca os valores novos da turma.
        $newanamnese = (array)$anamnese;

        //Verifica se os valores velhos são iguais aos valores novos da turma.
        if($newanamnese != $oldanamnese){
            //Se os valores da anamnese são diferentes, define uma sessão verde de informação.
            Session::put('mensagem_green', "Anamnese editada com sucesso!");
        } 

        return redirect()->route('anamneses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    //Função destroy: Deletar a anamnese.
    public function destroy($id){
        //Função de deletar não ultilizada para anamneses.
    }

    //Função anamnese_info: Deleciona informações necessarias para vizualização e retorna a página de informações da anamnese.
    public function anamnese_info($id){
        $ano = date('Y');

        //Encontra a anamnese no banco de dados.
        $anamnese = Anamnese::find($id);

        //Encontra a pessoa da anamnese no banco de dados.
        $pessoa = Pessoa::find($anamnese->pessoas);

        //Se o usuário for professor, adicionar a variavel professor procurando o professor com o id do usuário e retornando para informações de anamneses
        if(auth()->user()->can('autorizacao', 3)){
            //Enconta o professor no banco de dados.
            $professor = Professor::where('user_id', '=', auth()->user()->id)->first();

            return view ('anamneses_file.anamneses_info', compact('anamnese','pessoa','ano','professor'));
        }

        return view ('anamneses_file.anamneses_info', compact('anamnese','pessoa','ano'));
    }
}
