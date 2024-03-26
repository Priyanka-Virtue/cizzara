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
        Schema::create('singings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id');
            $table->string('stagename')->nullable();
            $table->string('auditioncity');
            $table->text('why_tup_expectations')->nullable();
            $table->text('why_we_select_you')->nullable();
            $table->text('future_plan_if_win')->nullable();
            $table->text('opinion_new_season_tup')->nullable();
            $table->text('written_composed_song_inspiration')->nullable();
            $table->text('life_changing_incident')->nullable();
            $table->text('change_about_self_love_about_self')->nullable();
            $table->text('unique_qualities')->nullable();
            $table->text('main_goal_difficulties')->nullable();
            $table->text('biggest_strength_support')->nullable();
            $table->text('favorite_judge_why')->nullable();
            $table->text('role_model_inspiration')->nullable();
            $table->text('prepared_songs')->nullable();
            $table->string('how_know_about_auditions')->nullable();
            $table->string('how_know_about_auditions_detail')->nullable();

            $table->string('genre_of_singing')->nullable();
            $table->text('previous_performance')->nullable();
            $table->text('music_experience')->nullable();
            $table->text('music_qualification')->nullable();


        


            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('singings');
    }
};
