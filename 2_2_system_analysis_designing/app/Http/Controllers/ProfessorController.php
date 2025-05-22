<?php

namespace App\Http\Controllers;

use App\Models\LectureRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{
    public function index() {
        $prof = Auth::user();
        $data = LectureRoom::where(['professor_id' => $prof->id])->get();

        $sub_count = $prof->lectureRooms()->withCount('subscriptions')->get()->sum('subscriptions_count');
        $review_count = $prof->lectureRooms()->withCount('reviews')->get()->sum('reviews_count');
        $rating_average = round($prof->lectureRooms()->withSum('reviews', 'rating')->get()->avg('reviews_sum_rating'), 1);

        $counts = [
            'sub_count' => $sub_count,
            'review_count' => $review_count,
            'rating_average' => $rating_average,
        ];

        return view('professor_index', ['lecture_rooms' => $data, 'prof' => $prof, ...$counts]);
    }

    public function profile($id) {
        $prof = User::find($id);
        $data = LectureRoom::where(['professor_id' => $prof->id])->get();

        $sub_count = $prof->lectureRooms()->withCount('subscriptions')->get()->sum('subscriptions_count');
        $review_count = $prof->lectureRooms()->withCount('reviews')->get()->sum('reviews_count');
        $rating_average = round($prof->lectureRooms()->withSum('reviews', 'rating')->get()->avg('reviews_sum_rating'), 1);

        $counts = [
            'sub_count' => $sub_count,
            'review_count' => $review_count,
            'rating_average' => $rating_average,
        ];

        return view('professor_index', ['lecture_rooms' => $data, 'prof' => $prof, ...$counts]);
    }


}
