<div class="p-6 bg-gray-100">
    <!-- فرم ایجاد وظیفه -->
    <h2 class="text-2xl font-bold mb-4">Add New Task</h2>
    <button wire:click="$set('showModal', true)"
        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add New Task</button>

    <!-- مدال ایجاد وظیفه -->
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
                                <div class="mt-2">
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

    <!-- لیست وظایف -->
    <h2 class="text-2xl font-bold mb-4">Task List</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($tasks as $task)
            <div class="w-full p-4">
                <div class="bg-white p-4 rounded shadow-md">
                    <h3 class="font-semibold text-lg">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-700">Description: {{ $task->description }}</p>
                    <p class="text-sm text-gray-600">Start Date: {{ $task->start_date }}</p>
                    <p class="text-sm text-gray-600">Due Date: {{ $task->due_date }}</p>
                    <p class="text-sm text-gray-600">Priority: {{ ucfirst($task->priority) }}</p>
                    <p class="text-sm text-gray-600">Status: {{ $task->status ? 'Completed' : 'Pending' }}</p>
                    <p class="text-sm text-gray-600">User: {{ $task->user->name }}</p>

                    <div class="mt-2">
                        @if (!$task->status)
                            <button wire:click="markAsCompleted({{ $task->id }})"
                                class="px-2 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                                Mark as Completed
                            </button>
                        @endif
                        <button wire:click="deleteTask({{ $task->id }})"
                            class="px-2 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                            Delete Task
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
