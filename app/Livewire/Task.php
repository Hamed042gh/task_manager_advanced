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

    public $taskTitle = '';
    public $taskDescription = '';
    public $startDate = '';
    public $dueDate = '';
    public $priority = 'low';
    public $showModal = false; 

    // تغییرات در قوانین اعتبارسنجی
    protected $rules = [
        'taskTitle' => 'required|string|max:255',
        'taskDescription' => 'required|string|max:500',
        'startDate' => 'required|date',
        'dueDate' => 'required|date',
        'priority' => 'required|in:low,medium,high',
    ];
 
    /**
     * ایجاد یک تسک جدید
     *
     * این متد یک تسک جدید ایجاد می‌کند و آن را به لیست تسک‌ها اضافه می‌کند.
     *
     * @return void
     */
    public function createTask()
    {
        $this->validate();  // اعتبارسنجی انجام می‌شود

        // ذخیره وظیفه جدید در پایگاه داده
        ModelsTask::create([
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'start_date' => $this->startDate,
            'due_date' => $this->dueDate,
            'priority' => $this->priority,
            'user_id' => Auth::user()->id,
        ]);

        // بستن مدال و ریست فرم
        $this->showModal = false;
    }


    // علامت‌گذاری وظیفه به عنوان تکمیل شده
    public function markAsCompleted($taskId)
    {
        $task = ModelsTask::find($taskId);

        if (!$task) {
            return;
        }
        // بررسی مجوز کاربر برای به‌روزرسانی وظیفه
        Gate::authorize('update', $task);
        $task->update(['status' => true]);
    }


    // حذف وظیفه
    public function deleteTask($taskId)
    {
        $task = ModelsTask::find($taskId);
        if (!$task) {
            return;
        }
        // بررسی مجوز کاربر برای حذف وظیفه
        Gate::authorize('delete', $task);
        $task->delete();
    }
    public function render()
    {
        return view('livewire.task', [
            'tasks' => ModelsTask::with('user')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")  // eager loading برای بارگذاری اطلاعات کاربر
            ->paginate(6),
        ]);
    }
    
    
}
