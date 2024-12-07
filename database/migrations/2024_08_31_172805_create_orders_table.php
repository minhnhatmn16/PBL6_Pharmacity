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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('receiver_address_id');
            $table->decimal('order_total_amount',15,2);
            $table->decimal('order_discount_amount',15,2)->default(0);
            $table->enum('order_status',['pending','confirmed','shipped','delivered','cancelled'])->default('pending');
            $table->string('order_note')->nullable();
            $table->timestamp('order_created_at')->nullable();
            $table->timestamp('order_updated_at')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('receiver_address_id')->references('receiver_address_id')->on('receiver_addresses');
            $table->foreign('payment_id')->references('payment_id')->on('payments');
            $table->foreign('delivery_id')->references('delivery_id')->on('deliveries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
