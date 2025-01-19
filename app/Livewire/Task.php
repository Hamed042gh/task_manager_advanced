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

    public $search = '';
    public $taskTitle = '';
    public $taskDescription = '';
    public $startDate = '';
    public $dueDate = '';
    public $priority = 'low';
    public $showModal = false;

    protected $rules = [
        'taskTitle' => 'required|string|max:255',
        'taskDescription' => 'required|string|max:500',
        'startDate' => 'required|date',
        'dueDate' => 'required|date',
        'priority' => 'required|in:low,medium,high',
    ];

    /**
     * ذخیره یک تسک جدید در پایگاه داده
     *
     * @return void
     */
    public function createTask()
    {
        $this->validateForm();

        ModelsTask::create($this->taskData());

        $this->closeModal();
    }

    /**
     * اعتبارسنجی فرم
     *
     * @return void
     */
    private function validateForm()
    {
        $this->validate();
    }

    /**
     * داده‌های فرم را برای ذخیره تسک آماده می‌کند
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
            'user_id' => Auth::id(),
        ];
    }

    /**
     * بستن مدال و ریست فرم
     *
     * @return void
     */
    private function closeModal()
    {
        $this->showModal = false;
    }

    /**
     * علامت‌گذاری یک تسک به عنوان تکمیل‌شده
     *
     * @param int $taskId
     * @return void
     */
    public function markAsCompleted(int $taskId)
    {
        $task = ModelsTask::findOrFail($taskId);

        Gate::authorize('update', $task);

        $task->update(['status' => true]);
    }

    /**
     * حذف یک تسک از پایگاه داده
     *
     * @param int $taskId
     * @return void
     */
    public function deleteTask(int $taskId)
    {
        $task = ModelsTask::findOrFail($taskId);

        Gate::authorize('delete', $task);

        $task->delete();
    }

    /**
     * نمایش وظایف بر اساس جستجو
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $tasks = $this->searchTasks();

        return view('livewire.task', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * جستجوی وظایف
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function searchTasks()
    {
        return ModelsTask::search('title', $this->search)->paginate(10);
    }
}
