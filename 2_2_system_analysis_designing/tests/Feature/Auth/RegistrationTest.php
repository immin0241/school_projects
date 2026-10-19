<?php

namespace Tests\Feature\Auth;

use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $this->get('/register')->assertOk();
    }

    public function test_new_users_can_register(): void
    {
        UserType::create(['type' => '01', 'name' => 'student']);

        $this->post('/register', [
            'name' => '테스트',
            'userid' => 'tester',
            'type' => '01',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('main', absolute: false));

        $this->assertDatabaseHas('users', ['userid' => 'tester', 'type' => '01']);
    }
}
