<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_detalle_ventas');
            $table->string('cliente');
            $table->date('fecha_entrega');
            $table->string('lugar_entrega');
            $table->time('hora_entrega');
            $table->string('status');
            $table->decimal('importe_pagado',5,2);
            $table->decimal('importe_total',5,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
