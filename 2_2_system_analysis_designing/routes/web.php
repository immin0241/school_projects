<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LectureRoomController;

Route::get('/', [\App\Http\Controllers\MainController::class, "view"])->name('main');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/lecture', [LectureRoomController::class, 'find'])->name('lecture_find');
Route::get('/lecture/lists', [\App\Http\Controllers\LectureRoomController::class, 'get_lists'])->name('lecture_lists');
Route::get('/professor/create-lecture', [LectureRoomController::class, 'create_lecture_view'])->name('professor.create_lecture');
Route::post('/professor/create-lecture', [LectureRoomController::class, 'create']);
Route::get('/lecture/{id}', [\App\Http\Controllers\LectureRoomController::class, 'room_main'])->name('lecture_main');
Route::get('/lecture/view/{id}', [\App\Http\Controllers\LectureController::class, 'view'])->name('lecture_view');

Route::get('/professor/{id}', [\App\Http\Controllers\ProfessorController::class, 'profile'])->name('professor_info');


Route::middleware(['auth'])->group(function () {
    Route::get('/subscribe/{id}', [\App\Http\Controllers\SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::get('/unsubscribe/{id}', [\App\Http\Controllers\SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
    Route::post('/review', [\App\Http\Controllers\ReviewController::class, 'create'])->name('review');
    Route::delete('/review/{id}', [\App\Http\Controllers\ReviewController::class, 'delete'])->name('review_delete');

    Route::get('/mypage/{id}', [\App\Http\Controllers\ProfileController::class, 'view'])->name("my_page");
});

Route::middleware(\App\Http\Middleware\CheckUserProfessor::class)->group(function () {
    Route::get('/professor', [\App\Http\Controllers\ProfessorController::class, 'index'])->name('professor.index');
    Route::get('/lecture/update/{id}', [LectureRoomController::class, 'edit_lecture_view'])->name('professor.edit_lecture_view');
    Route::put('/lecture/update/{id}', [LectureRoomController::class, 'edit_lecture'])->name('professor.edit_lecture');
    Route::delete('/lecture/delete/{id}', [LectureRoomController::class, 'delete_lecture'])->name('professor.delete_lecture');
    Route::get('/lecture/upload/{id}', [\App\Http\Controllers\LectureController::class, 'upload_lecture_view'])->name('lecture.upload_view');
    Route::post('/lecture/upload', [\App\Http\Controllers\LectureController::class, 'upload_lecture'])->name('lecture.upload');
});

require __DIR__.'/auth.php';
