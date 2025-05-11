<?php  
    require '../../../backend/connections/checkLoggedIn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/input.css" rel="stylesheet">
    <link href="../assets/output.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="bg-black max-h-screen h-screen flex justify-center items-center">
        <form action="../../../backend/userhandling.php" method="POST" class="formContainer">
            <h1 class="form-heading">LOGIN</h1>
            <hr class="h-1 bg-gray-700 border-none mt-3 mb-5">
            <?php
            if (isset($_SESSION['message'])) {
                echo ($_SESSION['message']);
                unset($_SESSION['message']);
            }
            ?>
            <input type="hidden" name="userHandling" value="login">
            <label class="form-label">Username: </label>
            <input type="text" name="username" class="form-input" required><br>
            <label class="form-label">Password: </label>
            <input type="password" name="password" class="form-input" required><br>
            <button type="submit" class="form-submit-button">Submit</button>
            <p class="mt-4 text-gray-200">Don't have an account? <a href="register.php" class="text-blue-500">Register</a></p>
        </form>
    </div>
</body>
</html>