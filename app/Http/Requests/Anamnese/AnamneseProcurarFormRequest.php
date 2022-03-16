<?php

namespace App\Http\Requests\Anamnese;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnamneseProcurarFormRequest extends FormRequest{
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
            'toma_medicacao'        => ['required', Rule::in(['1', '2']),],
            'alergia_medicacao'     => ['required', Rule::in(['1', '2']),],
            'fumante'               => ['required', Rule::in(['1', '2']),],
            'cirurgia'              => ['required', Rule::in(['1', '2']),],
            'dor_ossea'             => ['required', Rule::in(['1', '2']),],
            'dor_muscular'          => ['required', Rule::in(['1', '2']),],
            'dor_articular'         => ['required', Rule::in(['1', '2']),],
            'doencas_id'            => 'sometimes|nullable|integer|exists:doencas,id',
            'atestado'              => ['sometimes','nullable','regex:/\.((pdf))+$/'],
        ];
    }
}
