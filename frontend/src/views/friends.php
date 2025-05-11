<?php
    require '../../../backend/connections/checkAuth.php';
    require '../components/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/input.css" rel="stylesheet">
    <link href="../assets/output.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Friends</title>
</head>
<body class="text-gray-200 bg-black">
    <div class="flex flex-col items-center justify-center ">
        <input type="text" id="search" class="bg-gray-700 border-1 border-gray-500 my-5 w-150 py-3 px-5 rounded-sm" placeholder="Search for user...">
    </div>
    <?php 
        echo '<button class="mx-15 my-5" onclick="window.location.href=\'?method=addFriend\'">Add Friend</button>';
        
        $method = filter_input(INPUT_GET, 'method');
        if ($method == 'addFriend') {
            echo '<div id="result" class="px-15"></div>';
        } else {
            echo 'You have no pending Requests! Add a friend?';
        }
    ?>
</body>
</html>
<script>
    $(document).ready(function () {
        $("#search").keyup(function() {
            $.ajax({
                url: '../../../backend/friend.php',
                type: 'post',
                data: {search: $(this).val()},
                success: function(result) {
                    $("#result").html(result);
                }
            })
        });
    });
</script>