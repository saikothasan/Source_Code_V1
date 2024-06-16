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
        Schema::table('offer_products', function (Blueprint $table) {
            $table->float('supplier_discount_amount',8, 2)->nullable()->change();;
            $table->float('management_discount_amount',8, 2)->nullable()->change();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_products', function (Blueprint $table) {
            $table->integer('supplier_discount_amount')->nullable();
            $table->integer('management_discount_amount',)->nullable();
        });
    }
};
