<?php
$host ="localhost";
$user = "root";
$password = "";
$database = "todo_db";

// Create connection

$connection = new mysqli($host, $user, $password, $database);

// Check connection
if ($connection->connect_error) {

    die("Connection failed: ". $connection->connect_error);
}