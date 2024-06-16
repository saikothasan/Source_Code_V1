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
            $table->string('totalAvailableQuantity')->nullable()->after('end_date');
            $table->string('totalAvailableAmount')->nullable()->after('totalAvailableQuantity');
            $table->integer('totalDiscountQuantity')->nullable()->after('totalAvailableAmount');
            $table->integer('totalDiscountAmount')->nullable()->after('totalDiscountQuantity');
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
            $table->dropColumn('totalAvailableQuantity');
            $table->dropColumn('totalAvailableAmount');
            $table->dropColumn('totalDiscountQuantity');
            $table->dropColumn('totalDiscountAmount');
        });
    }
};
