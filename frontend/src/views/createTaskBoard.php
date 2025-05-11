<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/input.css" rel="stylesheet">
    <link href="../assets/output.css" rel="stylesheet">
    <title>Create Task Board</title>
</head>
<body class="bg-black text-gray-200 px-5 pt-5">
    <div>
        <div class="">
            <button onclick="window.location.href='taskboard.php'" class="text-left cursor-pointer">« Back</button>
        </div>
        <hr class="border-none h-1 bg-gray-700 my-5">
        <div class="flex justify-center">
            <form action="../../../backend/taskCreation/taskboard.php?id=<?php echo $_SESSION['id']; ?>'" class="formContainer max-w-200" method="post">
                <h1 class="form-heading">CREATE TASKBOARD</h1>
                <hr class="border-none h-1 bg-gray-700 my-5">
                <label>Taskboard Name:</label>
                <input type="text" class="form-input" name="taskListName">
                <input type="text" class="hidden" name="taskListMethod" value="createTaskBoard">
                <button class="form-submit-button">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>