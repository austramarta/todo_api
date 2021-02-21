<?php

class Todo_item
{
    private $conn;
    private $table = "todo_items";

    public $id;
    public $name;
    public $completed;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getTodoItems()
    {
        $query = "SELECT 
               id,
               name,
               completed,
               created
            FROM
                " . $this->table . "
            ORDER BY
                created DESC";

        // Prepare statement.
        $stmt = $this->conn->prepare($query);
        // Execute query.
        $stmt->execute();

        return $stmt;
    }
}
