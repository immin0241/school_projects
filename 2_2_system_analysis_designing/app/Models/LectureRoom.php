<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id', 'title', 'description', 'thumbnail'
    ];

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
