<div class="p-6 bg-gray-100">
    <!-- لیست وظایف -->
    <h2 class="text-2xl font-bold mb-4">Task List</h2>
    <ul class="list-disc list-inside mb-6">
        <li class="mb-4">
            <div>
                <h3 class="font-semibold text-lg">Task 1</h3>
                <p class="text-sm text-gray-700">Description: Fix login bug on the authentication page.</p>
                <p class="text-sm text-gray-600">Start Date: 2025-01-10</p>
                <p class="text-sm text-gray-600">Due Date: 2025-01-15</p>
                <p class="text-sm text-gray-600">Priority: High</p>
                <p class="text-sm text-gray-600">Assigned To: John Doe</p>
                <p class="text-sm text-gray-600">Status: Pending</p>
            </div>
            <div class="mt-2">
                <button class="px-2 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                    Mark as Completed
                </button>
                <button class="px-2 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                    Delete Task
                </button>
            </div>
        </li>
        <li class="mb-4">
            <div>
                <h3 class="font-semibold text-lg">Task 2</h3>
                <p class="text-sm text-gray-700">Description: Create database migrations for user roles.</p>
                <p class="text-sm text-gray-600">Start Date: 2025-01-12</p>
                <p class="text-sm text-gray-600">Due Date: 2025-01-20</p>
                <p class="text-sm text-gray-600">Priority: Medium</p>
                <p class="text-sm text-gray-600">Assigned To: Sarah Lee</p>
                <p class="text-sm text-gray-600">Status: Completed</p>
            </div>
            <div class="mt-2">
                <button class="px-2 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                    Delete Task
                </button>
            </div>
        </li>
    </ul>

    <!-- فرم ایجاد وظیفه -->
    <h2 class="text-2xl font-bold mb-4">Add New Task</h2>
    <form class="space-y-4">
        <div>
            <label for="taskName" class="block text-sm font-medium text-gray-700">Task Name:</label>
            <input type="text" id="taskName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="taskDescription" class="block text-sm font-medium text-gray-700">Task Description:</label>
            <textarea id="taskDescription" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>
        <div>
            <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="startDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="dueDate" class="block text-sm font-medium text-gray-700">Due Date:</label>
            <input type="date" id="dueDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="priority" class="block text-sm font-medium text-gray-700">Priority:</label>
            <select id="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save Task</button>
    </form>
</div>
