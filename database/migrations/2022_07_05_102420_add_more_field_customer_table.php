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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('district_id')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('facebook_id')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('created_by')->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
            $table->foreignId('updated_by')->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn([
                'district_id',
                'zip_code',
                'password',
                'otp',
                'date_of_birth',
                'facebook_id',
                'status',
                'created_by',
                'updated_by'
            ]);
        });
    }
};
