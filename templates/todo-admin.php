<?php
use ToDoPlugin\DbSerializer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    DbSerializer::addTask($_POST);
}

$tasks = DbSerializer::getAllTasks();
?>

<div class="todo-wrapper">
    <h1>ToDo Admin</h1>
    <form method="POST">
        <div class="form-field">
            <label for="title">Title</label>
            <input type="text" name="title" />
        </div>
        <div class="form-field">
            <label for="status">Status</label>
            <input type="text" name="status" />
        </div>
        <input type="submit" value="Submit" />
    </form>

    <table>
    <?php
        if ( !empty( $tasks ) ) {
            foreach ($tasks as $task) {
                echo "<tr>";
                echo "<td>$task->id</td>";
                echo "<td>$task->title</td>";
                echo "<td>$task->status</td>";
                echo "</tr>";
            }
        }
    ?>
    </table>
</div>