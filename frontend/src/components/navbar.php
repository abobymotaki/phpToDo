<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="grid grid-cols-3 bg-gray-900 px-15 p-10 text-gray-200 gap-x-5 gap-y-3 border-b-2 border-gray-700">
        <div class="col-span-2 flex flex-col justify-center">
            <div class="form-heading pt-5">TO-DO BOARD</div>
            <div class="space-x-5">
                <a href="../views/dashboard.php" class="hover:underline">Dashboard</a>
                <a href="../views/taskboard.php" class="hover:underline">Task Boards</a>
                <a href="../views/friends.php" class="hover:underline">Friends</a>
            </div>
        </div>
        <div class="flex flex-col items-end py-5">
            <p>Logged in as <?php echo "<b>" . htmlspecialchars($_SESSION['username']) . "</b>"; ?></p>
            <form action="../auth/logout.php" class="w-40 text-right row-span-2"><button class="logout-button">Logout</button></form>
        </div>
    </div>
</body>
</html>