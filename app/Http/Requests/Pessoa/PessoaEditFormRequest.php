<?php

namespace App\Http\Requests\Pessoa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PessoaEditFormRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            '3x4'                   => ['sometimes','nullable','regex:/\.((png)|(jpg)|(jpeg)|(img))+$/'],
            //'matricula'             => ['sometimes','nullable','regex:/\.((pdf))+$/'],
            'nome'                  => 'required|regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/|between:3,100',
            'nascimento'            => 'required|date-format:d/m/Y',
            'sexo'                  => ['required', Rule::in(['M','F'])],
            'rg'                    => 'sometimes|nullable|max:13|min:6',
            'cpf'                   => 'sometimes|nullable|cpf|max:14|min:14|unique:pessoas,cpf,'.$this->id.'|unique:professores|',
            'cpf_responsavel'       => 'sometimes|nullable|cpf|max:14|min:14',
            'cidade'                => 'sometimes|nullable|regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/',
            'rua'                   => 'sometimes|nullable',
            'numero_endereco'       => 'sometimes|nullable|digits_between:0,15',
            'bairro'                => 'sometimes|nullable',
            'cep'                   => 'sometimes|nullable||max:9|min:9',
            'telefone'              => 'sometimes|nullable|max:16|min:8',
            'telefone_emergencia'   => 'sometimes|nullable|max:16|min:8',
            'nome_do_pai'           => 'sometimes|nullable|regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/|between:3,100',
            'nome_da_mae'           => 'sometimes|nullable|regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/|between:3,100',
            'pessoa_emergencia'     => 'sometimes|nullable|regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ() ]+$/|between:3,100',
            'filhos'                => 'digits_between:0,4|min:0',
            'irmaos'                => 'digits_between:0,4|min:0',
            'convenio_medico'       => ['sometimes','nullable', Rule::in(['1', '2']),],
            'estado_civil'          => ['sometimes','nullable', Rule::in(['Casado(a)', 'Solteiro(a)', 'Viuvo(a)', 'Divorciado(a)'])],
            'mora_com_os_pais'      => ['sometimes','nullable', Rule::in(['1', '2']),],
            'morte'                 => ['sometimes','nullable', Rule::in(['1', '2']),],
            'string_morte'          => 'sometimes|nullable|string',
            
        ];
    }

    public function messages(){
        return[
            '3x4.regex' => 'O arquivo de perfil deve ser uma imagem ( .png | .jpeg | .img )',
            //'matricula.regex' => 'O arquivo de matricula deve ser uma imagem ( .png | .jpeg | .img )',
            'nome.required' => 'O campo nome é de preenchimento obrigatório!',
            'nome.regex' => 'Insira um nome sem caractéres especiais!',
            'nome.between' => 'Insira um nome entre 3 ou 100 caracteres!',

            'nascimento.required' => 'O campo nascimento é de preenchimento obrigatório',
            'nascimento.date_format' => 'É necessario inserir uma data de nascimento valida',

            'sexo.required' => 'O campo sexo é de preencimento obrigatório',

            'rg.max:' => 'O rg deve ter entr 6 ou 13 caracteres!',

            'cpf.max' => 'Insira um CPF de 11 caracteres!',
            'cpf.min' => 'Insira um CPF de 11 caracteres!',
            'cpf.unique' => 'CPF já cadastrado no sistema!',
            
            'cpf_responsavel.max' => 'Insira um CPF de 11 digitos!',
            'cpf_responsavel.min' => 'Insira um CPF de 11 digitos!',

            'cep.digits' => 'Insira um cep válido!',

            'bairro.max' => 'Insira um bairro válido!',
            'bairro.regex' => 'Não insira caracteres especiais no bairro',

            'rua.max' => 'Insira uma rua válida!',
            'rua.regex' => 'Não insira caracteres especiais na rua',

            'numero.digits_between' => 'Insira um número com no máximo 5 dígitos!',

            'telefone.max' => 'Insira um telefone válido!',
            'telefone.min' => 'Insira um telefone válido!',

            'telefone_emergencia.max' => 'Insira um telefone válido!',
            'telefone_emergencia.min' => 'Insira um telefone válido!',

            'nome_do_pai.regex' => 'Insira o nome do pai sem caractéres especiais!',
            'nome_do_pai.between' => 'Insira o nome do pai entre 3 ou 100 caracteres!',

            'nome_da_mae.regex' => 'Insira o nome da mãe sem caractéres especiais!',
            'nome_da_mae.between' => 'Insira o nome da mãe entre 3 ou 100 caracteres!',

            'pessoa_emergencia.regex' => 'Insira o nome da pessoa de emergência sem caractéres especiais!',
            'pessoa_emergencia.between' => 'Insira o nome da pessoa de emergência entre 3 ou 100 caracteres!',

            'filhos.digits_between' => 'É permitido somente 4 digitos para quantidade de filhos',
            
            'irmaos.digits_between' => 'É permitido somente 4 digitos para quantidade de irmãos',

            'morte.date_format' => 'É necessario inserir uma data de falecimento valida',
        ];
    }
}
