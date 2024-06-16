<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommercesliders', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('url')->nullable();
            $table->text('bannertype');
            $table->text('resourcetype');
            $table->integer('resource_id');
            $table->text('category');
            $table->text('img');
            $table->string('status');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onDelete('set null');
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
        Schema::dropIfExists('ecommercesliders');
    }
};