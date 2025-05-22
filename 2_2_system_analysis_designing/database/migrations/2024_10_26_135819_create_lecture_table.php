<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_room_id');
            $table->string('title');
            $table->string('video_url');
            $table->timestamps();

            $table->foreign('lecture_room_id')->references('id')->on('lecture_rooms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lectures');
    }
};
