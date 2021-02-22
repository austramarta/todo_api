<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once "../../config/Database.php";
include_once "../../models/Todo_item.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

$update_todo = new Todo_item($db);

$data = json_decode(file_get_contents("php://input"));
$update_todo->id = $data->id;
$update_todo->name = $data->name;
$update_todo->completed = $data->completed;

//create the update_todo
if ($update_todo->updateTodo()) {
    echo json_encode(
        array("message" => "Todo Updated")
    );
} else {
    echo json_encode(
        array("message" => "Todo Not Updated")
    );
}
