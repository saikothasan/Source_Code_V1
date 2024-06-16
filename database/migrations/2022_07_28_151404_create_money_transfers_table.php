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
        Schema::create('money_transfers', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId("payment_method_id")->index()->nullable()->constrained("payment_methods");
            $table->foreignId("current_branch_id")->index()->nullable()->constrained("branches")->onDelete("cascade");
            $table->foreignId("receiver_branch_id")->index()->nullable()->constrained("branches")->onDelete("cascade");
            $table->string('receive_type')->nullable();
            $table->unsignedBigInteger("cash_drawer_id")->index()->nullable();
            $table->unsignedBigInteger("bank_id")->index()->nullable();
            $table->unsignedBigInteger("bank_account_no")->index()->nullable();
            $table->float('available_amount', 11, 2)->default(0.00);
            $table->float('transfer_amount', 11, 2)->default(0.00);
            $table->float('remaining_amount', 11, 2)->default(0.00);
            $table->tinyInteger('status')->default(false)->comment('0=Transfer,1=Receive,2=Reject');
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
        Schema::dropIfExists('money_transfers');
    }
};
