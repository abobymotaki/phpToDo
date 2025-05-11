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
    <title>Register</title>
</head>
<body>
    <div class="bg-black max-h-screen h-screen flex justify-center items-center">
        <form action="../../../backend/userhandling.php" method="POST" class="formContainer">
            <h1 class="form-heading">REGISTER</h1>
            <hr class="h-1 bg-gray-700 border-none mt-3 mb-5">
            <?php
            if (isset($_SESSION['message'])) {
                echo '<p class="text-red-500 mb-4">' . htmlspecialchars($_SESSION['message']) . '</p>';
                unset($_SESSION['message']);
            }
            ?>
            <input type="hidden" name="userHandling" value="register">
            <div class="grid grid-cols-2 gap-x-4">
                <div>
                    <label class="form-label">First Name: </label>
                    <input type="text" name="firstname" class="form-input" required><br>
                </div>
                <div>
                    <label class="form-label">Last Name: </label>
                    <input type="text" name="lastname" class="form-input" required><br>
                </div>
                <div>
                    <label class="form-label">Username: </label>
                    <input type="text" name="username" class="form-input" required><br>
                </div>
                <div>
                    <label class="form-label">Email: </label>
                    <input type="email" name="email" class="form-input" required><br>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Password: </label>
                    <input type="password" name="password" class="form-input" required><br>
                </div>
            </div>
            <button type="submit" class="form-submit-button">Submit</button>
            <p class="mt-4 text-gray-200">Already have an account? <a href="login.php" class="text-blue-500">Log in</a></p>
        </form>
    </div>
</body>
</html>