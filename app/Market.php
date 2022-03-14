<?php

namespace TamaleFiesta;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    //
    protected $fillable =['nombre','direccion','telefono','ubicacion','id_encargado','id_supervisor'];
}
