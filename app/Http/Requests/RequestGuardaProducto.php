<?php

namespace TamaleFiesta\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestGuardaProducto extends FormRequest
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
            'nombre'=> 'required|max:50|min:3',
            'descripcion'=> 'required|max:100|min:5',
            'precio'=> 'required|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'id_categoria'=> 'required|numeric',
            'activo'=>'max:5',
            'imagen'=> 'required|image|max:2048|min:5'
            //
        ];
    }
}
