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
        include '../../../backend/connections/connection.php';

        echo '<div class="grid px-15 grid-cols-3 gap-x-4"><button class="card-button" onclick="window.location.href=\'?method=addFriend\'">Add Friend</button>';
        echo '<button class="card-button" onclick="window.location.href=\'?method=pendingRequests\'">Check Requests</button></div>';
        
        $method = filter_input(INPUT_GET, 'method');
        if ($method == 'addFriend') {
            echo '<div id="result" class="px-15"></div>';
        } else {
            $sql = $conn->prepare("SELECT * FROM friends WHERE receiver = ". $_SESSION['id'] ." && status = 'pending'");
            $sql->execute();

            $result = $sql->get_result();

            echo '<div class="px-15 pt-5">';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fetchSender = $conn->prepare("SELECT * FROM users WHERE id = " . $row['sender']);
                    $fetchSender->execute();

                    $senders = $fetchSender->get_result();

                    echo '<div class="grid grid-cols-3 gap-4">';
                    while ($sender = $senders->fetch_assoc()) {
                        echo '<div class="task-card">';
                        echo '<div class="grid grid-cols-2" items-center"><span class="form-label">Request from: </span>' . $sender['username'] . '</div>';
                            echo '<div class="grid grid-cols-2 gap-x-2 mt-3">';
                                echo '<button class="card-button">Accept</button>';
                                echo '<button class="card-button">Reject</button>';
                            echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
            } else {
                echo "You have no friend requests! Add Friend?";
            }
            echo '</div>';
            $sql->close();
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