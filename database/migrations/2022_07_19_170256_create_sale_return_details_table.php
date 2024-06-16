<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return_details', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('return_type')->nullable()->comment('1=return,2=exchange_return');
            $table->unsignedBigInteger('sale_return_id')->nullable()->index();
            $table->foreignId("sale_id")->index()->nullable()->constrained("sales")->onDelete("cascade");
            $table->foreignId('user_id')->nullable()->index()->constrained('users', 'id')->onDelete('set null');
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->foreignId("branch_id")->index()->nullable()->constrained("branches")->onDelete("cascade");
            $table->foreignId("supplier_id")->nullable()->index()->constrained("suppliers")->onDelete("cascade");
            $table->foreignId("product_id")->nullable()->index()->constrained("products")->onDelete("cascade");
            $table->string('product_sku')->nullable()->index();
            $table->string('product_barcode')->nullable()->index();
            $table->float('vat_total', 11, 2)->default(0.00);
            $table->float('discount_total', 11, 2)->default(0.00);
            $table->float('flat_discount_total', 11, 2)->default(0.00);
            $table->float('buy_rate', 11, 2)->default(0.00);
            $table->float('sale_rate', 11, 2)->default(0.00);
            $table->float('quantity', 11, 2)->default(0.00);
            $table->float('product_total', 11, 2)->default(0.00);
            $table->float('net_total', 11, 2)->default(0.00);

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
        Schema::dropIfExists('sale_return_details');
    }
};
