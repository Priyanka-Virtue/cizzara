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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('audition_city')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('stage_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('relationship_status')->nullable();
            $table->date('date_of_birth')->nullable();
            // $table->integer('age')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('facebook')->nullable();
            $table->string('g_first_name')->nullable();
            $table->string('g_last_name')->nullable();
            $table->string('g_address')->nullable();
            $table->string('g_city')->nullable();
            $table->string('g_state')->nullable();
            $table->string('g_pin_code')->nullable();
            $table->string('g_phone')->nullable();
            $table->string('g_email')->nullable();
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->string('work_experience')->nullable();
            // $table->string('genre_of_singing')->nullable();
            // $table->string('previous_performance')->nullable();
            // $table->string('music_experience')->nullable();
            // $table->string('music_qualification')->nullable();
            $table->string('hobbies')->nullable();
            $table->text('describe_yourself')->nullable();
            // $table->string('how_know_about_auditions')->nullable();
            // $table->string('how_know_about_auditions_detail')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
