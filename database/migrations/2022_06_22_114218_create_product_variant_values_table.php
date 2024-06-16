<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_variant_values', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->bigInteger('product_variant_sku_id');
            $table->bigInteger('option_id');
            $table->bigInteger('variant_value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variant_values');
    }
};
