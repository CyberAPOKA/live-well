<?php

namespace App\Http\Requests\Nucleo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NucleoCreateEditFormRequest extends FormRequest{
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
            'nome'                  => 'required|string|between:3,100',
            'bairro'                => 'required',
            'rua'                   => 'required',
            'numero_endereco'       => 'required',
            'cep'                   => 'required|max:9|min:9',
            'descricao'             => 'sometimes|nullable|between:5,100',
        ];
    }

    public function messages(){
        return[
            'nome.required' => 'O campo nome é de preenchimento obrigatório!',
            'nome.between' => 'Insira um nome entre 3 ou 100 caracteres!',

            'bairro.required' => 'O campo bairro é de preenchimento obrigatório!',

            'rua.required' => 'O campo rua é de preenchimento obrigatório!',
            'rua.max' => 'Insira uma rua válida!',
            'rua.regex' => 'Não insira caracteres especiais na rua',

            'numero_endereco.required' => 'O campo número é de preenchimento obrigatório!',
            'numero_endereco.digits_between' => 'Insira um número com no máximo 5 dígitos!',

            'cep.required' => 'O campo CEP é de preenchimento obrigatório!',
            'cep.max' => 'Insira um cep válido!',
            'cep.min' => 'Insira um cep válido!',

            'descricao.between' => 'O campo descrição deve estar entre 5 e 100 caracteres!',
        ];
    }
}
