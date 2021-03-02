<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");



include_once "../../config/Database.php";
include_once "../../models/Todo_item.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

$new_todo = new Todo_item($db);

$data = json_decode(file_get_contents("php://input"));

$new_todo->name = $data->name;
$new_todo->completed = $data->completed;

//create the new_todo
if ($new_todo->createTodo()) {
    echo json_encode(
        array("message" => "Todo Created")
    );
} else {
    echo json_encode(
        array("message" => "Todo Not Created")
    );
}
