<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('date');
            $table->string('invoice', 50);
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->double('vat_percentage')->default(00.0);
            $table->double('vat')->default(00.0);
            $table->string('extra_cost_name', 255)->nullable();
            $table->double('extra_cost')->default(00.0);
            $table->double('discount_percentage')->default(00.0);
            $table->double('discount')->default(00.0);
            $table->double('total_quantity')->default(00.0);
            $table->double('subtotal')->default(00.0);
            $table->double('total')->default(00.0);
            $table->mediumText('note')->nullable();
            $table->string('send_by')->nullable();
            $table->bigInteger('receive_by')->nullable();
            $table->unsignedBigInteger('main_branch')->nullable();

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
        Schema::dropIfExists('purchases');
    }
}
