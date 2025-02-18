<?php

include "../config/database.php";
include "../Model/Task.php";
session_start();

class TaskController
{

    private $taskModel;
    public function __construct($dbConnection)
    {
        $this->taskModel = new Task($dbConnection);
    }

    private function cleanInput($data)
    {

        return htmlspecialchars(strip_tags(trim($data)));
    }
    private function checkCsrfToken()
    {

        if (! isset($_POST['csrf_token']) || ! isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
            throw new Exception("Invalid CSRF token");
        }
    }

    public function handleRequest()
    {

        try {
           

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->checkCsrfToken();
                if (isset($_POST["add_task"])) {
                    $this->addTask();
                } elseif (isset($_POST['delete_task'])) {
                    $this->deleteTask();
                } elseif (isset($_POST['complete_task'])) {
                    $this->completeTask();
                } elseif (isset($_POST['edit-form'])) {
                    $this->editTask();
                }

            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

    private function addTask()
    {
        $title = $this->cleanInput($_POST['title']);

        $description = $this->cleanInput($_POST['description']);
        $due_date    = $this->cleanInput($_POST['due_date']);
        if (empty($title) || empty($description) || empty($due_date)) {

            throw new Exception("All fields are required");
        }
        if ($this->taskModel->addTask($title, $description, $due_date)) {
            header("Location:../index.php");
            exit();
        } else {
            throw new Exception("Failed to add task");
        }

    }

    private function deleteTask()
    {
        $id = $this->cleanInput($_POST['delete_task']);

        if ($this->taskModel->deleteTask($id)) {
            header("Location:../index.php");
            exit();
        } else {
            throw new Exception("Failed to delete task");
        }

    }

    private function completeTask()
    {
        $id = $this->cleanInput($_POST['complete_task']);
        if ($this->taskModel->completeTask($id)) {
            header("Location:../index.php");
            exit();
        } else {
            throw new Exception("Failed to complete task");
        }

    }

    private function editTask()
    {
        $id          = $this->cleanInput($_POST['id']);
        $title       = $this->cleanInput($_POST['title']);
        $description = $this->cleanInput($_POST['description']);
        $due_date    = $this->cleanInput($_POST['due_date']);

        if ($this->taskModel->updateTask($id, $title, $description, $due_date)) {
            header("Location:../index.php");
            exit();
        } else {
            throw new Exception("Failed to update task");
        }

    }
}

$controller = new TaskController($connection);

$controller->handleRequest();
