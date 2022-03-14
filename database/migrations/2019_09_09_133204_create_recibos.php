<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecibos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_market');
            $table->integer('id_entrega');
            $table->integer('id_detalle_recibo');
            $table->decimal('monto_recibido',9,2);
            $table->decimal('valor_mercancia',9,2);
            $table->integer('id_supervisor');
            $table->string('observacion');
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
        Schema::dropIfExists('recibos');
    }
}
