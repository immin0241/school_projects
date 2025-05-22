<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\LectureRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function upload_lecture_view(Request $request, $id) {
        return view('upload_lecture', ["idx" => $id]);
    }

    function upload_lecture(Request $request) {
        $request->validate([
            'title' => 'required',
            'video' => 'required|file|mimes:mp4'
        ]);

        $path = $request->file('video')->store('videos', 'public');

        Lecture::create([
            ...$request->only(['title', 'lecture_room_id']),
            'video_url' => $path
        ]);

        return redirect()->route('lecture_main', ["id" => $request->lecture_room_id])->with('message', '강의를 업로드했습니다.');
    }

    public function view(Request $request, $id) {
        $filename = Lecture::findOrFail($id);
        $lectureroom = LectureRoom::findOrFail($filename->lecture_room_id)->subscriptions->where('student_id', Auth::id())->first();

        if($filename->lectureRoom->professor_id !== Auth::id() && is_null($lectureroom)) {
            return back()->with("message", "구독자만 강의를 볼 수 있습니다.");
        }
        return response()->file(storage_path('app/public/'.$filename->video_url));
    }
}
