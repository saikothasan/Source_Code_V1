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
        Schema::table('users', function (Blueprint $table) {

            $table->date('date')->nullable();

            $table->date('date_of_birth')->nullable();

            $table->string('id_card_number')->nullable();

            $table->longText('note')->nullable();

            $table->bigInteger('branch_id')->nullable();

            $table->boolean('is_main_branch')->default(false);

            $table->bigInteger('section_id')->nullable();

            $table->bigInteger('designation_id')->nullable();

            $table->tinyInteger('status')->nullable();

            $table->string('otp')->nullable();

            $table->string('previous_company')->nullable();

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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn([
                'date',
                'date_of_birth',
                'id_card_number',
                'note',
                'branch_id',
                'is_main_branch',
                'section_id',
                'designation_id',
                'status',
                'otp',
                'previous_company',
                'created_by',
                'updated_by',
            ]);
        });
    }
};
