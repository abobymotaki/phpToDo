<?php
    require '../../../backend/connections/checkAuth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/input.css" rel="stylesheet">
    <link href="../assets/output.css" rel="stylesheet">
    <title>Create a Task</title>
</head>
<body style="background-color: black;">
    <div class="flex flex-col items-center justify-center max-h-screen h-screen overflow-y-scroll">
        <form action="../../../backend/taskCreation/tasksManagement.php?method=createTask&id=<?php echo filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); ?>" class="formContainer" method="post">
            <h1 class="form-heading">ADD TASK</h1>
            <input type="text" name="task" class="form-input">
            <button class="form-submit-button">Submit</button>
        </form>
    </div>
</body>
</html>