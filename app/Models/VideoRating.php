<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoRating extends Model
{
    use HasFactory;
    protected $fillable = ['guru_id', 'video_id', 'rating', 'comments'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
