<?php

namespace App\Livewire;

use App\Models\Task as ModelsTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Task extends Component
{
    use WithPagination;

    public $search = '';  // Search term for filtering tasks by title
    public $taskTitle = '';  // Task title input
    public $taskDescription = '';  // Task description input
    public $startDate = '';  // Task start date input
    public $dueDate = '';  // Task due date input
    public $priority = 'low';  // Default priority value
    public $status = null;  // Task status filter (null means no filter)
    public $showModal = false;  // Control showing/hiding the modal

    // Validation rules for creating a new task
    protected $rules = [
        'taskTitle' => 'required|string|max:255',
        'taskDescription' => 'required|string|max:500',
        'startDate' => 'required|date',
        'dueDate' => 'required|date',
        'priority' => 'required|in:low,medium,high',
        'status' => 'nullable|boolean',  // Optional status field for filtering tasks
    ];

    /**
     * Create a new task in the database.
     */
    public function createTask()
    {
        $this->validateForm();  // Validate form input

        // Save the task in the database
        ModelsTask::create($this->taskData());

        $this->closeModal();  // Close the modal after saving
    }

    /**
     * Validate the form data.
     */
    private function validateForm()
    {
        $this->validate();  // Perform validation based on the defined rules
    }

    /**
     * Prepare task data for saving in the database.
     *
     * @return array
     */
    private function taskData(): array
    {
        return [
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'start_date' => $this->startDate,
            'due_date' => $this->dueDate,
            'priority' => $this->priority,
            'user_id' => Auth::id(),  // Assign the current user as the task owner
        ];
    }

    /**
     * Close the modal and reset the form.
     */
    private function closeModal()
    {
        $this->showModal = false;  // Hide the modal
    }

    /**
     * Mark a task as completed.
     *
     * @param int $taskId
     */
    public function markAsCompleted(int $taskId)
    {
        $task = ModelsTask::findOrFail($taskId);  // Find the task by ID

        Gate::authorize('update', $task);  // Check permission to update the task

        $task->update(['status' => true]);  // Update the task status to 'completed'
    }

    /**
     * Delete a task from the database.
     *
     * @param int $taskId
     */
    public function deleteTask(int $taskId)
    {
        $task = ModelsTask::findOrFail($taskId);  // Find the task by ID

        Gate::authorize('delete', $task);  // Check permission to delete the task

        $task->delete();  // Delete the task from the database
    }

    /**
     * Render the task list based on search filters.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $tasks = $this->searchTasks();  // Get the filtered tasks

        return view('livewire.task', [
            'tasks' => $tasks,  // Pass tasks to the view
        ]);
    }

    /**
     * Search tasks based on filters.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function searchTasks()
    {
        $query = ModelsTask::query();  // Start a query for tasks

        // Apply search filter based on task title
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        // Apply priority filter
        if ($this->priority) {
            $query->where('priority', $this->priority);
        }

        // Apply status filter
        if ($this->status !== null) {
            $query->where('status', $this->status);
        }

        return $query->paginate(10);  // Return paginated tasks (10 per page)
    }
}
