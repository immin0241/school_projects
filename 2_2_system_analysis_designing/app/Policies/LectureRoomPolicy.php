<?php

namespace App\Policies;

use App\Models\LectureRoom;
use App\Models\User;

/**
 * 교수자 "역할"은 라우트 미들웨어가, 강의실 "소유"는 이 정책이 확인한다.
 */
class LectureRoomPolicy
{
    /** 수정·삭제·영상 업로드는 강의실을 개설한 교수자만 할 수 있다. */
    public function manage(User $user, LectureRoom $room): bool
    {
        return $user->id === $room->professor_id;
    }

    /** 영상 시청은 담당 교수자와 구독자만 할 수 있다. */
    public function watch(User $user, LectureRoom $room): bool
    {
        return $this->manage($user, $room)
            || $room->subscriptions()->where('student_id', $user->id)->exists();
    }

    /** 강의평은 구독자만 쓸 수 있다. */
    public function review(User $user, LectureRoom $room): bool
    {
        return $room->subscriptions()->where('student_id', $user->id)->exists();
    }
}
