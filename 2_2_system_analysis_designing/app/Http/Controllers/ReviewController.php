<?php

namespace App\Http\Controllers;

use App\Models\LectureRoom;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'lecture_room_id' => [
                'required', 'integer', 'exists:lecture_rooms,id',
                // 한 강의실에 한 사람당 강의평 하나 (화면에서만 막던 것을 서버에서도 막는다)
                Rule::unique('reviews')->where('student_id', Auth::id()),
            ],
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ], [
            'lecture_room_id.unique' => '이미 강의평을 작성했습니다.',
        ]);

        Gate::authorize('review', LectureRoom::findOrFail($validated['lecture_room_id']));

        Review::create([...$validated, 'student_id' => Auth::id()]);

        return redirect()->back();
    }

    public function delete($id)
    {
        $review = Review::findOrFail($id);
        Gate::authorize('delete', $review);

        $review->delete();

        return redirect()->back()->with('message', '삭제되었습니다.');
    }
}
