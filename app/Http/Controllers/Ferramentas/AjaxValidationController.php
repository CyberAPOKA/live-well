<?php

namespace App\Http\Controllers\Ferramentas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//MODELOS PARA CONTROLE:
use App\User;
use App\Pessoa;
use App\Professor;


//CONTROLE DE VALIDATION DE TODAS AS TABELAS:
//Comentarios em cima, código comentado em baixo.
class AjaxValidationController extends Controller{
    //FUNÇÕES DE AJAX:

    //Função cpfValidation: retorna se o cpf digitado é único no banco de dados, retorna se o cpf passado está registrado no sistema.
    public function cpfValidation(Request $request){
        $dataForm = $request->all();

        //Encontra todos os registros de cpf de pessoas.
        $listacpfpessoas = Pessoa::all('cpf');

        //Encontra todos os registros de cpf de professores.
        $listacpfprofessores = Professor::all('cpf');
        
        //Criar uma variavel para armazenar todos os cpfs encontrados.
        $listacpfs = [];

        //Armazena todos os cpfs das pessoas na variavel $listacpfs.
        foreach($listacpfpessoas as $cpf){
            array_push($listacpfs, $cpf['cpf']);
        }

        //Armazena todos os cpfs das professores na variavel $listacpfs.
        foreach($listacpfprofessores as $cpf){
            array_push($listacpfs, $cpf['cpf']);
        }

        //Verifica se foi passado um id (significa que o usuário está editando uma pessoa ou professor).
        if(isset($dataForm['id'])){
            //Verifica se foi passado o valor de tabela 1 ou 2.
            if($dataForm['tabela'] == 1){
                //Caso tenha sido passado o valor 1, tenta encontrar o cpf na tabela de pessoas.
                $id = Pessoa::find($dataForm['id']);
            }
            else{
                //Caso tenha sido passado o valor 2, tenta encontrar o cpf na tabela de professores.
                $id = Professor::find($dataForm['id']);
            }

            //Retira o cpf encontrado da lista de cpfs para não alertar que o cpf já foi registrado.
            unset($listacpfs[array_search($id['cpf'], $listacpfs)]);
        }
        
        return response()->json(!in_array($dataForm['cpf'], $listacpfs));
    }

    //Função rgValidation: retorna se o rg digitado é único no banco de dados, retorna se o rg passado está registrado no sistema.
    public function rgValidation(Request $request){
        $dataForm = $request->all();

        //Encontra todos os registros de rg de pessoas.
        $listargpessoas = Pessoa::all('rg');

        //Encontra todos os registros de rg de professores.
        $listargprofessores = Professor::all('rg');
        
        //Criar uma variavel para armazenar todos os rgs encontrados.
        $listargs = [];

        //Armazena todos os rgs das pessoas na variavel $listargs.
        foreach($listargpessoas as $rg){
            array_push($listargs, $rg['rg']);
        }

        //Armazena todos os rgs das professores na variavel $listargs.
        foreach($listargprofessores as $rg){
            array_push($listargs, $rg['rg']);
        }
        
        //Verifica se foi passado um id (significa que o usuário está editando uma pessoa ou professor).
        if(isset($dataForm['id'])){
            //Verifica se foi passado o valor de tabela 1 ou 2.
            if($dataForm['tabela'] == 1){
                //Caso tenha sido passado o valor 1, tenta encontrar o rg na tabela de pessoas.
                $id = Pessoa::find($dataForm['id']);
            }
            else{
                //Caso tenha sido passado o valor 2, tenta encontrar o rg na tabela de professores.
                $id = Professor::find($dataForm['id']);
            }
            
            //Retira o rg encontrado da lista de rgs para não alertar que o rg já foi registrado.
            unset($listargs[array_search($id['rg'], $listargs)]);
        }
        
        return response()->json(!in_array($dataForm['rg'], $listargs));
    }  

    //Função emailValidation: retorna se o email digitado é único no banco de dados, retorna se o email passado está registrado no sistema.
    public function emailValidation(Request $request){
        $dataForm = $request->all();

        //Encontra todos os registros de email de usuários.
        $listar = User::all('email');
        
        //Criar uma variavel para armazenar todos os emails encontrados.
        $listaemails = [];

        //Armazena todos os emails das pessoas na variavel $listaemails.
        foreach($listar as $email){
            array_push($listaemails, $email['email']);
        }
        
        //Verifica se foi passado um id (significa que o usuário está editando um administrador ou professor).
        if(isset($dataForm['id'])){
            //Tenta encontrar o email na tabela de administrador.
            
            if(isset($dataForm['prof'])){
                $id = Professor::find($dataForm['id']);
            }
            else{
                $id = User::find($dataForm['id']);
            }

            //Retira o email encontrado da lista de emails para não alertar que o email já foi registrado.
            unset($listaemails[array_search($id['email'], $listaemails)]);
        }

        return response()->json(!in_array($dataForm['email'], $listaemails));
    }

    //Função matriculaValidation: retorna se a matricula digitado é único no banco de dados.
    public function matriculaValidation(Request $request){
        $dataForm = $request->all();


       // dd($request->all());
        $nome =  $request->input('matricula');
        error_log("Name: " . $nome);

        //Encontra todos os registros de matricula de professor.
        $listamatriculaprofessores = Professor::all('matricula');

        //Criar uma variavel para armazenar todas as matriculas encontradas.
        $listamatriculas = [];

        //Armazena todas as matriculas dos professores na variavel $listamatriculas.
        foreach($listamatriculaprofessores as $matricula){
            array_push($listamatriculas, $matricula['matricula']);
        }
        
        //Verifica se foi passado um id (significa que o usuário está editando um professor).
        if(isset($dataForm['id'])){
            //Tenta encontrar a matricula na tabela de administrador.
            $id = Professor::find($dataForm['id']);

            //Retira a matricula encontrado da lista de emails para não alertar que a matricula já foi registrado.
            unset($listamatriculas[array_search($id['matricula'], $listamatriculas)]);
        }


        error_log("Teste resposta: " .  response()->json(!in_array($dataForm['matricula'], $listamatriculas)) );
        return response()->json(!in_array($dataForm['matricula'], $listamatriculas));
    }

   public function nomeUsuarioValidation(Request $request){

    /*Esta função faz a validação da unicidade do nome de usuário*/
    
        $nome = $request->input('nomeUsuario');

        $listaUsuarios = User::pluck('name')->toArray();
      
       return response()->json(!in_array($nome, $listaUsuarios));
    }

}
