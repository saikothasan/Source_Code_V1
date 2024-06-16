<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_returns', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('date', 10);
            $table->bigInteger('sale_id');
            $table->string('invoice', 50);
            $table->bigInteger('product_id')->unsigned();
            $table->integer('quantity');
            $table->float('amount', 11, 2);
            $table->bigInteger('customer_id');
            $table->bigInteger('user_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_returns');
    }
}
