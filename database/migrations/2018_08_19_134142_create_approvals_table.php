<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assoc_id');
            $table->foreign('assoc_id')->references('id')->on('documents');
            $table->unsignedInteger('by');
            $table->foreign('by')->references('id')->on('users');
            $table->enum('approved',[true,false]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.  
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}
