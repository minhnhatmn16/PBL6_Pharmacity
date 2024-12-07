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
        Schema::create('category_diseases',function (Blueprint $table) {
                $table->increments('category_disease_id');
                $table->unsignedInteger('category_id');
                $table->unsignedInteger('disease_id');
                $table->foreign('category_id')->references('category_id')->on('categories');
                $table->foreign('disease_id')->references('disease_id')->on('diseases');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_disease');
    }
};
