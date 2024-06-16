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
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->string('product_code', 100);
            $table->bigInteger('category_id');
            $table->bigInteger('unit_id');
            $table->string('photo')->nullable();
            $table->mediumText('description')->nullable();
            $table->float('vat', 5, 2)->nullable();
            $table->integer('buy_price');
            $table->integer('sell_price');
            $table->tinyInteger('short_list')->nullable();
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
