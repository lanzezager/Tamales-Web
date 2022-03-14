<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumn1ToProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
             $table->string('items_combo');
             $table->date('vig_desde')->nullable($value = '0000-00-00');
             $table->date('vig_hasta')->nullable($value = '0000-00-00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('items_combo');
            $table->dropColumn('vig_desde');
            $table->dropColumn('vig_hasta');
        });
    }
}
