<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Singing extends Model
{
    use HasFactory;
    protected $fillable = [
        'auditioncity',
        'user_id',
        'plan_id',
        'stagename',
        'why_tup_expectations',
        'why_we_select_you',
        'future_plan_if_win',
        'opinion_new_season_tup',
        'written_composed_song_inspiration',
        'life_changing_incident',
        'change_about_self_love_about_self',
        'unique_qualities',
        'main_goal_difficulties',
        'biggest_strength_support',
        'favorite_judge_why',
        'role_model_inspiration',
        'prepared_songs',
        'how_know_about_auditions',
        'how_know_about_auditions_detail',

        'genre_of_singing',
        'previous_performance',
        'music_experience',
        'music_qualification'
    ];

    // User model relationship
    function user(){
        return $this->belongsTo(User::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
