<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
//    use HasFactory;

    protected $fillable = [
        'lecture_room_id', 'title', 'video_url'
    ];

    public function lectureRoom()
    {
        return $this->belongsTo(LectureRoom::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
