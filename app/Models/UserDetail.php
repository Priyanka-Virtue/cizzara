<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // 'audition_city',
        'first_name',
        'last_name',
        'stage_name',
        'gender',
        'relationship_status',
        'date_of_birth',
        // 'age',
        'address',
        'city',
        'state',
        'pin_code',
        'phone',
        'email',
        'instagram',
        'youtube',
        'facebook',
        'g_first_name',
        'g_last_name',
        'g_address',
        'g_city',
        'g_state',
        'g_pin_code',
        'g_phone',
        'g_email',
        'education',
        'occupation',
        'work_experience',
        'genre_of_singing',
        'previous_performance',
        'music_experience',
        'music_qualification',
        'hobbies',
        'describe_yourself',
        'how_know_about_auditions',
        'how_know_about_auditions_detail',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
