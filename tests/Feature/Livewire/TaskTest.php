<?php

namespace Tests\Feature\Livewire;

// Importing necessary namespaces and classes for testing
use App\Livewire\Task;
use App\Models\Task as ModelsTask;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

// Test class for Task Livewire component
class TaskTest extends TestCase
{
    use RefreshDatabase;

    // Test to ensure the Livewire component renders successfully
    public function test_renders_successfully()
    {
        Livewire::test(Task::class)
            ->assertStatus(200);
    }

    // Test to validate task creation input
    public function test_task_validation()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(Task::class)
            ->set('taskTitle', '')
            ->set('taskDescription', 'Description')
            ->set('startDate', now())
            ->set('dueDate', now()->addDays(1))
            ->set('priority', 'medium')
            ->call('createTask')
            ->assertHasErrors(['taskTitle' => 'required']);
    }

    // Test to create a new task and verify it in the database
public function test_create_task()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    $startDate = now();
    $dueDate = now()->addDays(5);

    Livewire::test(Task::class)
        ->set('taskTitle', 'New Task')
        ->set('taskDescription', 'Description for new task')
        ->set('startDate', $startDate)
        ->set('dueDate', $dueDate)
        ->set('priority', 'medium')
        ->call('createTask');

    $this->assertDatabaseHas('tasks', [
        'title' => 'New Task',
        'description' => 'Description for new task',
        'start_date' => $startDate->toDateString(),
        'due_date' => $dueDate->toDateString(),
        'priority' => 'medium',
        'user_id' => $user->id,
    ]);
}


    // Test to verify a regular user cannot mark a task as completed
    public function test_mark_as_completed_for_regular_user()
    {
        $user = User::factory()->create();
        $task = ModelsTask::factory()->create([
            'status' => false,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = Livewire::test(Task::class)
            ->call('markAsCompleted', $task->id);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => false,
        ]);
        $response->assertForbidden();
    }

    // Test to verify an admin user can mark a task as completed
    public function test_mark_as_completed_for_admin_user()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $task = ModelsTask::factory()->create([
            'status' => false,
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(Task::class)
            ->call('markAsCompleted', $task->id);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => true,
        ]);
    }

    // Test to verify a regular user cannot delete a task
    public function test_delete_task_for_regular_user()
    {
        $user = User::factory()->create();
        $task = ModelsTask::factory()->create([
            'status' => false,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = Livewire::test(Task::class)
            ->call('deleteTask', $task->id);

        $response->assertForbidden();
    }

    // Test to verify an admin user can delete a task
    public function test_delete_task_for_admin_user()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $task = ModelsTask::factory()->create([
            'status' => false,
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);
        $task = ModelsTask::factory()->create();

        Livewire::test(Task::class)
            ->call('deleteTask', $task->id);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    // Test to verify task search functionality
    public function test_search_tasks()
    {
        $user = User::factory()->create();

        $this->generateTaskFactory($user, 'Task 1', 'description for Task 1', 'low', 0);
        $this->generateTaskFactory($user, 'Task 2', 'description for Task 2', 'high', 0);
        $this->generateTaskFactory($user, 'Task 3', 'description for Task 3', 'medium', 0);

        $this->actingAs($user);

        Livewire::test(Task::class)
            ->set('search', 'Task 1')
            ->assertSee('Task 1')
            ->assertDontSee('Task 2')
            ->assertDontSee('Task 3');
    }

    // Test to verify task filtering by priority
    public function test_filter_by_priority()
    {
        $user = User::factory()->create();

        $this->generateTaskFactory($user, 'Task 1', 'description for Task 1', 'low', 0);
        $this->generateTaskFactory($user, 'Task 2', 'description for Task 2', 'high', 0);
        $this->generateTaskFactory($user, 'Task 3', 'description for Task 3', 'medium', 0);

        $this->actingAs($user);

        Livewire::test(Task::class)
            ->set('priority', 'high')
            ->assertSee('Task 2')
            ->assertDontSee('Task 1')
            ->assertDontSee('Task 3');
    }

    // Test to verify task filtering by status
    public function test_filter_by_status()
    {
        $user = User::factory()->create();

        $this->generateTaskFactory($user, 'Task 1', 'description for Task 1', 'low', 0);
        $this->generateTaskFactory($user, 'Task 2', 'description for Task 2', 'high', 1);

        $this->actingAs($user);

        Livewire::test(Task::class)
            ->set('status', 0)
            ->assertSee('Task 1')
            ->assertDontSee('Task 2');
    }

    // Test to verify pagination functionality
    public function test_pagination()
    {
        $user = User::factory()->create();

        for ($i = 1; $i <= 15; $i++) {
            ModelsTask::create([
                'title' => 'Task ' . $i,
                'description' => 'description ' . $i,
                'user_id' => $user->id,
                'status' => 0,
                'priority' => 'low',
                'due_date' => now()->subDays(5),
                'start_date' => now(),
            ]);
        }

        $this->actingAs($user);

        Livewire::test(Task::class)
            ->assertSee('Task 1')
            ->assertSee('Task 10')
            ->assertDontSee('Task 11')
            ->assertDontSee('Task 15');
    }

    // Test to verify filtering by priority when no tasks match
    public function test_filter_by_priority_with_no_matching_tasks()
    {
        $user = User::factory()->create();

        $this->generateTaskFactory($user, 'Task 1', 'description for Task 1', 'low', 0);
        $this->generateTaskFactory($user, 'Task 2', 'description for Task 2', 'medium', 0);

        $this->actingAs($user);

        Livewire::test(Task::class)
            ->set('priority', 'high')
            ->assertDontSee('Task 1')
            ->assertDontSee('Task 2')
            ->assertSee('No tasks found');
    }

    // Helper function to generate tasks for testing
    private function generateTaskFactory(User $user, string $title, string $description, string $priority, bool $status): void
    {
        ModelsTask::factory()->create([
            'title' => $title,
            'description' => $description,
            'user_id' => $user->id,
            'priority' => $priority,
            'due_date' => now()->subDays(5),
            'status' => $status,
            'start_date' => now(),
        ]);
    }
}
