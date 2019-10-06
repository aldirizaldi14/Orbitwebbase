<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Area extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area', function (Blueprint $table) {
            $table->increments('area_id');
            $table->string('area_name');
            $table->string('area_description');
            $table->integer('area_warehouse_id');
            $table->timestamp('area_created_at');
            $table->string('area_created_by');
            $table->timestamp('area_updated_at');
            $table->string('area_updated_by');
            $table->timestamp('area_deleted_at');
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
        Schema::dropIfExists('area');
    }
}
