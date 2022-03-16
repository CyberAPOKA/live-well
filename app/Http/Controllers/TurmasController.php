<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

//REQUESTS PARA CONTROLE:
use App\Http\Requests\Turma\TurmaCreateFormRequest;
use App\Http\Requests\Turma\TurmaEditFormRequest;
use App\Http\Requests\Turma\TurmaProcurarFormRequest;

//MODELOS PARA CONTROLE:
use App\Turma;
use App\Nucleo;
use App\Pessoa;
use App\Professor;
use App\HistoricoT;
use App\HistoricoPT;

//CONTROLE DE TURMAS:
//Comentarios em cima, código comentado em baixo.
class TurmasController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //FUNÇÕES DE REDIRECIONAMENTO:
    //Função index: Retorna a página de registros de turmas.
    public function index(){
        //Encontra todos os registros de turmas e ordena por nome.
        $turmaslist = Turma::orderBy('nome')->get();

        //Encontra todos os registros de núcleos.
        $nucleoslist = Nucleo::all();

        //Criando array de dias da semana.
        $dias_semana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

        //Define variavel $count para definir sessão de informação.
        $count = Turma::all();
        Session::put('quant', count($count).' turmas cadastradas.');

        return view ('turmas_file.turmas', compact('turmaslist', 'nucleoslist', 'dias_semana'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Função create: Retorna a página de criação de registros de turmas.
    public function create(){
        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);
        
        //Encontra todos os registros de nucleos.
        $nucleoslist = Nucleo::orderBy('nome')->get();

        //Criando array de dias da semana.
        $dias_semana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

        return view ('turmas_file.turmas_create', compact('nucleoslist', 'dias_semana'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Função store: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de registro de turmas.
    public function store(TurmaCreateFormRequest $request){
        $dataForm = $request->all();

        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Define a variavel dias_da_semana para compactar todos os dias da semana escolhidas e depois define para a criação.
        $dias_da_semana = '';
        foreach($dataForm['data_semanal'] as $data){$dias_da_semana = $dias_da_semana.$data.',';}
        $dataForm['data_semanal'] = $dias_da_semana;

        //Cria turma no banco de dados.
        $turma = Turma::create($dataForm);

        //Adiciona registro da alteração no histórico de turmas.
        HistoricoT::create([
            'turma_id' => $turma->id,
            'inativo' => $turma->inativo,
            'operario' => auth()->user()->name,
            'comentario' => 'Criação da turma "'.$turma->nome.'"',
        ]);

        //Define sessõa de informação para apresentação na página.
        Session::put('mensagem_green', "A turma " . $turma->nome . " foi cadastrada com sucesso!");

        return redirect()->Route('turmas.index');
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

    //Função edit: Retorna a página de edição de registros de turmas.
    public function edit($id){
        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Encontra a turma no banco de dados. 
        $turma = Turma::find($id);

        //Retirando milisegundos padrão do banco de dados nos campos da turma.
        $turma->horario_inicial = substr($turma->horario_inicial, 0, 5);
        $turma->horario_final = substr($turma->horario_final, 0, 5);

        //Encontra o núcleo no banco de dados.
        $nucleoslist = Nucleo::all();

        //Criando array de dias da semana.
        $dias_semana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

        //Separa dias da semana da turma e atribui na variavel $datas_escolhidas e retida o ultima array em branco.
        $datas_escolhidas = explode(',', $turma['data_semanal']);
        unset($datas_escolhidas[count($datas_escolhidas) - 1]);
        
        return view ('turmas_file.turmas_edit', compact('turma', 'nucleoslist', 'dias_semana', 'datas_escolhidas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função update: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de registro de turmas.
    public function update(TurmaEditFormRequest $request, $id){
        $dataForm = $request->all();

        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Encontra a turma no banco de dados.
        $turma = Turma::find($id);

        //Busca os valores antigos da turma.
        $oldturma = (array)$turma;

        //Junta os dias da semana escolhidos na variavel $dias_da_semana para editar no banco de dados.
        $dias_da_semana = '';
        foreach($dataForm['data_semanal'] as $data){$dias_da_semana = $dias_da_semana.$data.',';}
        $dataForm['data_semanal'] = $dias_da_semana;

        //Edita turma no banco de dados.
        $turma->update($dataForm);

        //busca os valores novos da turma.
        $newturma = (array)$turma;

        //Verifica se os valores velhos são iguais aos valores novos da turma.
        if($newturma != $oldturma){
            //Se os valores da turma são diferentes, define uma sessão verde de informação.
            Session::put('mensagem_green', $turma->nome.' adicionada com sucesso!');
        }

        return redirect()->Route('turmas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função destroy, deletar a turma.
    public function destroy(Request $request, $id){
        //Função de deletar não ultilizada para turmas.
    }

    //Função turma_info: Seleciona informações necessarias para vizualização e retorna a página de informações da turma.
    public function turma_info($id){
        //Encontra a turma no banco de dados. 
        $turma = Turma::find($id);

        //Separa dias da semana da turma e atribui na variavel $datas_escolhidas e retida o ultima array em branco.
        $dias = explode(',', $turma['data_semanal']);
        unset($dias[count($dias) - 1]);

        //Seleciona todos o histórico da turma encontrada.
        $histturma = HistoricoT::orderBy('created_at', 'desc')->where('turma_id', '=', $turma->id)->get();

        //Contagem de pessoas:
        //A = Todas as pessoas (Atribuir ao A).
        //B = Todas as pessoas ativas (Se o pivot inativo é 1, contar para B).
        //C = Todas as pessoas inativas (Subtrai A pelo B e adiciona o número ao C).
        $a = 0; $b = 0;
        foreach($turma->pessoas as $pessoa){
            if($pessoa->pivot->inativo == 1){$b++;}
            $a++;
        }
        $c = $a - $b;
        $dadosgerais = [$a,$b,$c];

        return view('turmas_file.turmas_info', compact('turma','dias','histturma','dadosgerais'));
    }

    //Função turmas_ativar_inativar: Ativa ou inativa uma turma e retorna a página de index.
    public function turmas_ativar_inativar(Request $request){
        $dataForm = $request->all();

        //Função acessivel apenas para o usuário do tipo 2, caso não seja o usuário do tipo 2, será bloqueado destas ações.
        $this->authorize('autorizacao', 2);

        //Encontra a turma no banco de dados.
        $turma = Turma::find($dataForm['turma_id']);

        //Adiciona o campo 'operario' para informações.
        $dataForm += ['operario' => auth()->user()->name];

        //Verifica se a turma está ativa ou não.
        if($turma->inativo == 1){
            //Se sim, inativa a turma modificando o campo inativo para 2;
            $turma->update(['inativo' => 2]);

            //Adiciona campos para criação de histórico.
            $dataForm += ['inativo' => 2];

            //Inativa todas as pessoas da turma.
            foreach($turma->pessoas as $pessoa){
                //Update no banco de dados para inativar todas as pessoas.
                DB::update(DB::raw('update turmas_pessoas set inativo = 2 where pessoa_id = :sujeito and turma_id = :turma'), ['sujeito'=>$pessoa->id, 'turma'=>$turma->id]);

                //Cria histórico no banco de dados.
                HistoricoPT::create([
                    'pessoa_id' => $pessoa->id,
                    'turma_id' => $turma->id,
                    'comentario' => 'Pessoa inativada devido a inativação da turma.',
                    'operario' => auth()->user()->name,
                    'inativo' => 2,
                ]);
            }

            //Define sessão verde para informação.
            Session::put('mensagem_green', $turma->nome . " foi inativado com sucesso!");
        }
        else{
            //Se não, ativa a turma modificando o campo inativo para 1;
            $turma->update(['inativo'=>1]);

            //Adiciona campos para criação de histórico.
            $dataForm += ['inativo' => 1];

            //Define sessão verde para informação.
            Session::put('mensagem_green', $turma->nome . " foi ativado com sucesso!");
        }

        //Adiciona registro da alteração no histórico de núcleos.
        HistoricoT::create($dataForm);

        return redirect()->Route('turmas.index');
    }
}
