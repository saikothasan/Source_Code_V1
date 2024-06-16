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
        Schema::create('purchase_payment_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_payments_id')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->string('purchase_invoice')->nullable();
            $table->double('total_pay')->default(0.0);
            $table->double('total_due')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_payment_invoices');
    }
};
