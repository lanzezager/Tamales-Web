<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnInDetalleRecibos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_recibos', function (Blueprint $table) {
            $table->integer('cantidad_virtual');
            $table->renameColumn('cantidad','cantidad_real');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_recibos', function (Blueprint $table) {
           $table->dropColumn('cantidad_virtual');
           $table->renameColumn('cantidad_real','cantidad');
        });
    }
}
