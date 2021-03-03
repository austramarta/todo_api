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

    public function getSingleTodo()
    {
        $query = "SELECT 
                id,
                name,
                completed,
                created
            FROM
                " . $this->table . "
            WHERE 
                id = ?
            LIMIT 0, 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row["id"];
        $this->name = $row["name"];
        $this->completed = $row["completed"];
        $this->created = $row["created"];
    }

    public function createTodo()
    {
        $query = "INSERT INTO " .
            $this->table . "
            SET 
                name = :name,
                completed = :completed";

        $stmt = $this->conn->prepare($query);

        // Clean data.
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->completed = htmlspecialchars(strip_tags($this->completed));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":completed", $this->completed);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        printf("Error: %s.\n, $stmt->error");

        return false;
    }

    public function updateTodo()
    {
        $query = "UPDATE " .
            $this->table . "
            SET 
                name = :name,
                completed = :completed
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);


        // Clean data.
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->completed = htmlspecialchars(strip_tags($this->completed));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":completed", $this->completed);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
        }

        printf("Error: %s.\n, $stmt->error");

        return false;
    }

    public function deleteTodo()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n, $stmt->error");
        return false;
    }
}
