<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transferdet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferdet', function (Blueprint $table) {
            $table->increments('transferdet_id');
            $table->string('transferdet_code');
            $table->integer('transferdet_transfer_id');
            $table->integer('transferdet_product_id');
            $table->integer('transferdet_qty');
            $table->timestamp('transferdet_created_at');
            $table->string('transferdet_created_by');
            $table->timestamp('transferdet_updated_at')->nullable();
            $table->string('transferdet_updated_by')->nullable();
            $table->timestamp('transferdet_deleted_at')->nullable();
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
        Schema::dropIfExists('transferdet');
    }
}
