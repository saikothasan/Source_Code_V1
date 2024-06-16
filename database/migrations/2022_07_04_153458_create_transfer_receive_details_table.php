<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_receive_details', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('invoice_code')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('transfer_receive_from')->unsigned()->nullable();;
            $table->unsignedBigInteger('transfer_invoice_id')->unsigned()->nullable();;
            $table->unsignedBigInteger('product_id')->unsigned();
            $table->string('product_sku')->nullable()->nullable();
            $table->string('product_barcode')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('main_branch')->nullable();
            $table->unsignedBigInteger('transfer_branch')->nullable();
            $table->unsignedBigInteger('current_branch')->nullable();
            $table->integer('quantity');
            $table->integer('rate');
            $table->integer('total');
            $table->foreign('transfer_invoice_id')->references('id')->on('transfer_receives')->onDelete('cascade');
            $table->foreign('transfer_receive_from')->references('id')->on('transfer_receives')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

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
        Schema::dropIfExists('transfer_receive_details');
    }
};
