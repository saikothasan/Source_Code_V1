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
        Schema::table('cash_histories', function (Blueprint $table) {
          $table->unsignedBigInteger('receiver_branch_id')->nullable()->index()->after('current_branch_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_histories', function (Blueprint $table) {
            $table->dropColumn(['receiver_branch_id']);
        });
    }
};
