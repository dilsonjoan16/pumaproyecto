<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasVendedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_vendedor', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('venta_id')->unsigned();
            $table->bigInteger('vendedor_id')->unsigned();

            $table->timestamps();

            $table->foreign('vendedor_id')->references('id')->on('vendedors')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('venta_id')->references('id')->on('ventas')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas_vendedor');
    }
}
