<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->unique()->userName,
            'password' => Hash::make('password'),
            'name' => $this->faker->name,
            'type' => '01',
        ];
    }

    /**
     * Create predefined users.
     *
     * @return void
     */
    public static function createPredefinedUsers()
    {
        User::create([
            'userid' => 'prof',
            'name' => '김교수',
            'password' => Hash::make('1234'),
            'type' => '02',
        ]);

        User::create([
            'userid' => 'stu1',
            'name' => '김학생',
            'password' => Hash::make('1234'),
            'type' => '01',
        ]);

        User::create([
            'userid' => 'stu2',
            'name' => '이학생',
            'password' => Hash::make('1234'),
            'type' => '01',
        ]);
        User::create([
            'userid' => 'stu3',
            'name' => '박학생',
            'password' => Hash::make('1234'),
            'type' => '01',
        ]);
        User::create([
            'userid' => 'stu4',
            'name' => '노학생',
            'password' => Hash::make('1234'),
            'type' => '01',
        ]);
        User::create([
            'userid' => 'stu5',
            'name' => '윤학생',
            'password' => Hash::make('1234'),
            'type' => '01',
        ]);
        User::create([
            'userid' => 'stu6',
            'name' => '표학생',
            'password' => Hash::make('1234'),
            'type' => '01',
        ]);
        User::create([
            'userid' => 'stu7',
            'name' => '전학생',
            'password' => Hash::make('1234'),
            'type' => '01',
        ]);
        User::create([
            'userid' => 'stu8',
            'name' => '황학생',
            'password' => Hash::make('1234'),
            'type' => '01',
        ]);
    }
}
