<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../models/Todo_item.php";

$database = new Database();
$db = $database->connect();

$todo_item = new Todo_item($db);

// Todo Item query
$result = $todo_item->getTodoItems();
// Get row count
$row_count = $result->rowCount();

// Check if any todo items
if ($row_count > 0) {
    // todo item array
    $todo_array = array();
    $todo_array["data"] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $todo_item = array(
            "id" => $id,
            "name" => $name,
            "completed" => $completed,
        );

        // Push to "data"
        array_push($todo_array["data"], $todo_item);
    }

    // Turn to JSON & output
    echo json_encode($todo_array);
} else {
    // No posts
    echo json_encode(
        ["message" => "No Posts Found"]
    );
}
