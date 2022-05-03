<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcHechosPretenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conc_hechos_preten', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->longText('descripcion');  
            $table->integer('conciliacion_id')->unsigned();
            $table->foreign('conciliacion_id')->references('id')->on('conciliaciones')->onDelete('cascade')
            ->onUpdate('cascade');

            $table->integer('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('referencias_tablas')
            ->onDelete('cascade')->onUpdate('cascade');

            
            $table->integer('tipo_id')->unsigned();
            $table->foreign('tipo_id')->references('id')->on('referencias_tablas')
            ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('conc_hechos_preten');
    }
}
