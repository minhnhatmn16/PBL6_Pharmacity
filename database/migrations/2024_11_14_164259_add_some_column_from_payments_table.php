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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->unsignedInteger('order_id')->after('payment_id');
            $table->unsignedInteger('payment_method_id')->after('payment_id');
            $table->decimal('payment_amount',15,2)->after('payment_method_id');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending')->after('payment_amount');
            $table->timestamp('payment_at')->nullable()->after('payment_status');
            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method');
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
            $table->dropColumn('payment_method_id');
            $table->dropColumn('payment_amount');
            $table->dropColumn('payment_status');
            $table->dropColumn('payment_description');
            $table->dropColumn('payment_tracking_number');
            $table->dropColumn('payment_shipped_at');
        });
    }
};
