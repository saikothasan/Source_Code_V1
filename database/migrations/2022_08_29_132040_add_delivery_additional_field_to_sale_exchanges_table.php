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
        Schema::table('sale_exchanges', function (Blueprint $table) {
            $table->after('delivery_charge', function ($table) {
                $table->float('additional_delivery_charge', 11, 2)->default(0.00);
                $table->float('additional_charge', 11, 2)->default(0.00);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_exchanges', function (Blueprint $table) {
            $table->dropColumn(['additional_delivery_charge', 'additional_charge']);
        });
    }
};
