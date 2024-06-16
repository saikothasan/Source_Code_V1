<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_deliveries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId("sale_id")->index()->nullable()
                ->constrained("sales")
                ->onDelete("cascade");
            $table->unsignedBigInteger('sale_exchange_id')->nullable()->index();
            $table->json('details')->nullable();
            $table->string('consignment_id')->unique()->nullable();
            $table->string('merchant_order_id')->nullable();
            $table->foreignId("branch_id")->index()->nullable()->constrained("branches")->onDelete("cascade");
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('delivery_id')->nullable()->index();
            $table->float('delivery_charge', 10, 2)->default(0.00);
            $table->float('amount_to_collect', 10, 2)->default(0.00);
            $table->tinyInteger('order_status')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('comments')->nullable();

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
        Schema::dropIfExists('sale_deliveries');
    }
};
