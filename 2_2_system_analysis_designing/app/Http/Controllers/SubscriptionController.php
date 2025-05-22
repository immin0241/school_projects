<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request, $lectureRoomId)
    {
        $user = Auth::user();

        // Check if the user is already subscribed
        if (Subscription::where('student_id', $user->id)->where('lecture_room_id', $lectureRoomId)->exists()) {
            return redirect()->back()->with('message', '이미 구독자입니다.');
        }

        // Create the subscription
        Subscription::create([
            'student_id' => $user->id,
            'lecture_room_id' => $lectureRoomId,
            'subscribed_at' => now(),
        ]);

        return redirect()->back()->with('message', '구독하였습니다.');
    }
    public function unsubscribe(Request $request, $lectureRoomId)
    {
        $user = Auth::user();

        // Find the subscription
        $subscription = Subscription::where('student_id', $user->id)->where('lecture_room_id', $lectureRoomId)->first();

        if (!$subscription) {
            return redirect()->back()->with('error', '구독자가 아닙니다.');
        }

        // Delete the subscription
        $subscription->delete();

        return redirect()->back()->with('message', '구독을 취소하였습니다.');
    }
}
