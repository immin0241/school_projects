<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'userid', 'password', 'name', 'type'
    ];

    protected $hidden = ['password'];

    public function lectureRooms()
    {
        return $this->hasMany(LectureRoom::class, 'professor_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'student_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'student_id');
    }

    public function types()
    {
        return $this->hasOne(UserType::class, 'type');
    }
}
