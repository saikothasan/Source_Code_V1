<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->date('date')->nullable();
            $table->tinyInteger('sale_type')->default(1);
            $table->string('invoice_code')->unique()->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('seller_id')->nullable();
            $table->json('suppliers_id')->nullable();
            $table->foreignId("branch_id")->index()->nullable()->constrained("branches")->onDelete("cascade");
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->float('vat_percentage', 11, 2)->default(0.00);
            $table->float('vat_amount', 11, 2)->default(0.00);
            $table->float('discount_percentage', 11, 2)->default(0.00);
            $table->float('discount_amount', 11, 2)->default(0.00);
            $table->float('flat_discount', 11, 2)->default(0.00);
            $table->float('delivery_charge', 11, 2)->default(0.00);
            $table->float('change_amount', 11, 2)->default(0.00);
            $table->float('net_total', 11, 2)->default(0.00);
            $table->float('final_total', 11, 2)->default(0.00);
            $table->float('payable_amount', 11, 2)->default(0.00);
            $table->float('pay_amount', 11, 2)->default(0.00);
            $table->float('due_total', 11, 2)->default(0.00);
            $table->float('return_total', 11, 2)->default(0.00);
            $table->float('exchange_total', 11, 2)->default(0.00);
            $table->longText('customer_address')->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sales');
        Schema::enableForeignKeyConstraints();
    }
}
