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
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('landmark')->nullable();
            $table->string('division_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('thana_id')->nullable();
            $table->string('type')->nullable();
            $table->string('address_type')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers', 'id')
            ->onDelete('set null');
            $table->string('zip_code')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()
            ->constrained('users', 'id')
            ->onDelete('set null');
        $table->foreignId('updated_by')->nullable()
            ->constrained('users', 'id')
            ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_addresses');
    }
};
