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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->string('stripe_payment_id')->nullable();
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('title')->nullable();;
            $table->text('description')->nullable();
            $table->text('style')->nullable();
            $table->enum('status', config('app.audition_status'))->default('pending');
            $table->enum('state', config('app.audition_status'))->default('pending');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('audition_id')->references('id')->on('auditions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
