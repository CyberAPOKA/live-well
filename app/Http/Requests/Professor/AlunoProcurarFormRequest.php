<?php

namespace App\Http\Requests\Professor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlunoProcurarFormRequest extends FormRequest{
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
            'de'                    => 'sometimes|nullable|date-format:d/m/Y',
            'ate'                   => 'sometimes|nullable|date-format:d/m/Y',
            'sexo'                  => ['sometimes','nullable', Rule::in(['M','F'])],
        ];
    }

    public function messages(){
        return[
            'de.date_format' => 'Insira uma data sem letras',
            'ate.date_format' => 'Insira uma data sem letras',
        ];
    }
}
