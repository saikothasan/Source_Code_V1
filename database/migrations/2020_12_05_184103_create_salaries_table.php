<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('month_id');
            $table->date('date')->format('Y-m-d');
            $table->bigInteger('employee_id');
            $table->bigInteger('department_id');
            $table->integer('late')->nullable();
            $table->integer('leave_days')->nullable();
            $table->integer('absent')->nullable();
            $table->integer('present');
            $table->integer('late_fine')->nullable();
            $table->string('note', 255)->nullable();
            $table->integer('amount');
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
        Schema::dropIfExists('salaries');
    }
}
