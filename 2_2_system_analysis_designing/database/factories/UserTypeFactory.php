<?php

namespace Database\Factories;

use App\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => '01',
            'name' => 'student'
        ];
    }

    public static function createPredefinedUserTypes()
    {
        UserType::create([
            'type' => '01',
            'name' => 'student'
        ]);
        UserType::create([
            'type' => '02',
            'name' => 'professor'
        ]);
    }
}
