<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_days', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedSmallInteger('day');
            $table->boolean('active');

            $table->time('morning_start');
            $table->time('morning_end');

            $table->time('afternoon_start');
            $table->time('afternoon_end');

            // LLAVE FORANEA
            // definimos la columna de tipo entero sin signo y le asignamos un nombre
            $table->unsignedInteger('user_id');
            // establecemos una relación foranea respecto a la columna anterior, que haga referencia al campo id de la tabla de Users
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('work_days');
    }
}
