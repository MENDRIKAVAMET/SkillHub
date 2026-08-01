<?php

namespace Tests\Feature;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_learning_request(): void
    {
        $user = User::factory()->create();
        $skill = Skill::create([
            'name' => 'Vue.js',
            'description' => 'Framework JavaScript',
        ]);

        $response = $this->actingAs($user)->post(route('learning-requests.store'), [
            'skill_id' => $skill->id,
            'message' => 'J’aimerais progresser sur ce sujet.',
            'status' => 'En attente',
        ]);

        $response->assertRedirect(route('learning-requests.index'));
        $this->assertDatabaseHas('learning_requests', [
            'user_id' => $user->id,
            'skill_id' => $skill->id,
            'message' => 'J’aimerais progresser sur ce sujet.',
            'status' => 'En attente',
        ]);
    }
}
