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
        Schema::create('cash_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable()->index();
            $table->unsignedBigInteger('sale_exchange_id')->nullable()->index();
            $table->unsignedBigInteger('cash_id')->nullable()->index();
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->tinyInteger('cash_type')->comment('0=Cash In,1=Payment,2=Transfer')->nullable();
            $table->tinyInteger('status')->comment('0=Transferring,0=Receiving,1=Transfer,1=Receive,2=Reject')->nullable();
            $table->string('note')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable()->index();
            $table->unsignedBigInteger('supplier_id')->nullable()->index();
            $table->unsignedBigInteger('sender_id')->nullable()->index();
            $table->unsignedBigInteger("payment_method_id")->index()->nullable();
            $table->string('payment_reference')->nullable();
            $table->float('amount', 11, 2)->default(0.00);

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
        Schema::dropIfExists('model_cash_histories');
    }
};
