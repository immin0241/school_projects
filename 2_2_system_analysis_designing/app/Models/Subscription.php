<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
//    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'student_id', 'lecture_room_id', 'subscribed_at'
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
