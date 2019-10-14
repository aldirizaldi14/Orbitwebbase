<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Allocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocation', function (Blueprint $table) {
            $table->increments('allocation_id');
            $table->string('allocation_code');
            $table->integer('allocation_product_id');
            $table->integer('allocation_user_id');
            $table->timestamp('allocation_time');
            $table->timestamp('allocation_created_at');
            $table->string('allocation_created_by');
            $table->timestamp('allocation_updated_at')->nullable();
            $table->string('allocation_updated_by')->nullable();
            $table->timestamp('allocation_deleted_at')->nullable();
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
        Schema::dropIfExists('allocation');
    }
}
