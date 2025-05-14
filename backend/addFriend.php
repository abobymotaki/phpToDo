<?php 
    include 'connections/connection.php';
    session_start();

    $sender = $_SESSION['id'];
    $receiver = filter_input(INPUT_GET, 'receiverID', FILTER_VALIDATE_INT);

    $sql = $conn->prepare("INSERT INTO friends (sender, receiver) VALUES ($sender, $receiver)");
    $sql->execute();

    $sql->close();
    $conn->close();
?>