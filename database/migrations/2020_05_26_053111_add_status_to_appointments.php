<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToAppointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // en esta función agregamos el campo o la columna que se quiere agregar a la migración appointment.
        Schema::table('appointments', function (Blueprint $table) {
            // reservada, Confirmada, Atendida, Cancelada
            $table->string('status')->default('Reservada');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // reservada, Confirmada, Atendida, Cancelada
            $table->dropColumn('status');     
        });
    }
}
