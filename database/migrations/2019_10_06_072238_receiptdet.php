<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Receiptdet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiptdet', function (Blueprint $table) {
            $table->increments('receiptdet_id');
            $table->string('receiptdet_code');
            $table->integer('receiptdet_receipt_id');
            $table->integer('receiptdet_transferdet_id');
            $table->integer('receiptdet_product_id');
            $table->integer('receiptdet_qty');
            $table->string('receiptdet_note');
            $table->timestamp('receiptdet_created_at');
            $table->string('receiptdet_created_by');
            $table->timestamp('receiptdet_updated_at');
            $table->string('receiptdet_updated_by');
            $table->timestamp('receiptdet_deleted_at');
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
        Schema::dropIfExists('user');
    }
}
