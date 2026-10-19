<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /** 강의평은 작성자만 삭제할 수 있다. */
    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->student_id;
    }
}
