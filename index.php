<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Form</title>
    <link rel="stylesheet" href="/assets/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<?php
    include "config/database.php";
    include "Model/Task.php";

    $taskModel = new Task($connection);
    $tasks     = $taskModel->getAllTasks();

?>
<div class="container">
    <div class="add_task_container">
        <h2>Add Task Form</h2>
        <form method="POST" action="controller/taskController.php" >
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" required>

            <button type="submit" name="add_task">Add Task</button>
        </form>
    </div>

    <div class="tasklist_container">
        <h2>Task List</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="taskTableBody">
                <!-- Dummy data -->
                <?php while ($row = $tasks->fetch_assoc()): ?>
                <tr>

                <td><?php echo $row["title"] ?></td>
                    <td><?php echo $row["description"] ?></td>
                    <td><?php echo $row["due_date"] ?></td>
                    <td>
                        <a class="action-btn edit-btn"
                        data-id="<?php echo $row["id"]?>"
                        data-title="<?php echo $row["title"]?>"
                        data-description="<?php echo $row["description"]?>"
                        data-duedate="<?php echo $row["due_date"]?>"
                        
                        ><i class="fas fa-edit"></i></a>
                        <a class="action-btn delete-btn" href="/controller/taskController.php?delete_task=<?php echo $row['id'] ?>"><i class="fas fa-trash"></i></a>
                       <?php if ($row["status"] == 0): ?>
                        <a class="action-btn " href="/controller/taskController.php?complete_task=<?php echo $row['id'] ?>"><i class="fas fa-check-circle"></i></a>
                        <?php endif?>
                    <td><?php echo $row["status"] == 0 ? "Pending" : "Complete" ?></td>
                </tr>


        <?php endwhile; ?>
                </tr>

            </tbody>
        </table>
    </div>

    <div id="editModal" class="modal">
    <div class="modal-content">
        <form action="" id ="editTaskForm">
        <span class="close"  id="close-btn" >&times;</span>
        <h2>Edit Task</h2>
        <input type="hidden" name="id" id="editTaskId" >
        <input type="hidden" name="edit-form" value="1">
<input type="text" name="title" id="editTaskTitle" placeholder="Title">
<textarea name="description" id="editTaskDescription" placeholder="Description"></textarea>
<input type="date" name="due_date" id="editTaskDueDate">
<button type="submit" name ="edit-btn">Update Task</button>
        </form>
    </div>
</div>




</div>
<script src="/assets/script.js"></script>
</body>
</html>
