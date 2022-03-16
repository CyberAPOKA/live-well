<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

//REQUEST PARA CONTROLE
use App\Http\Requests\Nucleo\NucleoCreateEditFormRequest;
use App\Http\Requests\Nucleo\NucleoProcurarFormRequest;

//MODELOS PARA CONTROLE
use App\Nucleo;
use App\Turma;
use App\Professor;
use App\HistoricoN;
use App\HistoricoPT;
use App\HistoricoT;

//CONTROLE DE NúCLEOS:
//Comentarios em cima, código comentado em baixo.
class NucleosController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //FUNÇÕES DE REDIRECIONAMENTO:
    //Função index: Retorna a página de registros de núcleos.
    public function index(){
        //Encontra todos os registros de núcleos e ordena por nome.
        $nucleoslist = Nucleo::orderBy('nome')->get();

        //Criando array de bairros de São Leopoldo.
        $bairroslist = ['Arroio da Manteiga','Boa Vista','Campestre','Campina','Centro','Cristo Rei','Duque de Caxias',
                        'Fazenda Sao Borja','Feitoria','Fiao','Jardim America','Morro do Espelho','Padre Reus','Pinheiro',
                        'Rio Branco','Rio dos Sinos','Santa Tereza','Santo Andre','Santos Dumont','Sao Joao Batista',
                        'Sao Jose','Sao Miguel','Scharlau','Vicentina'];

        //Define variavel $count para informação de quantidade de registros.
        $count = Nucleo::all();
        Session::put('quant', count($count).' núcleos cadastrados.');

        return view ('nucleos_file.nucleos', compact('nucleoslist', 'bairroslist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Função create: Retorna a página de criação de registros de núcleos.
    public function create(){
        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Criando array de bairros de São Leopoldo.
        $bairroslist = ['Arroio da Manteiga','Boa Vista','Campestre','Campina','Centro','Cristo Rei','Duque de Caxias',
                        'Fazenda Sao Borja','Feitoria','Fiao','Jardim America','Morro do Espelho','Padre Reus','Pinheiro',
                        'Rio Branco','Rio dos Sinos','Santa Tereza','Santo Andre','Santos Dumont','Sao Joao Batista',
                        'Sao Jose','Sao Miguel','Scharlau','Vicentina'];
        
        
        return view ('nucleos_file.nucleos_create', compact('bairroslist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Função store: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de registro de núcleos.
    public function store(NucleoCreateEditFormRequest $request){
        $dataForm = $request->all();

        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Cria núcleo no banco de dados:
        $nucleo =  Nucleo::create($dataForm);

        //Adiciona registro da alteração no histórico de núcleos.
        HistoricoN::create([
            'nucleo_id' => $nucleo->id,
            'inativo' => $nucleo->inativo,
            'operario' => auth()->user()->name,
            'comentario' => 'Criação do núcleo "'.$nucleo->nome.'"',
        ]);

        //Define uma sessão de alerta verde.
        Session::put('mensagem_green', $nucleo->nome.' adicionado com sucesso!');

        return redirect()->Route('nucleos.index');
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

    //Função edit: Retorna a página de edição de registros de núcleos.
    public function edit($id){
        //Encontra o núcleo no banco de dados.
        $nucleo = Nucleo::find($id);

        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Criando array de bairros de São Leopoldo.
        $bairroslist = ['Arroio da Manteiga','Boa Vista','Campestre','Campina','Centro','Cristo Rei','Duque de Caxias',
                        'Fazenda Sao Borja','Feitoria','Fiao','Jardim America','Morro do Espelho','Padre Reus','Pinheiro',
                        'Rio Branco','Rio dos Sinos','Santa Tereza','Santo Andre','Santos Dumont','Sao Joao Batista',
                        'Sao Jose','Sao Miguel','Scharlau','Vicentina'];
        
        
        return view ('nucleos_file.nucleos_edit', compact('nucleo','bairroslist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função update: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de index.
    public function update(NucleoCreateEditFormRequest $request, $id){
        $dataForm = $request->all();

        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Encontra o professor no banco de dados.
        $nucleo = Nucleo::find($id);

        //Adiciona variavel de inatividade para a criação de núcleos.
        $dataForm += ['inativo' => $nucleo->inativo];

        //Busca os valores antigos do núcleo, edita e depois busca os valores novos do núcleo.
        $oldnucleo = (array)$nucleo;
        $nucleo->update($dataForm);
        $newnucleo = (array)$nucleo;

        //Se os valores do núcleo são diferentes, define uma sessão verde de informação.
        if($newnucleo != $oldnucleo){
            Session::put('mensagem_green', $nucleo->nome.' editado com sucesso!');
        }
        
        return redirect()->Route('nucleos.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função destroy: Deletar o núcleo.
    public function destroy(Request $request, $id){
        //Função de deletar não ultilizada para núcleo.
    }

    //Função nucleo_info: Seleciona informações necessarias para vizualização e retorna a página de informações do núcleo.
    public function nucleo_info($id){
        //Encontra o professor no banco de dados.
        $nucleo = Nucleo::find($id);

        //Encontra todos o histórico do nucleo encontrado.
        $histnucleo = HistoricoN::orderBy('created_at', 'desc')->where('nucleo_id', '=', $nucleo->id)->get();

        //Contagem de pessoas:
        //A = Todas as pessoas (Atribuir ao A).
        //B = Todas as pessoas ativas (Se o pivot inativo é 1, contar para B).
        //C = Todas as pessoas inativas (Subtrai A pelo B e adiciona o número ao C).
        $a = count(DB::select(DB::raw('SELECT * FROM pessoas WHERE 
                                                        id IN(SELECT pessoa_id FROM turmas_pessoas WHERE 
                                                            turma_id IN(SELECT turma_id FROM nucleos WHERE 
                                                                id = '.$id.')) ORDER BY id')));
        $b = count(DB::select(DB::raw('SELECT * FROM pessoas WHERE 
                                                        id IN(SELECT pessoa_id FROM turmas_pessoas WHERE 
                                                            turma_id IN(SELECT turma_id FROM nucleos WHERE 
                                                                id = '.$id.') and inativo = 1) ORDER BY id')));
        $c = $a - $b;
        $dadosgerais = [$a,$b,$c];

        //Contagem de turmas:
        //A = Todas as turmas (Atribuir ao A).
        //B = Todas as turmas ativas (Se o pivot inativo é 1, contar para B).
        //C = Todas as turmas inativas (Subtrai A pelo B e adiciona o número ao C).
        $a = 0; $b = 0; $c = 0;
        foreach($nucleo->turmas as $turma){
            if($turma->inativo == 1){$b++;}
            $a++;
        }
        $c = $a - $b;
        $dadosgerais2 = [$a,$b,$c];
        
        return view ('nucleos_file.nucleos_info', compact('nucleo','histnucleo','dadosgerais','dadosgerais2'));
    }

    //Função nucleos_ativar_inativar: Ativa ou inativa um nucleo e retorna a página de index.
    public function nucleos_ativar_inativar(Request $request){
        $dataForm = $request->all();

        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Enconta o professor no banco de dados.
        $nucleo = Nucleo::find($dataForm['nucleo_id']);

        //Adiciona o campo 'operario' para informações.
        $dataForm += ['operario' => auth()->user()->name];

        //Verifica se o núcleo está ativo ou não.
        if($nucleo->inativo == 1){
            //Se sim, inativa o núcleo modificando o campo inativo para 2;
            $nucleo->update(['inativo' => 2]);

            //Adiciona campos para criação de histórico.
            $dataForm += ['inativo' => 2];

            //Inativa todas as pessoas e todas as turmas que estão no núcleo devido a inativação do núcleo.
            foreach($nucleo->turmas as $turma){
                //Update no banco de dados para inativar todas as turmas do núcleo
                DB::update(DB::raw('update turmas set quant_atual = 0 where id = :turma'), ['turma'=>$turma->id]);
                DB::update(DB::raw('update turmas set inativo = 2 where id = :turma'), ['turma'=>$turma->id]);

                //Criar histórico da turma banco de dados.
                HistoricoT::create([
                    'turma_id' => $turma->id,
                    'comentario' => 'Turma inativada devido a inativação do núcleo.',
                    'operario' => auth()->user()->name,
                    'inativo' => 2,
                ]);

                //Percorre todas as pessoas da turma.
                foreach($turma->pessoas as $pessoa){
                    //Update no banco de dados para inativar todas as pessoas.
                    DB::update(DB::raw('update turmas_pessoas set inativo = 2 where pessoa_id = :sujeito and turma_id = :turma'), ['sujeito'=>$pessoa->id, 'turma'=>$turma->id]);

                    //Criar histórico da pessoa banco de dados.
                    HistoricoPT::create([
                        'pessoa_id' => $pessoa->id,
                        'turma_id' => $turma->id,
                        'comentario' => 'Pessoa inativada devido a inativação do núcleo da turma.',
                        'operario' => auth()->user()->name,
                        'inativo' => 2,
                    ]);
                }
            }

            //Define sessão verde para informação.
            Session::put('mensagem_green', $nucleo->nome . " foi inativado com sucesso!");
        }
        else{
            //Se não, ativa o núcleo modificando o campo inativo para 1;
            $nucleo->update(['inativo'=>1]);

            //Adiciona campos para criação de histórico.
            $dataForm += ['inativo' => 1];

            //Define sessão verde para informação.
            Session::put('mensagem_green', $nucleo->nome . " foi ativado com sucesso!");
        }

        //Adiciona registro da alteração no histórico de núcleos.
        HistoricoN::create($dataForm);

        return redirect()->Route('nucleos.index');
    }
}
