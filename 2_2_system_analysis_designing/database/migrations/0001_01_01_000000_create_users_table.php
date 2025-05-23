<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->char('type', 2)->unique();
            $table->text('name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('userid')->unique();
            $table->string('name');
            $table->string('password');
            $table->char('type', 2);
            $table->timestamps();

            $table->foreign('type')->references('type')->on('user_types')->onDelete('cascade');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecture_rooms', function (Blueprint $table) {
            $table->dropForeign(['professor_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
