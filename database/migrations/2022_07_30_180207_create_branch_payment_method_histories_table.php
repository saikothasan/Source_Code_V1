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
        Schema::create('branch_payment_method_histories', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('invoice_reference')->nullable();
            $table->foreignId("sale_id")->index()->nullable()->constrained("sales")->onDelete("cascade");
            $table->unsignedBigInteger('sale_exchange_id')->nullable()->index();
            $table->foreignId("branch_id")->index()->nullable()->constrained("branches")->onDelete("cascade");
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('payment_number')->nullable();
            $table->string('payment_reference')->nullable();
            $table->float('pay_amount', 10, 2)->default(0.00);
            $table->float('payable_amount', 10, 2)->default(0.00);
            $table->float('return_amount', 11, 2)->default(0.00);

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
        Schema::dropIfExists('branch_payment_method_histories');
    }
};
