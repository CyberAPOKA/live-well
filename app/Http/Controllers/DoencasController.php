<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator; 

//REQUEST PARA CONTROLE:
use App\Http\Requests\Doenca\DoencaCreateEditFormRequest;

//MODELOS PARA CONTROLE:
use App\Doenca;

//CONTROLE DE DOENÇAS:
//Comentarios em cima, código comentado em baixo.
class DoencasController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //FUNÇÕES DE REDIRECIONAMENTO:
    //Função index: Retorna a página de registros de doenças.
    public function index(){
        //Encontra todos os registros de doenças no banco de dados e ordena por nome.
        $doencaslist = Doenca::orderBy('nome')->paginate(10);

        //Define variavel $count para informação de quantidade de registros.
        $count = Doenca::all();
        Session::put('quant', count($count).' doenças cadastradas.');

        return view ('doencas_file.doencas', compact('doencaslist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Função create: Retorna a página de criação de registros de doenças.
    public function create(){
        return view ('doencas_file.doencas_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Função store: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de index.
    public function store(DoencaCreateEditFormRequest $request){
        $dataForm = $request->all();

        //Cria doença no banco de dados:
        Doenca::create($dataForm);

        //Define sessões de informação para apresentação na página.
        Session::put('mensagem_green', $dataForm['nome'].' adicionada com sucesso!');

        return redirect()->Route('doencas.index');
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

    //Função edit: Retorna a página de edição de registros de doenças.
    public function edit($id){
        //Encontra a doença no banco de dados.
        $doenca = Doenca::find($id);

        return view ('doencas_file.doencas_edit', compact('doenca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    //Função update: Faz as mudanças necessarias para adicionar no banco de dados e retorna a página de index.
    public function update(DoencaCreateEditFormRequest $request, $id){
        $dataForm = $request->all();

        //Encontra a doença no banco de dados.
        $doenca = Doenca::find($id);

        //Busca os valores antigos da doença.
        $olddoenca = (array)$doenca;

        //Edita doença no banco de dados.
        $doenca->update($dataForm);

        //busca os valores novos da turma.
        $newdoenca = (array)$doenca;

        //Verifica se os valores velhos são iguais aos valores novos da doença.
        if($olddoenca != $newdoenca){
            //Se os valores da doença são diferentes, define uma sessão verde de informação.
            Session::put('mensagem_green', $doenca->nome.' editada com sucesso!');
        }

        return redirect()->Route('doencas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Função destroy: Deletar a doença.
    public function destroy(Request $request, $id){
        //Função de deletar não ultilizada para doenças.
    }

    //Função criar_doenca_ajax: Retorna por ajax, se os valores não forem nulos, cria a doença e retorna lista ordenada.
    public function criar_doenca_ajax(Request $request){
        $dataForm = $request->all();

        //Verifica se algum dos requisitos (nome e descrição) da doença é nulo.
        if(is_null($dataForm['nome']) || is_null($dataForm['descricao'])){
            //Se sim, retorna 1 (criação bloqueada)
            return response()->json(1);
        }
        else{
            //Se não, cria a doença no banco de dados e retorna o registro de doenças para a página.
            Doenca::create($dataForm);

            //Encontra todos os registros de doenças e ordena por nome.
            $doencas = Doenca::orderBy('nome')->get();

            return response()->json($doencas);
        }
    }
}
