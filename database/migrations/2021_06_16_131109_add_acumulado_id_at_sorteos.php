<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcumuladoIdAtSorteos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sorteos', function(Blueprint $table){
            $table->bigInteger('acumulado_id')
            ->unsigned()
            ->nullable()
            ->after('id');

            $table->foreign('acumulado_id')
            ->references('id')
            ->on('acumulado')
            ->onDelete('set null')
            ->onUpdate('cascade');

            /* GUIA PARA EJEMPLO
                 Schema::table('sorteos', function (Blueprint $table){
            $table->bigInteger('premio_id')
            ->unsigned()
            ->nullable()
            ->after('id');

            $table->foreign('premio_id')->references('id')->on('premios')
            ->onDelete('set null')
            ->onUpdate('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
