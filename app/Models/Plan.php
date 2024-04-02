<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'is_active'
    ];
    protected $casts = [
        'gurus' => 'json'
    ];
    public function gurus()
    {
        return $this->belongsToMany(User::class, 'plan_guru', 'plan_id', 'guru_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
