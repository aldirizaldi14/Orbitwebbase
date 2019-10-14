<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Allocationdet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocationdet', function (Blueprint $table) {
            $table->increments('allocationdet_id');
            $table->string('allocationdet_code');
            $table->integer('allocationdet_allocation_id');
            $table->integer('allocationdet_area_id');
            $table->integer('allocationdet_qty');
            $table->timestamp('allocationdet_created_at');
            $table->string('allocationdet_created_by');
            $table->timestamp('allocationdet_updated_at')->nullable();
            $table->string('allocationdet_updated_by')->nullable();
            $table->timestamp('allocationdet_deleted_at')->nullable();
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
        Schema::dropIfExists('allocationdet');
    }
}
