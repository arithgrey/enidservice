<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValoracionRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comentario' => 'required|min:10|max:255',
            'calificacion' => 'required|integer|between:1,5',
            'recomendaria' => 'required|integer|between:0,1',
            'titulo' => 'required|min:2|max:70',
            'email' => 'required|email',
            'nombre' => 'required|min:3|max:55',
            'id_servicio' => 'required|integer',
            'status' => 'integer|between:1,5',
            'id_tipo_valoracion' => 'required|integer',
        ];
    }
}
