<?php

namespace Tests\Feature;

use App\Models\Lecture;
use App\Models\LectureRoom;
use App\Models\Review;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * 역할(교수자/수강생)과 소유(내 강의실, 내 리뷰, 내 구독)를 함께 확인하는지 검증한다.
 */
class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;
    private User $otherProfessor;
    private User $student;
    private LectureRoom $room;

    protected function setUp(): void
    {
        parent::setUp();

        UserType::create(['type' => '01', 'name' => 'student']);
        UserType::create(['type' => '02', 'name' => 'professor']);

        $this->owner = User::factory()->professor()->create();
        $this->otherProfessor = User::factory()->professor()->create();
        $this->student = User::factory()->student()->create();
        $this->room = LectureRoom::factory()->create(['professor_id' => $this->owner->id]);
    }

    private function lecture(): Lecture
    {
        Storage::disk('local')->put('videos/sample.mp4', 'video-bytes');

        return Lecture::create([
            'lecture_room_id' => $this->room->id,
            'title' => '1강',
            'video_url' => 'videos/sample.mp4',
        ]);
    }

    private function subscribe(User $user): void
    {
        Subscription::create([
            'student_id' => $user->id,
            'lecture_room_id' => $this->room->id,
            'subscribed_at' => now(),
        ]);
    }

    // ---- 역할: 교수자 전용 기능 ----

    public function test_student_cannot_open_professor_dashboard(): void
    {
        $this->actingAs($this->student)->get('/professor')->assertForbidden();
    }

    public function test_student_cannot_create_lecture_room(): void
    {
        $this->actingAs($this->student)
            ->post('/professor/create-lecture', [
                'title' => '수강생이 만든 강의',
                'description' => '설명',
                'thumbnail' => UploadedFile::fake()->image('t.png'),
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('lecture_rooms', ['title' => '수강생이 만든 강의']);
    }

    // ---- 소유: 내 강의실만 수정·삭제·업로드 ----

    public function test_professor_cannot_edit_another_professors_room(): void
    {
        $this->actingAs($this->otherProfessor)
            ->put("/lecture/update/{$this->room->id}", ['title' => '탈취', 'description' => '탈취'])
            ->assertForbidden();

        $this->assertDatabaseMissing('lecture_rooms', ['id' => $this->room->id, 'title' => '탈취']);
    }

    public function test_professor_can_edit_own_room(): void
    {
        $this->actingAs($this->owner)
            ->put("/lecture/update/{$this->room->id}", ['title' => '새 제목', 'description' => '새 설명'])
            ->assertRedirect(route('professor.index'));

        $this->assertDatabaseHas('lecture_rooms', ['id' => $this->room->id, 'title' => '새 제목']);
    }

    public function test_professor_cannot_delete_another_professors_room(): void
    {
        $this->actingAs($this->otherProfessor)
            ->delete("/lecture/delete/{$this->room->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('lecture_rooms', ['id' => $this->room->id]);
    }

    public function test_professor_can_delete_own_room(): void
    {
        $this->actingAs($this->owner)
            ->delete("/lecture/delete/{$this->room->id}")
            ->assertRedirect(route('professor.index'));

        $this->assertDatabaseMissing('lecture_rooms', ['id' => $this->room->id]);
    }

    public function test_professor_cannot_upload_to_another_professors_room(): void
    {
        Storage::fake('local');

        $this->actingAs($this->otherProfessor)
            ->post('/lecture/upload', [
                'lecture_room_id' => $this->room->id,
                'title' => '끼워넣은 강의',
                'video' => UploadedFile::fake()->create('v.mp4', 10, 'video/mp4'),
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('lectures', ['title' => '끼워넣은 강의']);
    }

    // ---- 영상: 비공개 저장, 구독자와 담당 교수만 시청 ----

    public function test_uploaded_video_is_not_stored_on_public_disk(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $this->actingAs($this->owner)
            ->post('/lecture/upload', [
                'lecture_room_id' => $this->room->id,
                'title' => '1강',
                'video' => UploadedFile::fake()->create('v.mp4', 10, 'video/mp4'),
            ])
            ->assertRedirect();

        $lecture = Lecture::where('title', '1강')->firstOrFail();
        Storage::disk('local')->assertExists($lecture->video_url);
        Storage::disk('public')->assertMissing($lecture->video_url);
    }

    public function test_guest_cannot_watch_video(): void
    {
        Storage::fake('local');
        $lecture = $this->lecture();

        $this->get("/lecture/view/{$lecture->id}")->assertRedirect('/login');
    }

    public function test_non_subscriber_cannot_watch_video(): void
    {
        Storage::fake('local');
        $lecture = $this->lecture();

        $this->actingAs($this->student)->get("/lecture/view/{$lecture->id}")->assertForbidden();
    }

    public function test_subscriber_and_owner_can_watch_video(): void
    {
        Storage::fake('local');
        $lecture = $this->lecture();
        $this->subscribe($this->student);

        $this->actingAs($this->student)->get("/lecture/view/{$lecture->id}")->assertOk();
        $this->actingAs($this->owner)->get("/lecture/view/{$lecture->id}")->assertOk();
    }

    // ---- 구독: 상태를 바꾸는 요청은 GET이 아니어야 함 ----

    public function test_subscribe_and_unsubscribe_use_post_and_delete(): void
    {
        $this->actingAs($this->student)->post("/lecture/{$this->room->id}/subscribe")->assertRedirect();
        $this->assertDatabaseHas('subscriptions', ['student_id' => $this->student->id, 'lecture_room_id' => $this->room->id]);

        $this->actingAs($this->student)->delete("/lecture/{$this->room->id}/subscribe")->assertRedirect();
        $this->assertDatabaseMissing('subscriptions', ['student_id' => $this->student->id, 'lecture_room_id' => $this->room->id]);
    }

    // ---- 리뷰: 작성 조건과 삭제 권한 ----

    public function test_user_cannot_delete_someone_elses_review(): void
    {
        $this->subscribe($this->student);
        $review = Review::create([
            'student_id' => $this->student->id, 'lecture_room_id' => $this->room->id, 'rating' => 5, 'comment' => '좋아요',
        ]);
        $intruder = User::factory()->student()->create();

        $this->actingAs($intruder)->delete("/review/{$review->id}")->assertForbidden();
        $this->assertDatabaseHas('reviews', ['id' => $review->id]);
    }

    public function test_author_can_delete_own_review(): void
    {
        $review = Review::create([
            'student_id' => $this->student->id, 'lecture_room_id' => $this->room->id, 'rating' => 5, 'comment' => '좋아요',
        ]);

        $this->actingAs($this->student)->delete("/review/{$review->id}")->assertRedirect();
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    public function test_review_rating_must_be_between_1_and_5(): void
    {
        $this->subscribe($this->student);

        $this->actingAs($this->student)
            ->post('/review', ['lecture_room_id' => $this->room->id, 'rating' => 9, 'comment' => '별 9개'])
            ->assertSessionHasErrors('rating');

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_only_subscribers_can_write_reviews(): void
    {
        $this->actingAs($this->student)
            ->post('/review', ['lecture_room_id' => $this->room->id, 'rating' => 1, 'comment' => '안 들었지만 별로'])
            ->assertForbidden();

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_student_can_review_a_room_only_once(): void
    {
        $this->subscribe($this->student);
        $payload = ['lecture_room_id' => $this->room->id, 'rating' => 4, 'comment' => '좋아요'];

        $this->actingAs($this->student)->post('/review', $payload)->assertRedirect();
        $this->actingAs($this->student)->post('/review', $payload)->assertSessionHasErrors('lecture_room_id');

        $this->assertDatabaseCount('reviews', 1);
    }

    // ---- 출력: 사용자 입력이 스크립트로 실행되지 않아야 함 ----

    public function test_lecture_description_is_escaped_on_main_page(): void
    {
        LectureRoom::factory()->create([
            'professor_id' => $this->owner->id,
            'description' => '</script><script>alert(1)</script>',
        ]);

        $this->get('/')->assertOk()->assertDontSee('<script>alert(1)</script>', false);
    }
}
