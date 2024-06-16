<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_variant_sku_barcodes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->double('variant_buy_price')->default(00.0);
            $table->double('variant_price')->default(00.0);
            $table->string('variant_sku')->nullable();
            $table->string('variant_barcode')->unique()->nullable();
            $table->string('discount_type')->nullable()->comment('1=percentage,2=fixed');
            $table->double('discount_percentage')->default(00.0);
            $table->double('discount_amount')->default(00.0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variant_sku_barcodes');
    }
};
