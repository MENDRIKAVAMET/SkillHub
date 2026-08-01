<?php

namespace Tests\Feature;

use App\Models\HelpRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_help_request(): void
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();
        $skill = Skill::create([
            'name' => 'PHP',
            'description' => 'Langage back-end',
        ]);

        $response = $this->actingAs($sender)->post(route('help-requests.store'), [
            'receiver_id' => $receiver->id,
            'skill_id' => $skill->id,
            'message' => 'Bonjour, pouvez-vous m’aider ?'
        ]);

        $response->assertRedirect(route('help-requests.index'));
        $this->assertDatabaseHas('help_requests', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'skill_id' => $skill->id,
            'message' => 'Bonjour, pouvez-vous m’aider ?',
            'status' => 'En attente',
        ]);
    }
}
