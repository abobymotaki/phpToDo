<?php
    require_once '../connections/connection.php';

    session_start();
    $taskListMethod = filter_input(INPUT_GET, 'method', FILTER_SANITIZE_SPECIAL_CHARS);
    $taskBoardID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $userId = $_SESSION['id'];

    $taskName = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($taskListMethod == 'deleteTaskBoard') {
        deleteTaskBoard($conn, $taskBoardID);
    } elseif ($taskListMethod == "createTask") {
        createTask($conn, $taskBoardID, $userId, $taskName);
    } elseif ($taskListMethod == 'deleteTask') {
        deleteTask($conn, $taskBoardID);
    } elseif ($taskListMethod == 'changeStatus') {
        changeStatus($conn, $taskBoardID);
    }

    function deleteTaskBoard($conn, $id) {
        echo $id;
        
        $sql = $conn->prepare("DELETE FROM task_lists WHERE id = ?");
        $sql->bind_param('s', $id);
        $sql->execute();

        $sql->close();
        $conn->close();
        header('Location: ../../frontend/src/views/taskboard.php');
    }

    function createTask($conn, $taskBoardID, $userId, $task) {
        $sql = $conn->prepare("SELECT * FROM tasks WHERE task = ? AND taskListID = ?");
        $sql->bind_param('ss', strtolower($task), $taskBoardID);
        $sql->execute();

        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $_SESSION['taskCreationMessage'] = '<p class="error-message">This task already exists in the board!<p>';
            header('Location: ../../frontend/src/views/tasklist.php?id=' . $taskBoardID);
            exit;
        }
        $sql->close();

        $sql = $conn->prepare("INSERT INTO tasks (user_id, task, taskListID) VALUES (?, ?, ?)");
        $sql->bind_param('sss', $userId, $task, $taskBoardID);
        $sql->execute();

        $sql->close();
        $conn->close();
        $_SESSION['taskCreationMessage'] = '<p class="success-message">Successfully created Task!<p>';
        header('Location: ../../frontend/src/views/tasklist.php?id=' . $taskBoardID);
    }

    function deleteTask($conn, $taskBoardID) {
        $taskID = filter_input(INPUT_GET, 'taskID', FILTER_VALIDATE_INT);
        $_SESSION['taskCreationMessage'] = '<p class="success-message">Successfully deleted Task!<p>';

        $sql = $conn->prepare("DELETE FROM tasks WHERE id = $taskID");
        $sql->execute();

        $sql->close();
        $conn->close();
        header('Location: ../../frontend/src/views/tasklist.php?id=' . $taskBoardID);
    }

    function changeStatus($conn, $taskBoardID) {
        $taskID = filter_input(INPUT_GET, 'taskID', FILTER_VALIDATE_INT);

        $sql = $conn->prepare("SELECT status FROM tasks WHERE id = ?");
        $sql->bind_param('i', $taskID);
        $sql->execute();

        $result = $sql->get_result();
        $currentStatus = $result->fetch_assoc()['status'];
        $sql->close();

        $newStatus = ($currentStatus === 'pending') ? 'completed' : 'pending';
        $sql = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
        $sql->bind_param('si', $newStatus, $taskID);
        $sql->execute();

        $sql->close();
        header("Location: ../../frontend/src/views/tasklist.php?id=" . htmlspecialchars($taskBoardID, ENT_QUOTES, 'UTF-8'));
        exit;
    }
?>