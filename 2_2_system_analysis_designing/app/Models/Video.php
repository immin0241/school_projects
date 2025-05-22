<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
//    use HasFactory;

    protected $fillable = [
        'lecture_room_id', 'title', 'video_url'
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lecture_room_id');
    }
}
