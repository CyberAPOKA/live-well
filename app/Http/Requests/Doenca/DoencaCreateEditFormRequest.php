<?php

namespace App\Http\Requests\Doenca;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoencaCreateEditFormRequest extends FormRequest{
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
            'nome'              => 'required|string|between:3,50',
            'descricao'         => 'required|max:100',
        ];
    }

    public function messages(){
        return[
            'nome.required' => 'O campo nome é de preenchimento obrigatório!',

            'descricao.required' => 'O campo descrição é de preenchimento obrigatório!',
            'descricao.between' => 'A descrição deve estar entre 5 e 100 caracteres'
        ];
    }
}
