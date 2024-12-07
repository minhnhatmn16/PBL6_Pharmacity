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
        Schema::create('receiver_addresses', function (Blueprint $table) {
            $table->increments('receiver_address_id');
            $table->unsignedInteger('user_id');
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_address')->nullable();
            $table->timestamp('receiver_created_at')->nullable();
            $table->timestamp('receiver_updated_at')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
             // $table->foreignId('user_id')->constrained('users');-->đúng nếu để khoá chính mặc định là id
             // $table->integer('user_id')->unsigned();//c2
            // $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receiver_addresses');
    }
};
