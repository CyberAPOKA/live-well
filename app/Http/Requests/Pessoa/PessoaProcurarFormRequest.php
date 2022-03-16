<?php

namespace App\Http\Requests\Pessoa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PessoaProcurarFormRequest extends FormRequest{
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
            'estado_civil'          => ['sometimes','nullable', Rule::in(['Casado', 'Solteiro'])],
            'estado'                => ['sometimes','nullable', Rule::in(['1', '2'])],
            'completo'              => ['sometimes','nullable', Rule::in(['S', 'N'])],
        ];
    }

    public function messages(){
        return[
            'de.date_format' => 'Insira uma data sem letras',
            'ate.date_format' => 'Insira uma data sem letras',
        ];
    }
}
