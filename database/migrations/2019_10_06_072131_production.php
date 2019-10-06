<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Production extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production', function (Blueprint $table) {
            $table->increments('production_id');
            $table->string('production_code');
            $table->timestamp('production_time');
            $table->integer('production_product_id');
            $table->integer('production_line_id');
            $table->string('production_shift');
            $table->string('production_batch');
            $table->integer('production_qty');
            $table->integer('production_user_id');
            $table->timestamp('production_created_at');
            $table->string('production_created_by');
            $table->timestamp('production_updated_at');
            $table->string('production_updated_by');
            $table->timestamp('production_deleted_at');
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
        Schema::dropIfExists('production');
    }
}
