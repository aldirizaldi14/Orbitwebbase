<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Delivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery', function (Blueprint $table) {
            $table->increments('delivery_id');
            $table->string('delivery_code');
            $table->timestamp('delivery_time');
            $table->string('delivery_expedition');
            $table->string('delivery_destination');
            $table->string('delivery_city');
            $table->integer('delivery_user_id');
            $table->timestamp('delivery_created_at');
            $table->string('delivery_created_by');
            $table->timestamp('delivery_updated_at')->nullable();
            $table->string('delivery_updated_by')->nullable();
            $table->timestamp('delivery_deleted_at')->nullable();
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
        Schema::dropIfExists('delivery');
    }
}
