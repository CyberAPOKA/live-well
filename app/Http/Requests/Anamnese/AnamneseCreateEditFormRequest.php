<?php

namespace App\Http\Requests\Anamnese;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Validator;
use JsValidator;
use PDF;

class AnamneseCreateEditFormRequest extends FormRequest{
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
            //'atestado'              => ['sometimes','nullable','regex:/\.((pdf))+$/'],
           
        ];
    }

    public function messages(){
        return [
            'atestado.required' => 'É necessario atestado para completar a anamnese',
            'toma_medicacao.required' => 'É necessário responder se a pessoa toma algum medicamento',
            'alergia_medicacao.required' => 'É necessário responder se a pessoa tem alergia á algum medicamento',
            'fumante.required' => 'É necessário responder se a pessoa fuma',
            'cirurgia.required' => 'É necessário responder se a pessoa já fez cirurgia',
            'dor_ossea.required' => 'É necessário responder se a pessoa possui dor óssea',
            'dor_muscular.required' => 'É necessário responder se a pessoa possui dor muscular',
            'dor_articular.required' => 'É necessário responder se a pessoa possui dor articular',
            
        ];
    }
}
