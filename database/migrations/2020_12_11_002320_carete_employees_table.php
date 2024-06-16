<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CareteEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('department_id')->unsigned();
            $table->string('name', 255);
            $table->string('employee_id', 255);
            $table->string('designation', 255);
            $table->date('join_date')->format('Y-m-d');
            $table->string('reference', 255)->nullable();
            $table->string('phone', 15);
            $table->string('email', 255)->nullable();
            $table->mediumText('address')->nullable();
            $table->string('photo', 255)->nullable();
            $table->integer('salary');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
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
        Schema::dropIfExists('employees');
    }
}
