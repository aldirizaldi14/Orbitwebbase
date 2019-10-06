<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Line extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line', function (Blueprint $table) {
            $table->increments('line_id');
            $table->string('line_name');
            $table->string('line_description');
            $table->timestamp('line_created_at');
            $table->string('line_created_by');
            $table->timestamp('line_updated_at')->nullable();
            $table->string('line_updated_by')->nullable();
            $table->timestamp('line_deleted_at')->nullable();
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
        Schema::dropIfExists('line');
    }
}
