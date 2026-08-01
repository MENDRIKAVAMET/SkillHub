<?php

namespace Tests\Feature;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_matching_users_and_skills(): void
    {
        $user = User::factory()->create(['name' => 'Alice Dupont']);
        Skill::create(['name' => 'Laravel', 'description' => 'PHP framework']);

        $response = $this->actingAs($user)->get(route('search', ['q' => 'lar']));

        $response->assertOk();
        $response->assertSee('Laravel');
        $response->assertSee('Alice Dupont');
    }
}
