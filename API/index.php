<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$dbhost = 'localhost';
$dbuser = 'root'; // replace with your MySQL user
$dbpass = ''; // replace with your MySQL password
$dbname = 'todo_app';

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($db->connect_errno) {
    die("Failed to connect to MySQL: " . $db->connect_error);
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $db->real_escape_string($_GET['id']);
            $query = "SELECT * FROM todos WHERE id='$id'";

            $result = $db->query($query);
            $todo = $result->fetch_assoc();

            echo json_encode($todo);
        } else if (isset($_GET['name'])) {
            $name = $db->real_escape_string($_GET['name']);
            $query = "SELECT * FROM todos WHERE task='$name'";

            $result = $db->query($query);
            $todos = $result->fetch_all(MYSQLI_ASSOC);

            echo json_encode($todos);
        } else {
            $query = "SELECT * FROM todos";

            $result = $db->query($query);
            $todos = $result->fetch_all(MYSQLI_ASSOC);

            echo json_encode($todos);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $task = $db->real_escape_string($data['task']);

        $query = "INSERT INTO todos (task) VALUES ('$task')";
        $db->query($query);

        echo json_encode(['status' => 'success']);
        break;

    case 'PUT':
        if (isset($_GET['id'])) {
            $id = $db->real_escape_string($_GET['id']);
            $data = json_decode(file_get_contents('php://input'), true);

            $setClauses = [];
            if (isset($data['task'])) {
                $task = $db->real_escape_string($data['task']);
                $setClauses[] = "task='$task'";
            }
            if (isset($data['completed'])) {
                $completed = intval($data['completed']);
                $setClauses[] = "completed=$completed";
            }

            if ($setClauses) {
                $setClause = implode(', ', $setClauses);
                $db->query("UPDATE todos SET $setClause WHERE id='$id'");
            }

            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
        }
        break;


    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = $db->real_escape_string($_GET['id']);

            $query = "DELETE FROM todos WHERE id='$id'";
            $db->query($query);

            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
        }
        break;
}
