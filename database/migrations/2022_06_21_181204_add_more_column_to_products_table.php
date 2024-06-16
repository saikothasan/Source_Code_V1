<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longText('description')->change();
            $table->string('product_slug')->nullable()->after('name');
            $table->string('product_sku')->nullable()->after('product_code');
            $table->unsignedBigInteger('brand_id')->nullable()->after('product_sku');
            $table->unsignedBigInteger('supplier_id')->nullable()->nullable()->after('brand_id');
            $table->boolean('product_options')->default(false)->after('supplier_id');
            $table->double('product_margin')->default(00.0)->after('sell_price');
            $table->double('product_profit')->default(00.0)->after('product_margin');
            $table->string('discount_type')->nullable()->comment('1=percentage,2=fixed')->after('product_profit');
            $table->double('discount_percentage')->default(00.0)->after('discount_type');
            $table->double('discount_amount')->default(00.0)->after('discount_percentage');
            $table->boolean('is_draft')->default(false)->after('short_list');
            $table->boolean('is_active')->default(true)->after('is_draft');
            $table->unsignedBigInteger('created_by')->nullable()->after('short_list');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'product_sku',
                'brand_id',
                'supplier_id',
                'product_options',
                'product_margin',
                'product_profit',
                'discount_type',
                'discount_percentage',
                'discount_amount',
                'is_draft',
                'is_active',
                'created_by',
                'updated_by'
            ]);
        });
    }
}
