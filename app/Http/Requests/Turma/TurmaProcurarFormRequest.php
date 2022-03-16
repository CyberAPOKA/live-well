<?php

namespace App\Http\Requests\Turma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TurmaProcurarFormRequest extends FormRequest{
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
            'horario_inicial'       => ['sometimes', 'nullable','regex:/^[0-2][0-9]:[0-5][0-9]$/'],
            'horario_final'         => ['sometimes', 'nullable','regex:/^[0-2][0-9]:[0-5][0-9]$/'],
            'data_semanal'          => 'sometimes|nullable|array|',
        ];
    }

    public function messages(){
        return[
            'horario_inicial.regex' => 'Digite um horário inicial válido!',

            'horario_final.regex' => 'Digite um horário final válido!',
        ];
    }
}
