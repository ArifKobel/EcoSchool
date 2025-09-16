<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_questionnaire_store_validates_required_fields(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)->post('/questionnaire', []);

        $response->assertSessionHasErrors(['question_id', 'answer']);
    }

    public function test_questionnaire_show_requires_authentication(): void
    {
        $response = $this->get('/questionnaire');

        $response->assertRedirect(route('login'));
    }

    public function test_questionnaire_progress_returns_json_response(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)->get('/questionnaire/progress');

        $response->assertStatus(200)
                ->assertJsonStructure(['progress', 'completed']);
    }
}
