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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_fullname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('user_phone')->nullable();
            $table->date('user_birthday')->nullable();
            $table->boolean('user_gender')->default(1); //1 là male, 0 là female
            $table->string('user_avatar')->nullable();
            $table->decimal('user_weight', 8, 2)->nullable();
            $table->decimal('user_height', 8, 2)->nullable();
            $table->decimal('user_ibm', 8, 2)->nullable();
            $table->boolean('user_is_block')->default(0); //0 là active, 1 là block
            $table->boolean('user_is_delete')->default(0); //0 là active, 1 là delete
            $table->string('token_verify_email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamp('user_created_at')->nullable();
            $table->timestamp('user_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
