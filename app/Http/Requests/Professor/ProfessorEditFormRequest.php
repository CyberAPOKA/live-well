<?php

namespace App\Http\Requests\Professor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfessorEditFormRequest extends FormRequest{
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
            'nome'                  => 'required|regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/|between:3,100',
            'matricula'             => 'required|integer|unique:professores,matricula,'.$this->id.'|',
            'nascimento'            => 'required|date-format:d/m/Y',
            'bairro'                => 'required_without:string_bairro','max:100',
            'string_bairro'         => 'required_without:bairro','max:100',
            'rua'                   => 'required',
            'numero_endereco'       => 'required|digits_between:0,15',
            'cep'                   => 'required|max:9|min:9',
            'telefone'              => 'required|max:16|min:8',
            'email'                 => 'required|string|email|max:255|unique:users,email,'.$this->id_user.'|',
            'cpf'                   => 'required|cpf|max:14|min:14|unique:professores,cpf,'.$this->id.'|unique:pessoas|',
            'rg'                    => 'required|max:13|min:6',
            'curso'                 => 'required|between:3,100',
            'formacao'              => 'required|between:3,100',
        ];
    }

    public function messages(){
        return[
            'nome.required' => 'O campo nome é de preenchimento obrigatório!',
            'nome.regex' => 'Insira um nome sem caractéres especiais!',
            'nome.between' => 'Insira um nome entre 3 ou 100 caracteres!',

            'matricula.required' => 'O campo matricula é de preenchimento obrigatório!',
            'matricula.unique' => 'Número de matricula já cadastrada!',

            'nascimento.required' => 'O campo nascimento é de preenchimento obrigatório',
            'nascimento.date' => 'Insira uma data sem letras',

            'bairro.required' => 'O campo bairro é de preenchimento obrigatório!',
            'bairro.max' => 'Insira um bairro válido!',
            'bairro.regex' => 'Não insira caracteres especiais no bairro',

            'string_bairro.required' => 'O campo bairro é de preenchimento obrigatório!',
            'string_bairro.max' => 'Insira um bairro válido!',
            'string_bairro.regex' => 'Não insira caracteres especiais no bairro',

            'rua.required' => 'O campo rua é de preenchimento obrigatório!',
            'rua.max' => 'Insira uma rua válida!',
            'rua.regex' => 'Não insira caracteres especiais na rua',

            'numero_endereco.required' => 'O campo número é de preenchimento obrigatório!',
            'numero_endereco.digits_between' => 'Insira um número com no máximo 5 dígitos!',

            'cep.required' => 'O campo CEP é de preenchimento obrigatório!',
            'cep.digits' => 'Insira um cep válido!',

            'telefone.required' => 'O campo telefone é de preenchimento obrigatório!',
            'telefone.max' => 'Insira um telefone válido!',
            'telefone.min' => 'Insira um telefone válido!',

            'email.required' => 'O campo email é de preenchimento obrigatório!',
            'email.unique' => 'Email já registrado!',
            'email.max' => 'O email deve ter no maximo 255 caractéres',

            'cpf.required' => 'O campo CPF é de preenchimento obrigatório!',
            'cpf.max' => 'Insira um CPF de 11 caracteres!',
            'cpf.min' => 'Insira um CPF de 11 caracteres!',
            'cpf.unique' => 'CPF já cadastrado no sistema!',

            'rg.required' => 'O campo RG é de preenchimento obrigatório!',
            'rg.max:' => 'O rg deve ter entr 6 ou 13 caracteres!',

            'curso.required' => 'O campo curso é de preenchimento obrigatório!',
            'curso' => 'O nome do curso deve ter entre 3 ou 100 caracteres',

            'formacao.required' => 'O campo formação é de preenchimento obrigatório!',
            'formacao' => 'O nome da formação de ter entre 3 ou 100 caracteres',
        ];
    }
}
