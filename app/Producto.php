<?php

namespace TamaleFiesta;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    protected $fillable =['nombre','descripcion','precio','existencias','id_categoria','imagen','activo'];
}
