<?php

namespace Tests\Feature;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSkillTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_associate_a_skill_with_a_level(): void
    {
        $user = User::factory()->create();
        $skill = Skill::create([
            'name' => 'Laravel',
            'description' => 'PHP framework',
        ]);

        $response = $this->actingAs($user)
            ->post(route('user-skills.store'), [
                'skill_id' => $skill->id,
                'level' => 'Débutant',
            ]);

        $response->assertRedirect(route('user-skills.index'));
        $this->assertDatabaseHas('user_skills', [
            'user_id' => $user->id,
            'skill_id' => $skill->id,
            'level' => 'Débutant',
        ]);
    }
}
