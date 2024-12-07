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
        Schema::create('products', function (Blueprint $table) {
            // $table->id();
            $table->increments('product_id');
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('category_id');
            $table->string('product_name')->index();
            $table->decimal('product_price', 15, 2);
            $table->decimal('product_discount', 15, 2)->nullable();
            $table->json('product_images')->nullable();
            $table->integer('product_quantity')->default(0);//add product quantity=0, import vào thì quantity tăng lên, bán thì quantity - số lượng bán
            $table->integer('product_sold')->default(0);//product_sold = product_sold + quantity bán
            $table->string('product_package')->nullable();
            $table->string('product_ingredients')->nullable();
            $table->string('dosage_form')->nullable();
            $table->string('product_uses')->nullable();
            $table->string('specification')->nullable();
            $table->string('product_notes')->nullable();
            $table->string('place_of_manufacture')->nullable();
            $table->string('manufacturer')->nullable();
            $table->longText('product_description')->nullable();
            $table->boolean('product_is_delete')->default(0);
            $table->timestamp('product_created_at')->nullable();
            $table->timestamp('product_updated_at')->nullable();
            $table->foreign('brand_id')->references('brand_id')->on('brands');
            $table->foreign('category_id')->references('category_id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
