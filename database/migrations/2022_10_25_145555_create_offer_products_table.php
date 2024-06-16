<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->index()->nullable()->constrained('offers')->onDelete('cascade');
            $table->tinyInteger('product_id')->nullable();
            $table->string('product_barcode')->nullable();
            $table->float('discount_price', 11, 2)->default(0.00);
            $table->tinyInteger('quantity')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('created_by')->nullable()
            ->constrained('users', 'id')
            ->onDelete('set null');
            $table->foreignId('updated_by')->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
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
        Schema::dropIfExists('offer_products');
    }
};