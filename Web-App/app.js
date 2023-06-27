const API_URL = 'http://localhost/API/index.php';
const todosTable = document.getElementById('todosTable');
const taskInput = document.getElementById('taskInput');
const addTaskBtn = document.getElementById('addTaskBtn');

// Function to fetch all todos
function fetchTodos() {
    fetch(API_URL)
        .then(response => response.json())
        .then(todos => {
            // Clear the table
            todosTable.innerHTML = `
                <tr>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            `;

            // Add each todo to the table
            todos.forEach(todo => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${todo.task}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${todo.completed == 1 ? 'Done' : 'Pending'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <button onclick="editTask(${todo.id})" class="text-blue-600 hover:text-blue-800">Edit</button>
                    <button onclick="deleteTask(${todo.id})" class="text-red-600 hover:text-red-800">Delete</button>
                    <button onclick="markAsDone(${todo.id})" class="text-green-600 hover:text-green-800">Toggle</button>
                `;
                todosTable.appendChild(row);
            });
            
        });
}

function markAsDone(id) {
    fetch(`${API_URL}?id=${id}`)
        .then(response => response.json())
        .then(todo => {
            const completed = todo.completed == 1 ? 0 : 1;
            fetch(`${API_URL}?id=${id}`, {
                method: 'PUT',
                body: JSON.stringify({ completed }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(() => fetchTodos());  // Fetch all todos again
        });
}

// Function to add a new todo
function addTodo() {
    const task = taskInput.value;
    if (task) {
        fetch(API_URL, {
            method: 'POST',
            body: JSON.stringify({ task }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(() => {
            // Clear the input field and fetch all todos again
            taskInput.value = '';
            fetchTodos();
        });
    }
}

// Function to delete a todo
function deleteTask(id) {
    fetch(`${API_URL}?id=${id}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(() => fetchTodos());  // Fetch all todos again
}
// Function to edit a todo
function editTask(id) {
    // Get the new task name from the user
    const newTask = prompt('Enter the new task name');

    // Send a PUT request to update the todo
    if (newTask !== null) { // if the user didn't cancel the prompt
        fetch(`${API_URL}?id=${id}`, {
            method: 'PUT',
            body: JSON.stringify({ task: newTask}),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(() => fetchTodos());  // Fetch all todos again
    }
}

// Add click event to "Add Task" button
addTaskBtn.addEventListener('click', addTodo);

// Fetch all todos when the script is loaded
fetchTodos();
