<?php

namespace TamaleFiesta\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestGuardaUsuario extends FormRequest
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
            'name'=> 'required|max:50|min:3',
            'nombre_s'=> 'required|max:50|min:3',
            'apellido_s'=> 'required|max:50|min:3',
            'domicilio'=> 'required|max:80|min:5',
            'telefono'=> 'required|max:20|min:8',
            'email'=>'required|max:50|min:3',
            'tipo_usuario'=>'required|numeric',
            'gerente'=>'numeric',
            'supervisor'=>'numeric',
            'vendedor'=>'numeric',
            'operativo'=>'numeric',
            'activo'=>'max:5',
            'foto'=> 'image|max:2048|min:5'
            //
        ];
    }
}
