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
    <title>Dashboard</title>
</head>
<body>
    <div class="bg-black max-h-screen h-screen flex px-15 py-10 text-gray-200">
        <div class="">
            <h1 class="">Logged in as <?php echo "<b>" . htmlspecialchars($_SESSION['username']) . "</b>"; ?></h1>
            <p>Your todo app dashboard.</p>
        </div>
    </div>
</body>
</html>