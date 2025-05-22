<?php

namespace Database\Seeders;

use App\Models\LectureRoom;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Seeder;

class LectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LectureRoom::factory()->createPredefinedLectureRooms();
    }
}
