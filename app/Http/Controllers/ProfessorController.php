<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

//REQUEST PARA CONTROLE:
use App\Http\Requests\Professor\ProfessorCreateFormRequest;
use App\Http\Requests\Professor\ProfessorEditFormRequest;
use App\Http\Requests\Professor\ProfessorProcurarFormRequest;
use App\Http\Requests\Professor\AlunoProcurarFormRequest;
use App\Http\Requests\Turma\TurmaProcurarFormRequest;

//MODELOS PARA CONTROLE:
use App\User;
use App\Professor;
use App\Turma;
use App\Nucleo;
use App\Pessoa;
use App\HistoricoPrT;

//CONTROLE DE PROFESSORES:
//Comentarios em cima, código comentado em baixo.
class ProfessorController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //FUNÇÃO DE FERRAMENTAS:
    //Ferramenta mostrar_nascimento: Retornar a data de nascimento (YYYY-mm-dd) convertida em (dd/mm/YYYY).
    public function mostrar_nascimento($data){
        $dia_hora = explode(' ', $data);
        list($ano, $mes, $dia) = explode('-', $dia_hora[0]);
        $data = $dia.'/'.$mes.'/'.$ano;

        return $data;
    }

    //FUNÇÕES DE REDIRECIONAMENTO:
    //Função index: Retorna a página de registros de professores.
    public function index(){
        //Encontra todos os registros de professores e ordena por nome.
        $professoreslist = Professor::orderBy('nome')->get();

        //Encontra todos os registros de turmas.
        $turmaslist = Turma::all();

        //Define variavel a informação de quantidade de registros.
        Session::put('quant', count($professoreslist).' professores cadastrados.');

        return view ('professores_file.professores', compact('professoreslist', 'turmaslist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Função create: Retorna a página de criação de registros de professores.
    public function create(){
        //Criando array de bairros de São Leopoldo.
        $bairroslist = ['Arroio da Manteiga','Boa Vista','Campestre','Campina','Centro','Cristo Rei','Duque de Caxias',
                        'Fazenda Sao Borja','Feitoria','Fiao','Jardim America','Morro do Espelho','Padre Reus','Pinheiro',
                        'Rio Branco','Rio dos Sinos','Santa Tereza','Santo Andre','Santos Dumont','Sao Joao Batista',
                        'Sao Jose','Sao Miguel','Scharlau','Vicentina'];

        return view ('professores_file.professores_create', compact('bairroslist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Função store: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de registro de professores.
    public function store(ProfessorCreateFormRequest $request){
        $dataForm = $request->all();
        
        //Cria usuário no banco de dados com todos os atributos abaixo:
        $user = User::create([
            'nick' => $dataForm['nome'],
            'name' => $dataForm['name'],
            'email' => strtolower($dataForm['email']),
            'password' => bcrypt($dataForm['password']),
            'permissao' => 4,
        ]);

        //Converte a data de nascimento dd/mm/YY para YY-mm-dd 00:00:00
        $nascimento = explode('/', $dataForm['nascimento']);
        $dataForm['nascimento'] = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];

        //Verifica de o bairro como input (type=text) foi informado, se sim, substitui variavel bairro pela strin_bairro.
        if($dataForm['string_bairro'] != null){$dataForm['bairro'] = $dataForm['string_bairro'];}

        //Adiciona variavel de id do usuário para a criação de professor.
        $dataForm += ['user_id' => $user->id];

        //Criar o professor
        Professor::create($dataForm);
        
        //Adiciona uma sessão de alerta verde.
        Session::put('mensagem_green', $dataForm['nome'].' adicionado(a) com sucesso!');

        return redirect()->Route('professor.index');
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

    //Função edit: Retorna a página de edição de registros de professores.
    public function edit($id){
        //Encontra o professor no banco de dados.
        $professor = Professor::find($id);

        //Encontra o usuário no banco de dados
        $user = User::find($professor->user_id);

        //Converter YYYY-mm-dd para dd/mm/YYYY.
        $professor['nascimento'] = $this->mostrar_nascimento($professor['nascimento']);

        //Criando array de bairros de São Leopoldo.
        $bairroslist = ['Arroio da Manteiga','Boa Vista','Campestre','Campina','Centro','Cristo Rei','Duque de Caxias',
                        'Fazenda Sao Borja','Feitoria','Fiao','Jardim America','Morro do Espelho','Padre Reus','Pinheiro',
                        'Rio Branco','Rio dos Sinos','Santa Tereza','Santo Andre','Santos Dumont','Sao Joao Batista',
                        'Sao Jose','Sao Miguel','Scharlau','Vicentina'];

        return view ('professores_file.professores_edit', compact('professor', 'user','bairroslist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função update: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de index.
    public function update(ProfessorEditFormRequest $request, $id){
        $dataForm = $request->all();

        //Encontra o professor no banco de dados.
        $professor = Professor::find($id);

         //Encontra o usuário no banco de dados
        $user = User::find($professor->user_id);

        //Converte a data de nascimento dd/mm/YY para YY-mm-dd 00:00:00
        $nascimento = explode('/', $dataForm['nascimento']);
        $dataForm['nascimento'] = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];

        //Verifica de o bairro como input (type=text) foi informado, se sim, substitui variavel bairro pela strin_bairro.
        if($dataForm['string_bairro'] != null){$dataForm['bairro'] = $dataForm['string_bairro'];}

        //Busca os valores antigos do usuário, edita e depois busca os valores novos do usuário.
        $olduser = (array)$user;
        $user->update($dataForm);
        $newuser = (array)$user;

        //Busca os valores antigos do professor, edita e depois busca os valores novos do professor.
        $oldprofessor = (array)$professor;
        $professor->update($dataForm);
        $newprofessor = (array)$professor;

        //Verifica se os valores velhos são iguais aos valores novos de professor.
        if($newprofessor != $oldprofessor){
            //Se os valores de professor são diferentes, define uma sessão verde de informação.
            Session::put('mensagem_green', $professor->nome.' editado(a) com sucesso!');
        }
        elseif($newuser != $olduser){
            //Se os valores de usuario são diferentes, define uma sessão verde de informação.
            Session::put('mensagem_green', $professor->nome.' editado(a) com sucesso!');
        }
        
        return redirect()->Route('professor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função destroy: Deletar o professor.
    public function destroy(Request $request, $id){
        //Função de deletar não ultilizada para professores.
    }

    //Função professor_info: Seleciona informações necessarias para vizualização e retorna a página de informações do professor.
    public function professor_info($id){
        //Encontra o professor no banco de dados.
        $professor = Professor::find($id);

        //Encontra o usuário no banco de dados e atribui a variavel email o email do usuário.
        $user = User::find($professor['user_id']);

        //Converter YYYY-mm-dd para dd/mm/YYYY.
        $professor['nascimento'] = $this->mostrar_nascimento($professor['nascimento'], 2);

        //Seleciona todo o histórico do professor encontrado.
        $histprofessor = HistoricoPrT::orderBy('created_at', 'desc')->where('professor_id', '=', $professor->id)->get();

        //Contagem de turmas:
        //A = Todas as turmas (Atribuir ao A).
        //B = Todas as turmas ativas (Se o pivot inativo é 1, contar para B).
        //C = Todas as turmas inativas (Subtrai A pelo B e adiciona o número ao C).
        //Adiciona id de núcleos ao array de idsnucleos e depois excluir números repetidos.
        $a = 0; $b = 0; $idsnucleos = [];
        foreach($professor->turmas as $turma){
            array_push($idsnucleos, $turma->nucleo_id);
            if($turma->pivot->inativo == 1){$b++;}
            $a++;
        }
        $c = $a - $b;
        $dadosgerais = [$a,$b,$c];
        $idsnucleos = array_unique($idsnucleos);

        //Encontra todos os núcleos que estão no array de idsnucleos.
        $listnucleoprofessor = Nucleo::whereIn('id', $idsnucleos)->get();

        return view ('professores_file.professor_info', compact('professor','histprofessor','dadosgerais','listnucleoprofessor'));
    }

    //Função professores_turmas: Seleciona informações necessarias para vizualização e retorna a página de turmas e professores.
    public function professor_turmas($id){
        //Encontra todos os núcleos registrados.
        $nucleoslist = Nucleo::orderBy('nome')->get();

        //Criar array de dias da semana.
        $dias_semana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'];

        //Checar se o usuário é um professor ou um administrador.
        if(auth()->user()->can('autorizacao', 3)){
            //Se for um administrador:

            //Encontra o professor no banco de dados.
            $professor = Professor::find($id);

            //Encontra todas as turmas registradas.
            $turmaslist = Turma::orderBy('inativo')->orderBy('nome')->get();

            //Atribui a sessão de informação.
            Session::put('quant', count($turmaslist).' turmas cadastradas.');
        }
        else{
            //Se for um professor:

            //Encontra o professor no banco de dados (baseado no id do usuário logado).
            $professor = Professor::where('user_id', '=', auth()->user()->id)->first();

            //Encontra todas as turmas do professor.
            $turmaslist = $professor->turmas->sortBy('nome');

            //Define uma sessão para informação de quantidade.
            Session::put('quant', count($turmaslist).' turmas cadastradas.');
        }

        return view ('professores_file.professores_turmas', compact('professor','turmaslist','dias_semana','nucleoslist'));
    }

    //Função professores_meus_alunos: Seleciona informações necessarias para vizualização e retorna a página de professores e alunos.
    //Somente Professores podem acessar está página.
    public function professor_meus_alunos($idprofessor, $idturma){
        //Encontra o professor no banco de dados.
        $professor = Professor::find($idprofessor);

        //Encontra a turma no banco de dados. 
        $turma = Turma::find($idturma);

        //Encontra todas as pessoas da turma.
        $pessoaslist = $turma->pessoas->sortBy('nome');

        //Reescreve a data de nascimento de todas as pessoas da turma de YYYY-mm-dd para dd/mm/YYYY
        foreach ($pessoaslist as $pessoa){$pessoa['nascimento'] = $this->mostrar_nascimento($pessoa['nascimento'], 2);}

        //Define uma sessão para informação de quantidade.
        Session::put('quant', count($pessoaslist).' pessoas na turma.');

        return view ('professores_file.professores_meus_alunos', compact('pessoaslist', 'turma', 'professor'));
    }

    //Função professores_turmas_vincular: Vincula um professor em uma turma e retorna a página de professores e turmas.
    public function professores_turmas_vincular(Request $request){
        $dataForm = $request->all();
        
        //Encontra o professor no banco de dados.
        $professor = Professor::find($dataForm['professor_id']);

        //Adiciona o campo 'operario' para informações.
        $dataForm += ['operario' => auth()->user()->name];

        //Encontra a turma no banco de dados. 
        $turma = Turma::find($dataForm['turma_id']);

        //Adiciona variavel de inatividade para a criação de professor, (1 = campo ativo).
        $dataForm += ['inativo' => 1];

        //Vincula o professor turma.
        $professor->turmas()->attach($turma->id, ['inativo'=>$dataForm['inativo']]);

        //Adiciona registro no histórico de professores e turmas.
        HistoricoPrT::create($dataForm);

        //Defide uma sessão verde para informação de sucesso. 
        Session::put('mensagem_green', $professor->nome . " foi adicionado a turma" . $turma->nome ." com sucesso!");

        return redirect()->Route('professor_turmas', $professor->id);
    }

    //Função professores_turmas_ativar_inativar: Ativa ou inativa um professor em uma turma e retorna a página de professores e turmas.
    public function professores_turmas_ativar_inativar(Request $request){
        $dataForm = $request->all();

        //Encontra a turma no banco de dados.
        $turma = Turma::find($dataForm['turma_id']);

        //Encontra o professor percorrendo todos os professores da turma para saber qual sua inatividade na turma
        $aux = -1;
        for($i = 0; $i < count($turma->professores); $i++){
            if($turma->professores[$i]->id == $dataForm['professor_id']){$aux = $i;}
        }

        //Define variaveis construtivas:
        //STRING = Query para mandar para o banco de dados.
        //TEXTO = Texto para mandar para sessão de informação.
        //CONTA = Para checagem final para envio de sessão.
        $string = ''; $texto = ''; $conta = 0;

        //Checa se a inatividade do professor é ativo ou inativo:
        if($turma->professores[$aux]->pivot->inativo == 1){
            //Se sim:
            //1 - Muda o campo de inativo para 2 na table de turmas_professores, aonde tem o id do professor e da turma.
            //2 - Adiciona linhas no texto.
            $string = 'update turmas_professores set inativo = 2 where professor_id = :sujeito and turma_id = :turma';
            $texto = ' foi adicionado a turma ';

            //Adiciona registro da alteração no histórico de professores e turmas.
            HistoricoPrT::create([
                'professor_id' => $dataForm['professor_id'],
                'turma_id' => $dataForm['turma_id'],
                'comentario' => $dataForm['comentario'],
                'operario' => auth()->user()->name,
                'inativo' => 2,
            ]);
        }
        else{
            //Se não:
            //1 - Muda o campo de inativo para 1 na table de turmas_professores, aonde tem o id do professor e da turma.
            //2 - Adiciona linhas no texto.
            $string = 'update turmas_professores set inativo = 1 where professor_id = :sujeito and turma_id = :turma';
            $texto = ' foi removido a turma ';

            //Adiciona registro da alteração no histórico de professores e turmas.
            HistoricoPrT::create([
                'professor_id' => $dataForm['professor_id'],
                'turma_id' => $dataForm['turma_id'],
                'comentario' => $dataForm['comentario'],
                'operario' => auth()->user()->name,
                'inativo' => 1,
            ]);
        }

        //Executa o a variavel string no banco de dados que construida nos passos anteriores.
        DB::update(DB::raw($string), ['sujeito'=>$dataForm['professor_id'], 'turma'=>$dataForm['turma_id']]);

        //Encontra o professor no banco de dados.
        $professor = Professor::find($dataForm['professor_id']);

        //Defide uma sessão verde para informação de sucesso. 
        Session::put('mensagem_green', $professor->nome . $texto . $turma->nome ." com sucesso!");

        return redirect()->Route('professor_turmas', $professor->id);
    }
}
