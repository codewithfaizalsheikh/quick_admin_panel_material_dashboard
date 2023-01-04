<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_details', function (Blueprint $table) {
            $table->bigIncrements('id');
           
            $table->unsignedBigInteger('event_id');
            $table->string('featured_image')->nullable();
            $table->string('event_description')->nullable();
            $table->string('event_info')->nullable();
            $table->string('short_desc')->nullable();
            $table->string('event_price')->nullable();
           
            $table->timestamps();
            $table->softDeletes();
             $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_details');
    }
}
