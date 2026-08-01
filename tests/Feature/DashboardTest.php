<?php

namespace Tests\Feature;

use App\Models\HelpRequest;
use App\Models\LearningRequest;
use App\Models\Message;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_statistics_and_recent_activity(): void
    {
        $user = User::factory()->create();
        Skill::create(['name' => 'Laravel', 'description' => 'Framework']);
        LearningRequest::create(['user_id' => $user->id, 'skill_id' => 1, 'message' => 'Need help', 'status' => 'En attente']);
        HelpRequest::create(['user_id' => $user->id, 'sender_id' => $user->id, 'receiver_id' => $user->id, 'skill_id' => 1, 'message' => 'Hi', 'status' => 'En attente']);
        Message::create(['sender_id' => $user->id, 'receiver_id' => $user->id, 'content' => 'Hello']);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Nombre de compétences');
        $response->assertSee('Dernières activités');
    }
}
