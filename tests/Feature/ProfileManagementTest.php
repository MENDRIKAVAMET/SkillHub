<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_model_accepts_profile_attributes(): void
    {
        $user = User::factory()->create([
            'name' => 'Profile User',
            'email' => 'profile@example.com',
            'password' => Hash::make('password123'),
            'bio' => 'Développeur',
            'city' => 'Lyon',
        ]);

        $this->assertSame('Profile User', $user->name);
        $this->assertSame('Développeur', $user->bio);
        $this->assertSame('Lyon', $user->city);
    }
}
