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
        Schema::create('banks_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('type');
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId('receiver_bank_id')->nullable()->constrained('banks', 'id')->onDelete('set null');
            $table->foreignId('sender_bank_id')->nullable()->constrained('banks', 'id')->onDelete('set null');
            $table->float('paid', 11, 0)->nullable();
            $table->float('due', 11, 0)->nullable();
            $table->string('reference_id');
            $table->string('connect_id')->nullable();
            $table->string('referance_invoice');
            $table->tinyInteger('status')->comment('0=Pending,1=Received,2=Reject')->default(0);
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
        Schema::dropIfExists('banks_transfers');
    }
};
