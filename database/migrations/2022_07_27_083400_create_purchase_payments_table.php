<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('from_date');
            $table->date('to_date');
            $table->json('purchase_invoice')->nullable();
            $table->string('receipt_no')->unique()->nullable();
            $table->json('purchase_id')->nullable();
            $table->double('total_buy_price')->default(0.0);
            $table->double('total_advance')->default(0.0);
            $table->double('total_pay')->default(0.0);
            $table->double('total_due')->default(0.0);
            $table->double('total_payable')->default(0.0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('payment_number')->nullable();
            $table->string('payment_reference')->nullable();

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
        Schema::dropIfExists('purchase_payments');
    }
}
