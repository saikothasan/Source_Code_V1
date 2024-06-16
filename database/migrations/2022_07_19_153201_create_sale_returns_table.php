<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('return_type')->nullable()->comment('1=return,2=exchange_return');
            $table->string('return_date', 10);
            $table->foreignId("sale_id")->index()->nullable()->constrained("sales")->onDelete("cascade");
            $table->foreignId('user_id')->nullable()->index()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId("branch_id")->index()->nullable()->constrained("branches")->onDelete("cascade");
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->float('vat_percentage', 10, 2)->default(0.00);
            $table->float('vat_amount', 10, 2)->default(0.00);
            $table->float('discount_percentage', 10, 2)->default(0.00);
            $table->float('discount_amount', 10, 2)->default(0.00);
            $table->float('flat_discount', 10, 2)->default(0.00);
            $table->float('return_total', 10, 2)->default(0.00);
            $table->float('return_amount', 10, 2)->default(0.00);
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
        Schema::dropIfExists('sale_returns');
    }
}
