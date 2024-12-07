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
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('category_name')->unique()->index();
            $table->string('category_thumbnail')->nullable();
            $table->unsignedInteger('category_parent_id')->nullable();
            $table->string('category_type')->nullable();
            $table->string('category_description')->nullable();
            $table->boolean('category_is_delete')->default(0);
            $table->timestamp('category_created_at')->nullable();
            $table->timestamp('category_updated_at')->nullable();
            $table->foreign('category_parent_id')->references('category_id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
