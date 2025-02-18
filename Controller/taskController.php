<?php

include "../config/database.php";
include "../Model/Task.php";

session_start();
$taskModel = new Task($connection);

if (! isset($_POST['csrf_token']) || ! isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
    throw new Exception("Invalid CSRF token");
}
function cleanInput($data)
{

    return htmlspecialchars(strip_tags(trim($data)));
}

try{

//add new task
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add_task'])){
    //validation
    $title = cleanInput($_POST['title']);

    $description = cleanInput($_POST['description']);
    $due_date = cleanInput($_POST['due_date']);
    if(empty($title) || empty($description) || empty($due_date)){

        throw new Exception("All fields are required");
    }
if($taskModel->addTask($title, $description, $due_date)){
    header("Location:../index.php");
    exit();
}
else{
    throw new Exception("Failed to add task");
}

}


//delete task
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['delete_task'])){

    $id = cleanInput($_POST['delete_task']);

    if($taskModel->deleteTask($id)){
        header("Location:../index.php");
        exit();
    }
    else{
        throw new Exception("Failed to delete task");
    }
}

//complete task

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['complete_task'])){

    $id = cleanInput($_POST['complete_task']);

    

    if($taskModel->completeTask($id)){
        header("Location:../index.php");
        exit();
    }
    else{
        throw new Exception("Failed to complete task");
    }
}

// edit task

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['edit-form'])){

    $id = cleanInput($_POST['id']);
    $title = cleanInput($_POST['title']);
  
    $description = cleanInput($_POST['description']);
    $due_date = cleanInput($_POST['due_date']);

    if ($taskModel->updateTask($id, $title, $description, $due_date)) {
        header("Location:../index.php");
        exit();
    } else {
        throw new Exception("Failed to update task");
    }
 }



}




    catch(Exception $e){
        echo $e->getMessage();
    
    }