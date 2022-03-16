<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//CONTROLE DE HOME:
//Comentarios em cima, código comentado em baixo.
class HomeController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    //FUNÇÕES DE REDIRECIONAMENTO:
    //Função _construct: Ao iniciar o controller, obrigatóriamente este é a primeira função a ser executada.
    public function __construct(){
        //Middleware de auth, verifica se o usuário é autenticado como um cadastrado (administrador ou professor).
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    //Função index: Redireciona o usuário de acordo com suas expecificações de permissão.
    public function index(){
        //Verifica se o usuário é autenticado:
        if(is_null(auth()->user()->permissao)){
            //Caso não seja, é retornado para página de login.
            return view ('auth.login');
        }
        else {
            //Caso seja, verifica-se se o usuário é administrador:
            if(auth()->user()->can('autorizacao', 3)){
                //Se sim, é redirecionado para a rota de pessoas.index (registro de pessoas).
                return view ('home');
            }
            else{
                //Se não, é redirecionado para a rota de professor_turmas (registro de turmas do professor).
                return redirect()->route('professor_turmas', 1);
            }   
        }
    }
}
