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
        Schema::create('sale_return_purchase_histories', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('return_type')->nullable()->comment('1=return,2=exchange_return');
            $table->bigInteger('purchase_id')->unsigned()->nullable()->index();
            $table->bigInteger('product_id')->unsigned()->nullable()->index();
            $table->string('product_sku')->nullable()->nullable()->index();
            $table->string('product_barcode')->nullable()->index();
            $table->unsignedBigInteger('supplier_id')->nullable()->index();
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('sale_id')->nullable()->index();
            $table->unsignedBigInteger('sale_detail_id')->nullable()->index();
            $table->float('quantity', 11, 2)->default(0.00);
            $table->float('buy_rate', 11, 2)->default(0.00);
            $table->float('sale_rate', 11, 2)->default(0.00);
            $table->float('buy_total', 11, 2)->default(0.00);
            $table->float('sale_total', 11, 2)->default(0.00);

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
        Schema::dropIfExists('sale_return_purchase_histories');
    }
};
