<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Warehouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->increments('warehouse_id');
            $table->string('warehouse_name');
            $table->string('warehouse_description');
            $table->timestamp('warehouse_created_at');
            $table->string('warehouse_created_by');
            $table->timestamp('warehouse_updated_at');
            $table->string('warehouse_updated_by');
            $table->timestamp('warehouse_deleted_at');
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
        Schema::dropIfExists('warehouse');
    }
}
