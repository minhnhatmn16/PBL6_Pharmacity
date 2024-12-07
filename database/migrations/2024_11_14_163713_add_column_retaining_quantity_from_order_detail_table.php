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
        Schema::table('import_details', function (Blueprint $table) {
            $table->integer('retaining_quantity')->after('import_quantity')->default(0);
            $table->date('entry_date')->after('product_expiry_date')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_details', function (Blueprint $table) {
            $table->dropColumn('retaining_quantity');
            $table->dropColumn('entry_date');
        });
    }
};
