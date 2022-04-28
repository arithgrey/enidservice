<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' =>  'required',
            'tel_contacto' => 'max:10',
            'tipo' => 'integer'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Ups! parece que falta el nombre de esta persona!',
            'tel_contacto.max' => 'Ups! parece que algo anda mal con ese número, es muy largo!',
            'tipo.integer' => 'Selecciona la tipifiación de esta persona'
        ];
    }

}
