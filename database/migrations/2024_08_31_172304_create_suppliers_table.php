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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('supplier_id');
            $table->string('supplier_name')->unique()->index();
            $table->string('contact_person')->nullable();
            $table->string('supplier_phone')->nullable();
            $table->string('supplier_email')->unique();
            $table->string('supplier_address')->nullable();
            $table->boolean('supplier_is_delete')->default(0);
            $table->timestamp('supplier_created_at')->nullable();
            $table->timestamp('supplier_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
