<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../models/Todo_item.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$single_todo = new Todo_item($db);

$single_todo->id = isset($_GET["id"]) ? $_GET["id"] : die();

$single_todo->getSingleTodo();

$single_todo_array = array(
    "id" => $single_todo->id,
    "name" => $single_todo->name,
    "completed" => $single_todo->completed,
    "created" => $single_todo->created,
);

print_r(json_encode($single_todo_array));
