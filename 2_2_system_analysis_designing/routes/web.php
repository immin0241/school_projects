<?php

use App\Http\Controllers\LectureController;
use App\Http\Controllers\LectureRoomController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\CheckUserProfessor;
use Illuminate\Support\Facades\Route;

// 누구나 볼 수 있는 화면
Route::get('/', [MainController::class, 'view'])->name('main');
Route::get('/lecture', [LectureRoomController::class, 'find'])->name('lecture_find');
Route::get('/lecture/{id}', [LectureRoomController::class, 'room_main'])->whereNumber('id')->name('lecture_main');
Route::get('/professor/{id}', [ProfessorController::class, 'profile'])->whereNumber('id')->name('professor_info');

// 로그인한 사용자
Route::middleware('auth')->group(function () {
    Route::get('/lecture/view/{id}', [LectureController::class, 'view'])->name('lecture_view');

    // 상태를 바꾸는 요청은 GET이 아닌 POST/DELETE로 받는다.
    Route::post('/lecture/{id}/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::delete('/lecture/{id}/subscribe', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');

    Route::post('/review', [ReviewController::class, 'create'])->name('review');
    Route::delete('/review/{id}', [ReviewController::class, 'delete'])->name('review_delete');

    Route::get('/mypage/{id}', [ProfileController::class, 'view'])->name('my_page');
});

// 교수자 전용 (역할 확인). 강의실 소유 여부는 컨트롤러에서 LectureRoomPolicy로 확인한다.
Route::middleware(CheckUserProfessor::class)->group(function () {
    Route::get('/professor', [ProfessorController::class, 'index'])->name('professor.index');
    Route::get('/professor/create-lecture', [LectureRoomController::class, 'create_lecture_view'])->name('professor.create_lecture');
    Route::post('/professor/create-lecture', [LectureRoomController::class, 'create']);
    Route::get('/lecture/update/{id}', [LectureRoomController::class, 'edit_lecture_view'])->name('professor.edit_lecture_view');
    Route::put('/lecture/update/{id}', [LectureRoomController::class, 'edit_lecture'])->name('professor.edit_lecture');
    Route::delete('/lecture/delete/{id}', [LectureRoomController::class, 'delete_lecture'])->name('professor.delete_lecture');
    Route::get('/lecture/upload/{id}', [LectureController::class, 'upload_lecture_view'])->name('lecture.upload_view');
    Route::post('/lecture/upload', [LectureController::class, 'upload_lecture'])->name('lecture.upload');
});

require __DIR__.'/auth.php';
