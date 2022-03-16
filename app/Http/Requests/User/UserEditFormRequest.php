<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserEditFormRequest extends FormRequest{
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
            'nick'                    => 'required|string|between:5,100',
            'email'                   => 'required|string|email|max:50|unique:users,email,'.$this->id.'|',
            'name'                    => 'sometimes|nullable|string|between:5,30|unique:users,name,'.$this->id.'|',
            'password'                => 'sometimes|nullable|string|between:5,30',
            'confirm_password'        => 'sometimes|nullable|required_with:password|same:password',
        ];
    }

    public function messages(){
        return[
            'nick.required' => 'O campo usuário é de preenchimento obrigatório!',
            'nick.between' => 'Máximo de 30 caracteres e mínimo de 5 caracteres no campo de usuário!',

            'name.between' => 'Máximo de 30 caracteres e mínimo de 5 caracteres no campo de nome de administrador!',

            'password.between' => 'Máximo de 30 caracteres e mínimo de 5 caracteres no campo de senha!',

            'confirm_password.required_with' => 'É necessario confirmar a senha de cadastro para o registro!',
            'confirm_password.same' => 'Confirmação de senha inválida, por favor digitar novamente!',
        ];
    }
}