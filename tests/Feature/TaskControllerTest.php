<?php

namespace Tests\Feature;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_tasks()
    {
        $tasks = Task::factory()->count(10)->create();

        $response = $this->get(route("tasks.index"));

        $response->assertStatus(200);
        $response->assertViewIs("tasks");
        $response->assertViewHas("tasks", $tasks);
    }

    public function test_store_creates_task()
    {
        $response = $this->post(route("tasks.store"), [
            "description" => "Test Task",
        ]);

        $this->assertDatabaseHas("tasks", ["description" => "Test Task"]);
        $response->assertRedirect(route("tasks.index"));
    }

    public function test_complete_marks_task_as_completed()
    {
        $task = Task::factory()->create();

        $response = $this->patch(route("tasks.complete", $task));

        $this->assertDatabaseHas("tasks", [
            "id" => $task->id,
            "completed_at" => Carbon::now(),
        ]);

        $response->assertRedirect(route("tasks.index"));
    }

    public function test_destroy_deletes_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route("tasks.destroy", $task));

        $this->assertDatabaseMissing("tasks", ["id" => $task->id]);

        $response->assertRedirect(route("tasks.index"));
    }
}
