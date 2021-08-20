<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConciliacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conciliaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_cita');                        
            $table->string('hora_inicio');            
            $table->integer('estado_id')->unsigned(); // 
            $table->foreign('estado_id')->references('id')->on('referencias_tablas'); //Tipo de asistencia: asistencia, permiso, reposicion 
            $table->integer('categoria_id')->unsigned(); // 
            $table->foreign('categoria_id')->references('id')->on('referencias_tablas'); //Tipo de asistencia: asistencia, permiso, reposicion 
            $table->timestamps();
        });

        Schema::create('conciliacion_has_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_usuario_id')->unsigned(); // 
            $table->foreign('tipo_usuario_id')->references('id')->on('referencias_tablas'); //Tipo de asistencia: asistencia, permiso, reposicion 
            $table->integer('conciliacion_id')->unsigned(); // 
            $table->foreign('conciliacion_id')->references('id')->on('conciliaciones'); //Tipo de asistencia: asistencia, permiso, reposicion 
            $table->integer('user_id')->unsigned(); // 
            $table->foreign('user_id')->references('id')->on('users'); //Tipo de asistencia: asistencia, permiso, reposicion 
            $table->timestamps();
        });

        
        Schema::create('conciliacion_has_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concepto');
            $table->integer('conciliacion_id')->unsigned();
            $table->foreign('conciliacion_id')->references('id')->on('conciliaciones')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('type_status_id')->unsigned();
            $table->foreign('type_status_id')->references('id')->on('referencias_tablas')
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
        Schema::dropIfExists('conciliaciones');
    }
}
