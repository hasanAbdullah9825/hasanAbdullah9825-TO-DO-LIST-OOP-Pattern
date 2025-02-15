<?php

include "../config/database.php";
include "../Model/Task.php";

$taskModel = new Task($connection);




if(isset($_POST["add_task"])){

    $title =$_POST["title"];
    $description = $_POST["description"];
    $due_date = $_POST["due_date"];
  

   if($taskModel->addTask($title, $description, $due_date)){

    return header("Location: ../index.php");
   }
    
}


if(isset($_GET["delete_task"])){

    $id =$_GET["delete_task"];
    if($taskModel->deleteTask($id)){
        return header("Location: ../index.php");
    }
}

if(isset($_GET["complete_task"])){
    $id =$_GET["complete_task"];
    
    if($taskModel->completeTask($id)){
        return header("Location:../index.php");
    }
}
if(isset($_POST["edit-form"])){

    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];

    if ($taskModel->updateTask($id, $title, $description, $due_date)) {
        echo "Task Updated Successfully";
    } else {
        echo "Error Updating Task";
    }
    exit;
    
}

