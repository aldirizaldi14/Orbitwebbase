<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AreaProductQty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_product_qty', function (Blueprint $table) {
            $table->integer('warehouse_id');
            $table->integer('area_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->timestamp('receiptdet_created_at');
            $table->string('receiptdet_created_by');
            $table->timestamp('receiptdet_updated_at');
            $table->string('receiptdet_updated_by');
            $table->timestamp('receiptdet_deleted_at');
            $table->primary(['warehouse_id', 'area_id', 'product_id']);
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
        Schema::dropIfExists('area_product_qty');
    }
}
