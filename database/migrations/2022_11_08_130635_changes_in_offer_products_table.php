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
        Schema::table('offer_products', function (Blueprint $table) {
            $table->renameColumn('discount_price', 'discount_amount');
            $table->unsignedBigInteger('supplier_id')->nullable()->after('offer_id');
            $table->integer('supplier_discount_amount')->nullable()->after('supplier_id');
            $table->integer('management_discount_amount')->nullable()->after('supplier_discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('offer_products', function (Blueprint $table) {
            $table->renameColumn('discount_amount', 'discount_price');
            $table->dropColumn('supplier_id');
            $table->dropColumn('supplier_discount_amount');
            $table->dropColumn('management_discount_amount');
        });
    }
};
