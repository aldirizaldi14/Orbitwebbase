<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer', function (Blueprint $table) {
            $table->increments('transfer_id');
            $table->string('transfer_code');
            $table->timestamp('transfer_time');
            $table->integer('transfer_user_id');
            $table->timestamp('transfer_created_at');
            $table->string('transfer_created_by');
            $table->timestamp('transfer_updated_at')->nullable();
            $table->string('transfer_updated_by')->nullable();
            $table->timestamp('transfer_deleted_at')->nullable();
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
        Schema::dropIfExists('transfer');
    }
}
