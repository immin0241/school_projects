<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Request $request) {
        Review::create([
            ...$request->only(["comment", "rating", "lecture_room_id"]),
            "student_id" => Auth::id()
        ]);

        return redirect()->back();
    }

    public function delete(Request $request) {
        Review::where('id', $request->id)->delete();
        return redirect()->back()->with('message', "삭제되었습니다.");
    }
}
