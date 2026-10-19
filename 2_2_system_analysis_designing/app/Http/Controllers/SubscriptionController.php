<?php

namespace App\Http\Controllers;

use App\Models\LectureRoom;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe($lectureRoomId)
    {
        $room = LectureRoom::findOrFail($lectureRoomId);

        $subscription = Subscription::firstOrCreate(
            ['student_id' => Auth::id(), 'lecture_room_id' => $room->id],
            ['subscribed_at' => now()],
        );

        $message = $subscription->wasRecentlyCreated ? '구독하였습니다.' : '이미 구독자입니다.';

        return redirect()->back()->with('message', $message);
    }

    public function unsubscribe($lectureRoomId)
    {
        $deleted = Subscription::where('student_id', Auth::id())
            ->where('lecture_room_id', $lectureRoomId)
            ->delete();

        if ($deleted === 0) {
            return redirect()->back()->with('error', '구독자가 아닙니다.');
        }

        return redirect()->back()->with('message', '구독을 취소하였습니다.');
    }
}
