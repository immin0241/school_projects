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
        Schema::create('lecture_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->string('title');
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->timestamps();

            $table->foreign('professor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecture_rooms');
    }
};
