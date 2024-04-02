<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'style',
        'plan_id',
        'stripe_payment_id',
        'file_path',
        'original_name',
        'title',
        'description',
        'state',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }



    // public function ratings()
    // {
    //     return $this->hasMany(VideoRating::class);
    // }

    public function ratings()
    {
        return $this->hasOne(VideoRating::class);
    }


    public function auditionDetails()
    {
        return Singing::where('plan_id', $this->plan_id)->where('user_id', $this->user_id)->first();

    }
}

