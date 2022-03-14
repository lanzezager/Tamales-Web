<?php

namespace TamaleFiesta\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestGuardaEntregaInv extends FormRequest
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
            'sucursal'=> 'required|numeric',
            'supervisor'=> 'required|numeric',
            'cambio'=> 'required|numeric',
            'receptor'=>'required|numeric',
            'observacion'=> 'max:255',
            'gran_total'=> 'required|numeric',
            'lista_productos'=>'max:9999'  
            //
        ];
    }
}
