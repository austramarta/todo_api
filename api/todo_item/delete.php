<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once "../../config/Database.php";
include_once "../../models/Todo_item.php";


$database = new Database();
$db = $database->connect();

$delete_item = new Todo_item($db);

$data = json_decode(file_get_contents("php://input"));
$delete_item->id = $data->id;

if ($delete_item->deleteTodo()) {
    echo json_encode(
        array("message" => "Item Deleted")
    );
} else {
    echo json_encode(
        array("message" => "Item Not Deleted")
    );
}
