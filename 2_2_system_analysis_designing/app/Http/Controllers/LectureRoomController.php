<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\LectureRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureRoomController extends Controller
{
    public function find(Request $request) {
        $lectures = null;

        if($request->has("query")) {
            $lectures = LectureRoom::query()->where("title", "like", "%" . $request->get('query') . "%")->get();
        }
        else {
            $lectures = LectureRoom::with("reviews")->get();
        }

        return view("find_lectures", ["lectures" => $lectures]);
    }

    public function get_lists(Request $request) {
        $by = $request->get('by');
        $types = [
            0 => "created_at",
            1 => "rating",
            2 => "comment"
        ];

        $data = LectureRoom::withCount('')->sortByDesc($types[$by]);
    }

    public function create_lecture_view() {
        return view('create_lecture');
    }
    public function edit_lecture_view(Request $request, $id) {
        $data = LectureRoom::find($id);

        return view('edit_lecture', ['room_data' => $data]);
    }

    public function room_main(Request $request, $id) {
        $lecture = LectureRoom::find($id);

        return view('lecture', ['lecture' => $lecture]);
    }

    public function create(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|file',
        ]);

        $path = $request->file('thumbnail')->store('lecture_thumbnails', 'public');

        LectureRoom::create([
            'professor_id' => Auth::user()->id,
            ...$request->only('title', 'description'),
            'thumbnail' => $path,
        ]);

        return redirect()->route('professor.index')->with("message", "강의가 개설되었습니다.");
    }

    public function delete(Request $request, $id)
    {
        LectureRoom::find($id)->delete();

        return redirect()->route('professor.index');
    }

    public function edit_lecture(Request $request, $id) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'thumbnail' => 'file|nullable',
        ]);

        if($request->get('thumbnail') != null) {
            $path = $request->file('thumbnail')->store('lecture_thumbnails', 'public');
        }

        $lecture_room = LectureRoom::find($id);

        $lecture_room->title = $request->get('title');
        $lecture_room->description = $request->get('description');

        if(isset($path)) {
            $lecture_room->thumbnail = $path;
        }

        $lecture_room->save();
        return redirect()->route('professor.index');
    }


}
