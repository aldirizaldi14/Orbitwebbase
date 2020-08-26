<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Deliverydet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverydet', function (Blueprint $table) {
            $table->increments('deliverydet_id');
            $table->string('deliverydet_code');
            $table->integer('deliverydet_delivery_id');
            $table->integer('deliverydet_product_id');
            $table->integer('deliverydet_qty');
            $table->timestamp('deliverydet_created_at');
            $table->string('deliverydet_created_by');
            $table->timestamp('deliverydet_updated_at')->nullable();
            $table->string('deliverydet_updated_by')->nullable();
            $table->timestamp('deliverydet_deleted_at')->nullable();
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
        Schema::dropIfExists('deliverydet');
    }
}
