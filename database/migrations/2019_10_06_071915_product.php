<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_code')->unique();
            $table->string('product_description');
            $table->timestamp('product_created_at');
            $table->string('product_created_by');
            $table->timestamp('product_updated_at')->nullable();
            $table->string('product_updated_by')->nullable();
            $table->timestamp('product_deleted_at')->nullable();
            $table->timestamps = false;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
