<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

//MODELOS PARA CONTROLE:
use App\User;
use App\Quant;

//CONTROLE DE Administrador Mestre:
//Comentarios em cima, código comentado em baixo.
class AdminMestreController extends Controller{
    //FUNÇÕES DE REDIRECIONAMENTO:
    protected function secretario_register(Request $request){    
        return view ('auth.secretario.secretario_register');
    }

    //Função create: Retorna a página de criação de registros de secretarios.
    protected function secretario_store(Request $request){
        $dataForm = $request->all();
        
        //Encontra todos os registros de usuários que possuem a permissão do tipo 2 (secretarios).
        $secretarioslist = User::where('permissao', '=', 2)->get();
        //Percorre a lista de secretarios, assim que o sistema achar o secretario ativo no momento, ele será deletado.
        if(count($secretarioslist) != 0){
            foreach($secretarioslist as $secretario){
                if($secretario->deleted_at == null){
                    $user = User::find($secretario['id']);
                    $user->delete();
                    break;
                }
            }
        }

        //Cria o novo secretario no banco de dados.
        User::create([
            'nick' => $dataForm['nick'],
            'name' => $dataForm['name'],
            'permissao' => 2,
            'email' => $dataForm['email'],
            'password' => Hash::make($dataForm['password']),
        ]);

        //Encontra todos os registros de usuários e ordena por nick.
        $userslist = User::withTrashed()->orderBy('nick')->where('permissao', '!=', 1)->get();

        //Encontra o número definido como limite de quantidade de turmas que uma pessoa pode ter no sistema.
        $quantidade = Quant::find(1);

        //Define um sessão em verde para informar a criação do usuário.
        Session::put('mensagem_green', "Secretario criado com sucesso!");
        
        return view ('auth.users', compact('userslist','quantidade'));
    }
}
