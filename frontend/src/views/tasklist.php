<?php
    require '../../../backend/connections/checkAuth.php';
    require '../../../backend/connections/connection.php';

    $taskboard = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $sql = $conn->prepare("SELECT * FROM task_lists WHERE id = '$taskboard'");
    $sql->execute();

    $result = $sql->get_result();
    $taskboardName = $result->fetch_assoc();
    
    $sql->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/input.css" rel="stylesheet">
    <link href="../assets/output.css" rel="stylesheet">
    <title>Task List</title>
</head>
<body class="bg-black text-gray-200 px-5 pt-5">
    <div>
        <div class="grid grid-cols-3 items-center">
            <button onclick="window.location.href='taskboard.php'" class="text-left cursor-pointer">« Back</button>
            <p class="text-center text-xl font-bold"><?php echo $taskboardName['list_name'] ?></p>
            <div class="flex justify-end">
                <button class="delete-button" onclick="if(confirm('Are you sure you want to delete this task board?')) window.location.href='../../../backend/tasks/tasksManagement.php?method=deleteTaskBoard&id=<?php echo $taskboardName['id'] ?>'">Delete</button>
            </div>
        </div>
        <hr class="border-none h-1 bg-gray-700 my-5">
        <button class="create-button" onclick="window.location.href='./createTask.php?id=<?php echo $taskboardName['id'] ?>'">Add Task</button>
        <?php
            require '../../../backend/connections/connection.php';

            if (isset($_SESSION['taskCreationMessage'])) {
                echo ($_SESSION['taskCreationMessage']);
                unset($_SESSION['taskCreationMessage']);
            }
        ?>
    </div>
    <div class="">
        <?php 
            require '../../../backend/connections/connection.php';
            
            $sql = $conn->prepare("SELECT * FROM tasks WHERE taskListID = ?");
            $sql->bind_param('s', $taskboardName['id']);
            $sql->execute();

            $result = $sql->get_result();

            echo '<div class="grid grid-cols-3 gap-4">';
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    echo '<div class="task-card">';
                    echo '<span class="mb-3">' . $rows['task'] . '</span>';
                        echo '<div class="py-3 flex flex-row justify-between gap-2 w-full">';
                        echo '<button class="card-button hover:bg-lime-600"
                            onclick="window.location.href=\'../../../backend/taskCreation/tasksManagement.php?id=' . $taskboardName['id'] . '&taskID=' . $rows['id'] . '&method=changeStatus\'">';
                        if ($rows['status'] == 'pending') {
                            echo 'Complete';
                        } else {
                            echo '✔';
                        }
                        echo '</button>';
                        echo '<button name="deleteButton" class="card-button hover:bg-red-600"
                            onclick="if(confirm(\'Are you sure you want to delete this task board?\')) 
                             window.location.href=\'../../../backend/taskCreation/tasksManagement.php?id=' . $taskboardName['id'] . '&taskID=' . $rows['id'] . '&method=deleteTask\'">Delete</button>';
                        echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "There are no tasks listed with this board!";
            }
            echo '</div>';

            $sql->close();
            $conn->close();
        ?>
    </div>
</body>
</html>