<?php

namespace TamaleFiesta\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestGuardaRecibo extends FormRequest
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
            'sucursal'=> 'required|max:50|min:3',
            'id_entrega'=> 'required|numeric',
            'supervisor'=> 'required|numeric',
            'emisor'=> 'required|numeric'
            //
        ];
    }
}
