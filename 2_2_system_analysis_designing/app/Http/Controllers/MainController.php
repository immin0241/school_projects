<?php

namespace App\Http\Controllers;

use App\Models\LectureRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function view()
    {
        $hot_lectures = LectureRoom::withCount('subscriptions')->orderBy('subscriptions_count', 'desc')->take(5)->get();
        $user_lectures = null;

        if(Auth::check()) {
            $user_subs = Auth::user()->subscriptions()->get('lecture_room_id')->toArray();
            $user_lectures = LectureRoom::whereIn('id', $user_subs)->get();
        }

        return view('main', compact('hot_lectures', 'user_lectures'));
    }
}
