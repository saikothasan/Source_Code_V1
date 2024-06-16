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
        Schema::table('banks_transfers', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('referance_invoice');
            $table->unsignedBigInteger('branch_id')->nullable()->after('payment_method_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banks_transfers', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method_id',
                'branch_id'
            ]);
        });
    }
};
