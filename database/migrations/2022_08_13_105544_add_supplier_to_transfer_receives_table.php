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
        Schema::table('transfer_receives', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')
                ->comment('when supplier transfer')
                ->nullable()
                ->index()
                ->after('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfer_receives', function (Blueprint $table) {
            $table->dropColumn(['supplier_id']);
        });
    }
};
