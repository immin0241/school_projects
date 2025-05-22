<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'lecture_room_id', 'rating', 'comment'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function lectureRoom()
    {
        return $this->belongsTo(LectureRoom::class);
    }
}
