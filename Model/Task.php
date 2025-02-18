<?php
class Task{
    private $connection;

   
    public function __construct($db) {
        $this->connection = $db;
    }
    
    
public function addTask($title,$description,$due_date){

    if ($this->connection === null) {
        return false; 
    }

$query = "INSERT INTO tasks (title,description,due_date) VALUES(?,?,?)";
$stmt=$this->connection->prepare($query);
  
  if ($stmt === false) {
    return false;
}
$stmt->bind_param("sss", $title, $description, $due_date);

return $stmt->execute();
}


public function getAllTasks(){

    $query = "select *from tasks order by due_date asc";
    $stmt = $this->connection->prepare($query);
    $stmt->execute();
   return $stmt->get_result();
    

}


public function deleteTask($id){

    $query = "DELETE FROM tasks where id =?";
    $stmt = $this ->connection->prepare($query);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param("i",$id);
    return $stmt->execute();

}

public function completeTask($id){
   
    $query ="UPDATE tasks SET status ='1' where id =?";
    $stmt = $this->connection->prepare($query);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param("i",$id);
    
    return $stmt->execute();
}

public function updateTask($id, $title, $description, $due_date){
    $query ="UPDATE tasks SET title=?, description=?, due_date=? where id =?";
    $stmt = $this->connection->prepare($query);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param("sssi", $title, $description, $due_date, $id);
    return $stmt->execute();
}
}