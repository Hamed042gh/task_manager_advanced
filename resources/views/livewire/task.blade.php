<div class="p-6 bg-gray-100" wire:poll >
    <div class="text-center bg-white shadow rounded-lg p-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-2">Task Management System</h2>
        <p class="text-gray-600">
            Welcome to the Task Management System. Here, you can create, manage, and track tasks effectively. 
            Use the search and filter options to find tasks by title, priority, or status. Admin users can update 
            or delete tasks as necessary.
        </p>
    </div>
    
    <!-- فرم ایجاد وظیفه (سمت راست بالا) -->
    <div class="flex justify-between items-center mb-4">
        <button wire:click="$set('showModal', true)"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add New Task</button>
    </div>
    
<!-- فرم جستجو -->
<div class="mb-4">
    <label for="search"></label>
    <input type="text" id="search" wire:model.lazy="search" placeholder="Search by Title...">
</div>
<!-- Priority Filter -->
<div class="mb-4">
    <label for="priority">Search by Priority:</label>
    <select id="priority" wire:model.lazy="priority">
        <option value="">Priority</option>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select>
</div>

<!-- Status Filter -->
<div class="mb-4">
    <label for="status">Search by Status:</label>
    <select id="status" wire:model.lazy="status">
        <option value="1">Completed</option>
        <option value="0">In Progress</option>
    </select>
</div>



@if ($showModal)
<div class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add New Task</h3>
                        <div class="mt-2 text-sm text-yellow-600">
                            <strong>Note:</strong> Once you save the task, you will not be able to modify or delete it.
                        </div>
                        <div class="mt-4">
                            <form wire:submit.prevent="createTask" class="space-y-4">
                                <div>
                                    <label for="taskTitle" class="block text-sm font-medium text-gray-700">Task Title:</label>
                                    <input type="text" id="taskTitle" wire:model="taskTitle" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="taskDescription" class="block text-sm font-medium text-gray-700">Task Description:</label>
                                    <textarea id="taskDescription" wire:model="taskDescription" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                </div>
                                <div>
                                    <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date:</label>
                                    <input type="date" id="startDate" wire:model="startDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="dueDate" class="block text-sm font-medium text-gray-700">Due Date:</label>
                                    <input type="date" id="dueDate" wire:model="dueDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority:</label>
                                    <select id="priority" wire:model="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button wire:click="$set('showModal', false)" type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endif

    <h2 class="text-2xl font-bold mb-4">Task List</h2>
    <div>
        @if($tasks->isEmpty())
            <p>No tasks found</p>
        @else
         

    
    <!-- جدول وظایف -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Task Title</th>
                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Description</th>
                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">user</th>
                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Start Date</th>
                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Due Date</th>
                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Priority</th>
                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr class="border-t border-gray-200">
                        <td class="py-2 px-4 text-sm text-gray-700">{{ $task->title }}</td>
                        <td class="py-2 px-4 text-sm text-gray-700">{{ $task->description }}</td>
                        <td class="py-2 px-4 text-sm text-gray-700">{{ $task->user->name }}</td>
                        <td class="py-2 px-4 text-sm text-gray-600">{{ $task->start_date }}</td>
                        <td class="py-2 px-4 text-sm text-gray-600">{{ $task->days_remaining }}</td>
                        <td class="py-2 px-4 text-sm text-gray-600">
                            @if($task->priority === 'low')
                                <span class="text-xs text-green-800 bg-green-200 px-2 py-1 rounded-full">Low</span>
                            @elseif($task->priority === 'medium')
                                <span class="text-xs text-yellow-800 bg-yellow-200 px-2 py-1 rounded-full">Medium</span>
                            @elseif($task->priority === 'high')
                                <span class="text-xs text-red-800 bg-red-200 px-2 py-1 rounded-full">High</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 text-sm text-gray-600">
                            @if($task->status)
                                <span class="text-xs text-green-800 bg-green-200 px-2 py-1 rounded-full">Completed</span>
                            @else
                                <span class="text-xs text-gray-800 bg-gray-200 px-2 py-1 rounded-full">Pending</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 text-sm">
                            @if(Auth::user()->role === 'admin')
                                @if (!$task->status)
                                    <button wire:click="markAsCompleted({{ $task->id }})"
                                        class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">
                                        Mark as Completed
                                    </button>
                                @endif
                                <button wire:click="deleteTask({{ $task->id }})"
                                    class="px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 ml-2">
                                    Delete Task
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
    <!-- صفحه‌بندی -->
    <div class="mt-6">
        {{ $tasks->links() }}
    </div>

</div>
