<?php

namespace App\Http\Requests\Nucleo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NucleoProcurarFormRequest extends FormRequest{
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
            'inativo'               => ['sometimes', 'nullable', Rule::in(['1', '2']),],
        ];
    }
}
