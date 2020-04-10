<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion');
            $table->string('codigo_barras');
            $table->string('marca');
            $table->string('id_categoria')->nullable();
            $table->string('id_iva')->nullable();
            $table->string('precio_cj_dp');
            $table->string('precio_und');
            $table->string('precio_venta');
            $table->string('utilidad');
            $table->string('cantidad_maxima');
            $table->string('cantidad_actual');
            $table->string('imagen');
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
        Schema::dropIfExists('products');
    }
}
