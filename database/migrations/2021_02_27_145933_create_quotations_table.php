<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date', 10);
            $table->string('company');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->mediumText('address')->nullable();
            $table->integer('subtotal');
            $table->integer('vat_percentage')->nullable();
            $table->float('vat', 11, 2)->nullable();
            $table->float('discount', 11, 2)->nullable();
            $table->float('total', 11, 2);
            $table->mediumText('note')->nullable();
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
        Schema::dropIfExists('quotations');
    }
}
