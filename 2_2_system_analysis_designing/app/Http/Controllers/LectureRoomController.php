<?php

namespace App\Http\Controllers;

use App\Models\LectureRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LectureRoomController extends Controller
{
    public function find(Request $request)
    {
        if ($request->has('query')) {
            $lectures = LectureRoom::query()->where('title', 'like', '%'.$request->get('query').'%')->get();
        } else {
            $lectures = LectureRoom::with('reviews')->get();
        }

        return view('find_lectures', ['lectures' => $lectures]);
    }

    public function create_lecture_view()
    {
        return view('create_lecture');
    }

    public function edit_lecture_view($id)
    {
        $room = LectureRoom::findOrFail($id);
        Gate::authorize('manage', $room);

        return view('edit_lecture', ['room_data' => $room]);
    }

    public function room_main($id)
    {
        return view('lecture', ['lecture' => LectureRoom::findOrFail($id)]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image',
        ]);

        LectureRoom::create([
            'professor_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'thumbnail' => $request->file('thumbnail')->store('lecture_thumbnails', 'public'),
        ]);

        return redirect()->route('professor.index')->with('message', '강의가 개설되었습니다.');
    }

    public function delete_lecture($id)
    {
        $room = LectureRoom::findOrFail($id);
        Gate::authorize('manage', $room);

        $room->delete();

        return redirect()->route('professor.index')->with('message', '강의가 삭제되었습니다.');
    }

    public function edit_lecture(Request $request, $id)
    {
        $room = LectureRoom::findOrFail($id);
        Gate::authorize('manage', $room);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image',
        ]);

        $room->title = $validated['title'];
        $room->description = $validated['description'];

        if ($request->hasFile('thumbnail')) {
            $room->thumbnail = $request->file('thumbnail')->store('lecture_thumbnails', 'public');
        }

        $room->save();

        return redirect()->route('professor.index');
    }
}
