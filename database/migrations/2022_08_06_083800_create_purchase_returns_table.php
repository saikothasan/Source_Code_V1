<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('purchase_id')->nullable()->index();
            $table->double('total_quantity')->default(00.0);
            $table->double('total_amount')->default(00.0);
            $table->unsignedBigInteger('supplier_id')->nullable()->index();
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->index()->constrained('users', 'id')->onDelete('set null');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('purchase_returns');
    }
}
