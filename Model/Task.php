<?php
class Task
{
    private $connection;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function addTask($title, $description, $due_date)
    {
        try {

          
            $stmt  = $this->connection->prepare("INSERT INTO tasks (title,description,due_date) VALUES(?,?,?)");

            if (! $stmt) {
                throw new Exception("Error preparing SQL statement: " . $this->connection->error);
            }
            $stmt->bind_param("sss", $title, $description, $due_date);

            return $stmt->execute();
        } catch (Exception $e) {
            echo "An error occured:" . $e->getMessage();
            return false;
        }

    }

    public function getAllTasks()
    {

        try
        {

            $stmt = $this->connection->prepare("Select * from tasks order by due_date asc");
            $stmt->execute();
            return $stmt->get_result();

        } catch (Exception $e) {
            echo "an error occured while get all tasks , error is :" . $e->getMessage();
            return false;
        }
    }

    public function deleteTask($id)
    {

        try {

            $stmt = $this->connection->prepare("DELETE FROM tasks WHERE id =?");
            if (! $stmt) {
                throw new Exception("Query preparation failed");
            }
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {

            echo "An error occured while deleting task, error is :" . $e->getMessage();
            return false;
        }

    }

    public function completeTask($id)
    {

        $stmt = $this->connection->prepare("UPDATE tasks SET status ='1' where id =?");
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function updateTask($id, $title, $description, $due_date)
    {
        try {

            $stmt = $this->connection->prepare("UPDATE tasks SET title=?, description=?, due_date=? where id =?");
            if ($stmt === false) {
                throw new Exception("Error preparing SQL statement: " . $this->connection->error);
            }
            $stmt->bind_param("sssi", $title, $description, $due_date, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "An error occured while updating task, error is :" . $e->getMessage();
            return false;
        }
    }
}
