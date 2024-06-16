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
        Schema::create('transfer_receives', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->tinyInteger('invoice_type')->default(1)->comment('1=transfer,2=receive');
            $table->string('invoice_code', 50);
            $table->bigInteger('user_id')->nullable();
            $table->double('total_quantity')->default(00.0);
            $table->double('subtotal')->default(00.0);
            $table->double('total')->default(00.0);
            $table->mediumText('note')->nullable();
            $table->string('transfer_branch')->nullable();
            $table->string('receive_branch')->nullable();
            $table->bigInteger('receive_by')->nullable();
            $table->unsignedBigInteger('main_branch')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0=Transferring,Receiving,1==Transfer,Received,2=Reject');

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
        Schema::dropIfExists('transfer_receives');
    }
};
