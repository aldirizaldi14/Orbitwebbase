<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Receipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt', function (Blueprint $table) {
            $table->increments('receipt_id');
            $table->string('receipt_code');
            $table->integer('receipt_transfer_id');
            $table->integer('receipt_user_id');
            $table->integer('receipt_status');
            $table->timestamp('receipt_time');
            $table->timestamp('receipt_created_at');
            $table->string('receipt_created_by');
            $table->timestamp('receipt_updated_at');
            $table->string('receipt_updated_by');
            $table->timestamp('receipt_deleted_at');
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
        Schema::dropIfExists('receipt');
    }
}
