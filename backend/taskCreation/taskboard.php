<?php 
    require_once '../connections/connection.php';

    session_start();
    $id = $_SESSION['id'];
    $taskBoard = filter_input(INPUT_POST, 'taskListName', FILTER_SANITIZE_SPECIAL_CHARS);
    $method = $_POST['taskListMethod'];

    if ($method == "createTaskBoard") {
        createTaskBoard($conn, $id, $taskBoard);
    } elseif ($method == 'addTaskToBoard') {
    }

    function createTaskBoard($conn, $id, $taskBoard) {
        $sql = $conn->prepare("SELECT * FROM task_lists WHERE user_id = ? AND list_name = ?");
        $sql->bind_param('ss', $id, $taskBoard);

        if (!$sql->execute()) {
            $_SESSION['taskCreationMessage'] = '<p class="error-message">Error executing search query!</p>';
            $sql->close();
            header("Location: ../../frontend/src/views/taskboard.php");
            exit;
        }

        $hasTaskBoard = $sql->get_result();
        if ($hasTaskBoard->num_rows > 0) {
            $_SESSION['taskCreationMessage'] = '<p class="error-message">Taskboard with that Name already exists! </p>';
            $sql->close();
            header("Location: ../../frontend/src/views/taskboard.php");
            exit;
        }

        $sql->close();

        $sql = $conn->prepare("INSERT INTO task_lists (user_id, list_name) VALUES (?, ?)");
        $sql->bind_param('ss', $id, $taskBoard);

        if ($sql->execute()) {
            $_SESSION['taskCreationMessage'] = '<p class="success-message">Taskboard Added Successfully!.</p>';
            $sql->close();
            header("Location: ../../frontend/src/views/taskboard.php");
            exit;
        } else {
            $_SESSION['taskCreationMessage'] = '<p class="error-message">Error adding Taskboard!' . $sql->error . '</p>';
            $sql->close();
            header("Location: ../../frontend/src/views/taskboard.php");
            exit;
        }
    }

    $conn->close();
?>