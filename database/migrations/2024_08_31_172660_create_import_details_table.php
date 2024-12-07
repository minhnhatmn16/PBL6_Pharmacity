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
        Schema::create('import_details', function (Blueprint $table) {
            $table->increments('import_detail_id');
            $table->unsignedInteger('import_id');
            $table->unsignedInteger('product_id');
            $table->integer('import_quantity')->default(0);
            $table->decimal('import_price', 15, 2);
            $table->decimal('product_total_price',15,2);//product_total_price = import_quantity * import_price
            $table->date('product_expiry_date');
            $table->foreign('import_id')->references('import_id')->on('imports');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_details');
    }
};
