<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'lecture_room_id', 'title', 'video_url',
    ];

    public function lectureRoom()
    {
        return $this->belongsTo(LectureRoom::class);
    }
}
