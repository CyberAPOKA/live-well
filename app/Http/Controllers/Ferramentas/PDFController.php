<?php

namespace App\Http\Controllers\Ferramentas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//MODELOS PARA CONTROLE:
use App\Pessoa;
use App\Turma;
use App\Nucleo;

//CONTROLE DE PDF:
//Comentarios em cima, código comentado em baixo.
class PDFController extends Controller{
    //FUNÇÃO DE FERRAMENTAS:
    //Ferramenta returnIds: Retira as chaves da string e retorna um array de ids.
    public function returnIds($list){
        $list = str_replace('[', '', $list);
        $list = str_replace(']', '', $list);

        return explode(',', $list);
    }

    //FUNÇÕES DE REDIRECIONAMENTO:
    //Função menu_pessoas_pdf: Retorna a página de menu contendo ferramentas para modificar o relatório de pessoas.    
    public function menu_pessoas_pdf($op, $list){
        //Transforma a string passada para um array de ids.
        $list = $this->returnIds($list);

        //Encontra todas as pessoas contidas na lista.
        $pessoaslist = Pessoa::whereIn('id', $list)->get();

        return view ('pdf_file.pdf_pessoas.menu_pdf_pessoas', compact('pessoaslist', 'op'));
    }

    //Função menu_turmas_pdf: Retorna a página de menu contendo ferramentas para modificar o relatório de turmas.  
    public function menu_turmas_pdf($list){
        //Transforma a string passada para um array de ids.
        $list = $this->returnIds($list);

        //Encontra todas as turmas contidas na lista.
        $turmaslist = Turma::whereIn('id', $list)->get();

        return view ('pdf_file.pdf_turmas.menu_pdf_turmas', compact('turmaslist'));
    }

    //Função menu_nucleos_pdf: Retorna a página de menu contendo ferramentas para modificar o relatório de núcleos.  
    public function menu_nucleos_pdf($list){
        //Transforma a string passada para um array de ids.
        $list = $this->returnIds($list);

        //Encontra todos os núcleos contidos na lista.
        $nucleoslist = Nucleo::whereIn('id', $list)->get();

        return view ('pdf_file.pdf_nucleos.menu_pdf_nucleos', compact('nucleoslist'));
    }

    //Função pdfpessoas: Retorna o pdf das informações da pessoa.
    public function pessoas_pdf(Request $request, $list){
        $dataForm = $request->all();

        //Define as escolhas feitas pelo usuário no menu de ferramentas para relatórios.
        //Se a opção foi marcada para o relatório, adiciona valor 1, se não, adiciona valor 0.
        $opcoes_colunas = [];
        if(isset($dataForm['endereco'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['telefone'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['data_nascimento'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['rg'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['morto'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}

        //Transforma a string passada para um array de ids.
        $list = $this->returnIds($list);

        //Se algum id que esta na lista de ids, porém não foi passado pelo formulário, será anulado no relatório.
        foreach($list as $id){
            if(!isset($dataForm[$id])){
                $key = array_search($id, $list);
                unset($list[$key]);
            }
        }

        //Encontra todas as pessoas contidas na lista baseado nas escolhas do menu.
        //Se a opção for por 'nome', a ordem da lista será por nome, se for por 'data', a ordem será por data.
        if($dataForm['option_order'] == 'nome'){
            $pessoaslist = Pessoa::whereIn('id', $list)->orderBy('nome')->get();
        }
        elseif($dataForm['option_order'] == 'data'){
            $pessoaslist = Pessoa::whereIn('id', $list)->orderBy('created_at')->get();
        }

        return \PDF::loadview('pdf_file.pdf_pessoas.pessoas_pdf', compact('pessoaslist','opcoes_colunas'))->setPaper('a4', 'landscape')->stream('PDF_registro_pessoas'.'.pdf');
    }

    public function turmas_pdf(Request $request, $list){
        $dataForm = $request->all();

        //Define as escolhas feitas pelo usuário no menu de ferramentas para relatórios.
        //Se a opção foi marcada para o relatório, adiciona valor 1, se não, adiciona valor 0.
        $opcoes_colunas = [];
        if(isset($dataForm['limite'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['quant_atual'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['data_semanal'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['horario'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['inativo'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}

        //Transforma a string passada para um array de ids.
        $list = $this->returnIds($list);

        //Encontra todas as turmas contidas na lista baseado nas escolhas do menu.
        //Se a opção for por 'nome', a ordem da lista será por nome, se for por 'data', a ordem será por data.
        if($dataForm['option_order'] == 'nome'){
            $turmaslist =  Turma::whereIn('id', $list)->orderBy('nome')->get();
        }
        elseif($dataForm['option_order'] == 'data'){
            $turmaslist = Turma::whereIn('id', $list)->orderBy('created_at')->get();
        }

        return \PDF::loadview('pdf_file.pdf_turmas.turmas_pdf', compact('turmaslist','opcoes_colunas'))->stream('PDF_registro_turmas'.'.pdf');
    }

    public function nucleos_pdf(Request $request, $list){
        $dataForm = $request->all();

        //Define as escolhas feitas pelo usuário no menu de ferramentas para relatórios.
        //Se a opção foi marcada para o relatório, adiciona valor 1, se não, adiciona valor 0.
        $opcoes_colunas = [];
        if(isset($dataForm['cidade'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['bairro'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['rua'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['numero_endereco'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['cep'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}
        if(isset($dataForm['inativo'])){array_push($opcoes_colunas, 1);}else{array_push($opcoes_colunas, 0);}

        //Transforma a string passada para um array de ids.
        $list = $this->returnIds($list);

        //Encontra todos os núcleos contidos na lista baseado nas escolhas do menu.
        //Se a opção for por 'nome', a ordem da lista será por nome, se for por 'data', a ordem será por data.
        if($dataForm['option_order'] == 'nome'){
            $nucleoslist =  Nucleo::whereIn('id', $list)->orderBy('nome')->get();
        }
        elseif($dataForm['option_order'] == 'data'){
            $nucleoslist = Nucleo::whereIn('id', $list)->orderBy('created_at')->get();
        }

        return \PDF::loadview('pdf_file.pdf_nucleos.nucleos_pdf', compact('nucleoslist','opcoes_colunas'))->stream('PDF_registro_nucleos'.'.pdf');
    }
}
