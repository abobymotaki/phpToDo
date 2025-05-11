<?php
    require '../../../backend/connections/checkAuth.php';
    include '../components/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/input.css" rel="stylesheet">
    <link href="../assets/output.css" rel="stylesheet">
    <title>Taskboards</title>
</head>
<body class="bg-black">
    <div class="bg-black max-h-screen h-auto flex flex-col px-15 py-10 text-gray-200 items-start">
        <button onclick="window.location.href='createTaskBoard.php?method=delete&id=<?php echo $_SESSION['id']; ?>'" class="open-button">Create New Taskboard</button><br>
        <?php
            require '../../../backend/connections/connection.php';

            if (isset($_SESSION['taskCreationMessage'])) {
                echo ($_SESSION['taskCreationMessage']);
                unset($_SESSION['taskCreationMessage']);
            }
        ?>
        <hr class="border-2 border-gray-800 w-full mb-5">
        <?php 
            $id = $_SESSION['id'];
            $sql = $conn->prepare("SELECT id, list_name FROM task_lists WHERE user_id = ?");
            $sql->bind_param('i', $id);

            $sql->execute();

            $result = $sql->get_result();
            echo '<div class="grid grid-cols-3 gap-4 w-full">';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="task-card hover:cursor-pointer" onclick="window.location.href=\'tasklist.php?id=' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '\'">' .
                        '<span>' . htmlspecialchars($row['list_name'], ENT_QUOTES, 'UTF-8') . '</span>' .
                        '<div></div>' .
                        '</div>';
                }
            } else {
                echo '<p class="text-gray-200">You do not have any taskboards</p>';
            }
            echo '</div>';

            $sql->close();
            $conn->close();
        ?>
    </div>
</body>
</html>