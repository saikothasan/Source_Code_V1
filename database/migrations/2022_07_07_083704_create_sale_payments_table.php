<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->date('date');
            $table->foreignId("sale_id")->index()->nullable()->constrained("sales")->onDelete("cascade");
            $table->unsignedBigInteger('sale_exchange_id')->nullable()->index();
            $table->float('payable_amount', 11, 2)->default(0.00);
            $table->float('paid', 11, 2)->default(0.00);
            $table->float('due', 11, 2)->default(0.00);
            $table->float('change_amount', 11, 2)->default(0.00);
            $table->foreignId('user_id')->nullable()->index()->constrained('users', 'id')->onDelete('set null');
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->json('payments')->nullable();
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
        Schema::dropIfExists('sale_payments');
    }
}
