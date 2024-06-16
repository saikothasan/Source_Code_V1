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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->integer('shipping_address_id')->nullable();
            $table->integer('billing_address_id')->nullable();
            $table->string('invoice_code')->unique()->nullable();
            $table->string('payment_status',15)->default('unpaid');
            $table->json("branch_id")->nullable();
            $table->string('order_status',15)->default('pending');
            $table->string('payment_method',15)->nullable();
            $table->float('payment_amount',15)->nullable();
            $table->string('payment_mobile_number',15)->nullable();
            $table->string('transaction_ref',30)->nullable();
            $table->float('sub_total_amount')->default(0.00);
            $table->float('delivery_charge', 11, 2)->default(0.00);
            $table->float('customer_address', 11, 2)->default(0.00);
            $table->string('coupon_code')->nullable();
            $table->float('coupon_discount')->nullable();
            $table->float('discount_total')->nullable();
            $table->float('total_amount')->default(0.00);
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
        Schema::dropIfExists('orders');
    }
};
