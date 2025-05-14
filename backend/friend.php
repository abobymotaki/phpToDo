<?php
include 'connections/connection.php';
session_start();

if (isset($_POST['search'])) {
    $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
    $searchPattern = '%' . $search . '%';

    if (strlen($search) > 2) {
        $sql = $conn->prepare("SELECT * FROM users WHERE username LIKE ? AND id != ?");
        $sql->bind_param('ss', $searchPattern, $_SESSION['id']);
        $sql->execute();

        $result = $sql->get_result();
        
        echo '<div class="grid grid-cols-3 gap-4 py-5">';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $username = $row['username'];
                echo '<div class="task-card" onclick="window.location.href=\'../../../backend/addFriend.php?receiverID=' . $row['id'] . '\'">';
                echo $username;
                echo '</div>';
            }
        } else {
            echo "User with that name does not exist!";
        }
        echo '</div>';
    }
}
?>