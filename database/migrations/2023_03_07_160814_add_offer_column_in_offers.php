<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->string('invoice')->nullable()->after('slug');
            $table->dropColumn('total_combo_discount');
            $table->dropColumn('total_combo_price');
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
            $table->dropColumn('slug');
            $table->dropColumn('invoice');
            $table->dropColumn('combo_code');
            $table->double('total_combo_discount')->nullable()->after('total_discount_price');
            $table->double('total_combo_price')->nullable()->after('total_combo_discount');
        });
    }
};
