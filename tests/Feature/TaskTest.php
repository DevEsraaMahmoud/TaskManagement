<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class TaskTest extends TestCase
{
    use LazilyRefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_fetch_all_tasks(): void
    {
        $response = $this->actingAs(User::factory()->create(), 'sanctum')->getJson('/api/tasks');

        $response->assertStatus(200);
    }

    public function test_create_task(): void
    {
        $response = $this->actingAs(User::factory()->create(), 'sanctum')
        ->postJson('/api/tasks', Task::factory()->make()->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', [
            'name' => $response->json('data.name'),
        ]);
    }

    public function test_task_name_required(): void
    {
        $response = $this->actingAs(User::factory()->create(), 'sanctum')->postJson('/api/tasks', [
            'description' => 'Test Description',
            'status' => 0,
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    public function test_only_authenticated_user_can_manage_tasks()
    {
        $task = Task::factory()->create();

        $this->getJson(route('tasks.index'))->assertUnauthorized();
        $this->postJson(route('tasks.store'))->assertUnauthorized();
        $this->getJson(route('tasks.show', ['task' => $task->id]))->assertUnauthorized();
        $this->putJson(route('tasks.update', ['task' => $task->id]))->assertUnauthorized();
        $this->patchJson(route('tasks.destroy', ['task' => $task->id]))->assertUnauthorized();
    }
}
