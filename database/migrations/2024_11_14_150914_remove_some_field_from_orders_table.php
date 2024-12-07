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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropForeign(['delivery_id']);
            $table->dropColumn('payment_id');
            $table->dropColumn('delivery_id');
            $table->dropColumn('order_status');
            $table->dropColumn('payment_status');
            $table->dropColumn('delivery_tracking_number');
            $table->dropColumn('delivery_shipped_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('payment_id');
            $table->unsignedInteger('delivery_id');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('delivery_tracking_number')->nullable();
            $table->timestamp('delivery_shipped_at')->nullable();
            $table->foreign('payment_id')->references('payment_id')->on('payments');
            $table->foreign('delivery_id')->references('delivery_id')->on('deliveries');
        });
    }
};
