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
        Schema::table('offers', function (Blueprint $table) {
          $table->string('total_combo_price')->nullable()->after('total_discount_price');
          $table->dropColumn('total_available_quantity');
          $table->dropColumn('offer_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('total_discount_price');
            $table->integer('total_available_quantity')->nullable()->after('total_stock_quantity');
            $table->integer('offer_status')->nullable()->after('total_available_quantity');

        });
    }
};
