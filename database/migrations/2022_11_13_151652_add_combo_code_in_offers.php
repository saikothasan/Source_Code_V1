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
            $table->string('combo_code')->nullable()->after('combo_product');
            $table->integer('discount_type')->nullable()->after('combo_code')->comment('2 = percentage, 1 = amount');
            $table->integer('discount_amount')->nullable()->after('discount_type');
            $table->float('total_combo_discount')->nullable()->after('discount_amount');
            $table->float('total_combo_price')->nullable()->after('total_combo_discount');
            $table->renameColumn('totalAvailableQuantity', 'total_available_quantity');
            $table->renameColumn('totalPurchaseAmount', 'total_purchase_amount');
            $table->renameColumn('totalDiscountQuantity', 'total_discount_quantity');
            $table->renameColumn('totalDiscountAmount', 'total_discount_amount');
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
            $table->dropColumn('combo_code');
            $table->dropColumn('discount_type');
            $table->dropColumn('discount_amount');
            $table->dropColumn('total_combo_discount');
            $table->dropColumn('total_combo_price');
            $table->renameColumn('total_available_quantity', 'totalAvailableQuantity');
            $table->renameColumn('total_purchase_amount', 'totalPurchaseAmount');
            $table->renameColumn('total_discount_quantity', 'totalDiscountQuantity');
            $table->renameColumn('total_discount_amount', 'totalDiscountAmount');
        });
    }
};
