<?php
namespace App\Livewire;

use App\Models\Task as ModelsTask;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class Task extends Component
{
    public $taskTitle = '';
    public $taskDescription = '';
    public $startDate = '';
    public $dueDate = '';
    public $priority = 'low';
    public $tasks = [];
    public $showModal = false; 

    // تغییرات در قوانین اعتبارسنجی
    protected $rules = [
        'taskTitle' => 'required|string|max:255',
        'taskDescription' => 'required|string|max:500',
        'startDate' => 'required|date',
        'dueDate' => 'required|date',
        'priority' => 'required|in:low,medium,high',
    ];

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        // وظایف را از پایگاه داده بارگذاری می‌کند
        $this->tasks =  ModelsTask::all();  
    }

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

        // بارگذاری مجدد وظایف
        $this->loadTasks();

        // بستن مدال و ریست فرم
        $this->showModal = false;
    }


    public function render()
    {
        return view('livewire.task');
    }
}
