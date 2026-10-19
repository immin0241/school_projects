<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\LectureRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class LectureController extends Controller
{
    public function upload_lecture_view($id)
    {
        Gate::authorize('manage', LectureRoom::findOrFail($id));

        return view('upload_lecture', ['idx' => $id]);
    }

    public function upload_lecture(Request $request)
    {
        $validated = $request->validate([
            'lecture_room_id' => 'required|integer|exists:lecture_rooms,id',
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4',
        ]);

        // 폼의 hidden 값은 사용자가 바꿀 수 있으므로, 그 강의실의 주인인지 서버에서 다시 확인한다.
        $room = LectureRoom::findOrFail($validated['lecture_room_id']);
        Gate::authorize('manage', $room);

        Lecture::create([
            'lecture_room_id' => $room->id,
            'title' => $validated['title'],
            // 영상은 비공개 디스크에 저장하고, 시청은 아래 view()를 거쳐서만 가능하다.
            'video_url' => $request->file('video')->store('videos', 'local'),
        ]);

        return redirect()->route('lecture_main', ['id' => $room->id])->with('message', '강의를 업로드했습니다.');
    }

    public function view($id)
    {
        $lecture = Lecture::findOrFail($id);
        Gate::authorize('watch', $lecture->lectureRoom);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($lecture->video_url), 404);

        return response()->file($disk->path($lecture->video_url));
    }
}
