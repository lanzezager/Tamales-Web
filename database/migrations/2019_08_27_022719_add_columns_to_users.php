<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->string('nombre_s');
             $table->string('apellido_s');
             $table->string('domicilio');
             $table->string('telefono');
             $table->string('foto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nombre_s');
            $table->dropColumn('apellido_s');
            $table->dropColumn('domicilio');
            $table->dropColumn('telefono');
            $table->dropColumn('foto');
        });
    }
}
