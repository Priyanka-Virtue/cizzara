<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'style',
        'plan_id',
        'payment_id',
        'file_path',
        'original_name',
        'title',
        'description',
        'status',
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
    public function audition(){
        return $this->hasOne(Audition::class);
    }



    public function ratings()
    {
        return $this->hasMany(VideoRating::class);
    }

    public function guruRatings()
    {
        return $this->hasOne(VideoRating::class)->where('guru_id','=', Auth::id());
    }

    public function scopeOrderByRatings($query, $direction = 'asc')
    {
        // Join with ratings table and count the ratings
        $query->leftJoin('video_ratings', 'videos.id', '=', 'video_ratings.video_id')
            ->select('videos.*', DB::raw('COUNT(video_ratings.id) as rating_count'))
            ->groupBy('videos.id');

        // Sort by the number of ratings
        $query->orderBy('rating_count', $direction);

        return $query;
    }


    public function auditionDetails()
    {
        return Audition::where('plan_id', $this->plan_id)->where('user_id', $this->user_id)->first();

    }
}

