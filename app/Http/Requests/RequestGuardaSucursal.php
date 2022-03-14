<?php

namespace TamaleFiesta\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestGuardaSucursal extends FormRequest
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
            'nombre'=> 'required|max:30|min:3|unique:markets',
            'domicilio'=> 'required|max:80|min:3',
            'telefono'=> 'required|max:20|min:8',
            'encargado'=> 'required|numeric',
            'supervisor'=> 'required|numeric',
            'ubicacion'=> 'required|max:999|min:50',
            'lista_empleados'=>'max:9999',
            'tipo_usuario'=>'numeric'           
            //
        ];
    }
}
