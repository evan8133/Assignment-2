<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f3f4f6;
        }
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4">
        <div class="w-full max-w-md mx-auto bg-white p-5 rounded-md shadow-sm">
            <div class="flex items-center space-x-5">
                <div class="flex-grow">
                    <h2 class="text-gray-900 text-lg title-font font-medium mb-1">Todo List</h2>
                </div>
                <div>
                    <input id="taskInput" type="text" placeholder="New task" class="rounded-md p-2 border-gray-300 w-full">
                    <button id="addTaskBtn" class="w-full mt-2 bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Add Task</button>
                </div>
            </div>
            <div class="overflow-auto">
                <table id="todosTable" class="mt-4 divide-y divide-gray-200">
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 bg-gray-50"></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="app.js"></script>
</body>
</html>
